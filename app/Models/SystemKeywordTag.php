<?php

namespace App\Models;

use App\Models\User;
use App\Models\KeywordsTagsTotalStats;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class SystemKeywordTag extends \Spatie\Tags\Tag
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tags';

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }

/*    public function scopeWithLive(Builder $query, string $liveStatus = 'Y'): Builder
    {
        return $query->where('live', $liveStatus);
    }
*/

    public function scopeWithClient(Builder $query, string $client = NULL): Builder
    {
        return $query->where('client_id', $client);
    }


    public function scopeMatching(Builder $query, string $name, $locale = null): Builder
    {
        $locale = $locale ?? app()->getLocale();
        //"select * from `tags` where lower(json_unquote(json_extract(`name`, '$."en"'))) like ?"
        return $query->whereRaw('lower('.$this->getQuery()->getGrammar()->wrap('name->'.$locale).') = ?', [mb_strtolower($name)]);
    }

    /**
     * Filter tags by Live
     *
     * @param  mixed $type
     * @return Collection
     */
/*    public function tagsWithLive(string $live = 'Y'): Collection
    {
        return $this->tags->filter(function (Tag $tag) use ($type) {
            return $tag->live === '$live';
        });
    }
*/
    /**
     *  gets the live system tags
     *
     * @param  String $type
     * @return Collection
     */
/*    static function getLiveTags(String $type)
    {
        return SystemTag::where('type', $type)->withLive('Y')->orderBy('order_column', 'asc')->get();
    }

*/
    /**
     * Overwrites `HasTags` Trait function
     * override the tags() method from the trait to tell Laravel that it still needs to look for tags_id column for tags relation instead of
     * your_tag_model_id. (Here the relation would have been `system_tag_id`)
     *
     */
  /*  public function tags(): MorphToMany
    {
        return $this
            ->morphToMany(SystemTag::class, 'taggable', 'taggables', null, 'tag_id')
            ->withPivot(['assessment_answer', 'score'])
            ->orderBy('order_column');
    }
  */


    public function users()
    {
        return $this->belongsToMany(User::class);
    }



    public function keywordsTagsTotalStats()
    {
        return $this->hasMany(KeywordsTagsTotalStats::class, 'tag_id', 'id');
    }



    public function getKeywordsTagsTotalStats($institutionId, $clientId, $yearId)
    {
        return $this->hasMany('App\Models\KeywordsTagsTotalStats', 'tag_id', 'id')
                ->where('year_id', $yearId)
                ->where('client_id', $clientId)
                ->where('institution_id', $institutionId);
    }
}
