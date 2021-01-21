<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class SystemTag extends \Spatie\Tags\Tag
{
    use HasFactory;

    protected $table = 'tags';


    public function scopeWithLive(Builder $query, string $liveStatus = 'Y'): Builder
    {
        return $query->where('live', $liveStatus); //->ordered()
    }


    /**
     * Filter tags by Live
     *
     * @param  mixed $type
     * @return Collection
     */
    public function tagsWithLive(string $live = 'Y'): Collection
    {
        return $this->tags->filter(function (Tag $tag) use ($type) {
            return $tag->live === '$live';
        });
    }

    /**
     *  gets the live system tags
     *
     * @param  String $type
     * @return Collection
     */
    static function getLiveTags(String $type)
    {
        return SystemTag::where('type', $type)->withLive('Y')->orderBy('order_column', 'asc')->get();
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
            ->morphToMany(SystemTag::class, 'taggable', 'taggables', null, 'tag_id')
            ->withPivot(['assessment_answer', 'score'])
            ->orderBy('order_column');
    }
}
