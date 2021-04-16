<?php

namespace App\Models;

use \Spatie\Tags\HasTags;
use App\Models\SystemTag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;


class SelfAssessment extends Model
{
    use HasFactory;
    use HasTags;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'year', 'career_readiness_average', 'career_readiness_score_1', 'career_readiness_score_2', 'career_readiness_score_3', 'career_readiness_score_4', 'career_readiness_score_5'
    ];



    /**
     * Overwrites `HasTags` Trait function
     *
     */
    public static function getTagClassName(): string
    {
        return SystemTag::class;
    }


    /**
     * Overwrites `HasTags` Trait function
     * override the tags() method from the trait to tell Laravel that it still needs to look for tags_id column for tags relation instead of
     * your_tag_model_id. (Here the relation would have been `system_tag_id`)
     *
     */
    public function tags(): MorphToMany
    {
        return $this
            ->morphToMany(self::getTagClassName(), 'taggable', 'taggables', null, 'tag_id')
            ->withPivot(['assessment_answer', 'score'])
            ->orderBy('order_column');
    }



    /**
     * Overwrites `HasTags` Trait function
     * Return tags filtered by `type` and LIVE
     *
     */
    public function tagsWithType(string $type = null): Collection
    {
        return $this->tags->filter(function (SystemTag $tag) use ($type) {
            return ($tag->type === $type) && ($tag->live == "Y");
        });
    }


    public function tagsWithSubjectTypeAndAssessmentScoreLessThan(string $type = null, Int $score = 0): Collection
    {
        return $this->tags->filter(function (SystemTag $tag) use ($type) {
            return ($tag->type === $type) && ($tag->live == "Y") && ($tag->pivot->assessment_answer <= 2);
        });
    }


    /**
     * new function not in  `HasTags` Trait
     * filters a collection by `type` and LIVE status
     *
     * @param  mixed $type
     * @return Collection
     */
    public function tagsWithTypeAndLive(string $type = null, string $live = 'Y'): Collection
    {
        return $this->tags->filter(function (SystemTag $tag) use ($type, $live) {
            return ($tag->type === $type) && ($tag->live == $live);
        });
    }


    /**
     * Overwrites `HasTags` Trait function
     * Saves scores in the `Taggables` table
     *
     * @param array|\ArrayAccess $tags
     * @param string|null $type
     *
     * @return $this
     */
    public function compileSubjectData($formData, string $type = null)
    {

        $tags = [];
        //loops trough the form answers and compiles a list of tag ids
        foreach($formData as $key => $value){
            $tags[] = $key;
        }

        //gets the collection of tags based on the ids passed
        $tags = collect(SystemTag::findOrCreate($tags, $type));

        $dataToSave = [];
        //compiles the list of answers and scores
        foreach($tags as $item){
            $dataToSave[ $item->id] = $formData[ $item->name ];
        }

        //saves the data, (passes the tags, the sumitted values from the form, and the type of tag)
        $this->syncTagIdsWithScore($tags->pluck('id')->toArray(), $dataToSave, $type);

       // dd($tags);
        return $this;
    }


    /**
     * Overwrites `HasTags` Trait function
     * Use in place of eloquent's sync() method so that the tag type may be optionally specified.
     *
     * @param $ids
     * @param string|null $type
     * @param bool $detaching
     */
    protected function syncTagIdsWithScore($ids, $dataToSave, string $type = null, $detaching = true)
    {

        $isUpdated = false;

        // Get a list of tag_ids for all current tags
        $current = $this->tags()
            ->newPivotStatement()
            ->where('taggable_id', $this->getKey())
            ->where('taggable_type', $this->getMorphClass())
            ->when($type !== null, function ($query) use ($type) {
                $tagModel = $this->tags()->getRelated();

                return $query->join(
                    $tagModel->getTable(),
                    'taggables.tag_id',
                    '=',
                    $tagModel->getTable().'.'.$tagModel->getKeyName()
                )
                    ->where('tags.type', $type);
            })
            ->pluck('tag_id')
            ->all();

        // Compare to the list of ids given to find the tags to remove
        $detach = array_diff($current, $ids);
        if ($detaching && count($detach) > 0) {
            $this->tags()->detach($detach);
            $isUpdated = true;
        }

        // Attach any new ids
        $attach = array_unique(array_diff($ids, $current));
        if (count($attach) > 0) {
            collect($attach)->each(function ($id) {
                $this->tags()->attach($id);
            });

            foreach($ids as $key => $item){
                $vals[$item] = ['assessment_answer' => $dataToSave[$item]['answer'], 'score' => $dataToSave[$item]['score'] ];
            }
            $this->tags()->syncWithoutDetaching($vals);

            $isUpdated = true;
        }

        // Compare to the list of ids given to find the tags to update
        $update = array_intersect($current, $ids);
        //dd($update);
        if (count($update) > 0) {
            $vals = [];
            foreach($update as $key => $item){
                $vals[$item] = ['assessment_answer' => $dataToSave[$item]['answer'], 'score' => $dataToSave[$item]['score'] ];
            }

            $this->tags()->syncWithoutDetaching($vals);
            $isUpdated = true;
        }

        // Once we have finished attaching or detaching the records, we will see if we
        // have done any attaching or detaching, and if we have we will touch these
        // relationships if they are configured to touch on any database updates.
        if ($isUpdated) {
            $this->tags()->touchIfTouching();
        }
    }




    /**
     * Overwrites `HasTags` Trait function
     * Use in place of eloquent's sync() method so that the tag type may be optionally specified.
     *
     * @param $ids
     * @param string|null $type
     * @param bool $detaching
     */
    public function syncTagsWithDefaultScoreWithType($ids, Array $defaultScore, string $type = null, $detaching = true)
    {

        $isUpdated = false;

        // Get a list of tag_ids for all current tags
        $current = $this->tags()
            ->newPivotStatement()
            ->where('taggable_id', $this->getKey())
            ->where('taggable_type', $this->getMorphClass())
            ->when($type !== null, function ($query) use ($type) {
                $tagModel = $this->tags()->getRelated();

                return $query->join(
                    $tagModel->getTable(),
                    'taggables.tag_id',
                    '=',
                    $tagModel->getTable().'.'.$tagModel->getKeyName()
                )
                    ->where('tags.type', $type);
            })
            ->pluck('tag_id')
            ->all();

        // Compare to the list of ids given to find the tags to remove
        $detach = array_diff($current, $ids);
        if ($detaching && count($detach) > 0) {
            $this->tags()->detach($detach);
            $isUpdated = true;
        }

        // Attach any new ids
        $attach = array_unique(array_diff($ids, $current));
        if (count($attach) > 0) {
            collect($attach)->each(function ($id) {
                $this->tags()->attach($id);
            });

            foreach($ids as $key => $item){
                $vals[$item] = ['assessment_answer' => 0, 'score' => $defaultScore[$key] ];
            }
            $this->tags()->syncWithoutDetaching($vals);

            $isUpdated = true;
        }

        // Compare to the list of ids given to find the tags to update
        $update = array_intersect($current, $ids);
        if (count($update) > 0) {
            $vals = [];

            foreach($update as $key => $item){
                if (isset($defaultScore[$key])){
                    $vals[$item] = ['assessment_answer' => 0, 'score' => $defaultScore[$key] ];
                }
            }

            $this->tags()->syncWithoutDetaching($vals);
            $isUpdated = true;
        }

        // Once we have finished attaching or detaching the records, we will see if we
        // have done any attaching or detaching, and if we have we will touch these
        // relationships if they are configured to touch on any database updates.
        if ($isUpdated) {
            $this->tags()->touchIfTouching();
        }
    }







    /**
     * Get the user.
     */
    public function user()
    {
        return $this->belongsTo(App\Models\User::class);
    }



}
