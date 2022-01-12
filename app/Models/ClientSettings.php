<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClientSettings extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id',
        'chat_app',
        'font_url', 'font_family',
        'logo_path', 'logo_alt',
        'colour_bg1', 'colour_bg2', 'colour_bg3',
        'colour_txt1', 'colour_txt2', 'colour_txt3', 'colour_txt4',
        'colour_link1', 'colour_link2',
        'colour_button1', 'colour_button2', 'colour_button3', 'colour_button4',
    ];

    public $timestamps = false;

    /**
     * Get the content
     */
    public function client()
    {
        return $this->belongsTo(App\Models\Client::class);
    }

}
