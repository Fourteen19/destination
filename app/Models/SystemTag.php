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
     *  gets the live system tags
     *
     * @param  String $type
     * @return Collection
     */
    static function getLiveTags(String $type)
    {
        return SystemTag::where('type', $type)->withLive('Y')->orderBy('name', 'asc')->get();
    }

}
