<?php

namespace App\Models;

use App\Models\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StaticClientContent extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tel', 'email',  //contact details

        'terms', 'privacy', 'cookie', //legal

        'pre_footer_heading', 'pre_footer_body', 'pre_footer_button_text', 'pre_footer_link', //public content

        'login_intro', 'welcome_intro',
        'careers_intro', 'subjects_intro', 'routes_intro', 'sectors_intro', 'assessment_completed_txt', //self assessment

        'support_block_heading', 'support_block_body', 'support_block_button_text', 'support_block_link',
        'get_in_right_heading', 'get_in_right_body', //logged in content
    ];



    public function client()
    {
        return $this->belongsTo(Client::class);
    }

}
