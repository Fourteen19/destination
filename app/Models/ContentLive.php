<?php

namespace App\Models;

use App\Models\Content;
use \Spatie\Tags\HasTags;
use App\Models\SystemTag;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class ContentLive extends Content
{
    use HasFactory;
    use HasTags;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'title', 'body', 'uuid', 'client_id', 'slug', 'template_id', 'contentable_type', 'contentable_id', 'updated_at'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'contents_live';

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

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
     * Gets the users who have read the article
     */
    public function users()
    {
        return $this->belongsToMany(\App\Models\User::class);
    }

}
