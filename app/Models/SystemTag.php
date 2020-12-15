<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class SystemTag extends \Spatie\Tags\Tag
{
    use HasFactory;

    protected $table = 'tags';

    public function tags(): MorphToMany
    {
        return $this
            ->morphToMany(self::getTagClassName(), 'taggable', 'taggables', null, 'tag_id')
            ->orderBy('order_column');
    }


    /**
     * getLiveTags
     *
     * @param  String $type
     * @return void
     */
    static function getLiveTags(String $type)
    {

        $tags = SystemTag::where('type', $type)->where('live', 'Y')->get();

        return $tags;

    }

}
