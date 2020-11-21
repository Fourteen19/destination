<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Spatie\Tags\HasTags;

class Content extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasTags;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'body', 'uuid', 'client_id'
    ];


    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }


    /**
     * Get the client record associated with the content.
     */
    public function client()
    {
        return $this->hasOne('App\Models\Client');
    }


    /**
     * Get the template record associated with the content.
     */
    public function contentTemplate()
    {
        return $this->hasOne('App\Models\ContentTemplate');
    }


    /**
     * Get the article record associated with the content.
     */
    public function contentArticle()
    {
        return $this->hasOne('App\Models\ContentArticle');
    }


    /**
     * Get the accordion record associated with the content.
     */
 /*   public function contentAccordion()
    {
        return $this->hasOne('App\Models\ContentArticle');
    }
*/

    /**
     * Get the accordion record associated with the content.
     */
  /*  public function contentPoll()
    {
        return $this->hasOne('App\Models\ContentPoll');
    }
*/

    /**
     * Get the accordion record associated with the content.
     */
 /*   public function contentActivity()
    {
        return $this->hasOne('App\Models\ContentActivity');
    }
    */
}
