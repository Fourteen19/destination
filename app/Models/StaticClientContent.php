<?php

namespace App\Models;

use App\Models\Client;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class StaticClientContent extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tel', 'email',  //contact details

        'terms', 'privacy', 'cookies', 'show_terms', 'show_privacy', 'show_cookies', //legal

        'pre_footer_heading', 'pre_footer_body', 'pre_footer_button_text', 'pre_footer_link', //public content

        'login_intro', 'welcome_intro',
        'careers_intro', 'subjects_intro', 'routes_intro', 'sectors_intro', 'assessment_completed_txt', //self assessment

        'support_block_heading', 'support_block_body', 'support_block_button_text', 'support_block_link',
        'get_in_right_heading', 'get_in_right_body', //logged in content

        'we_intro', 'we_dashboard_intro', 'we_button_text', 'we_button_link',

        'no_event',

        'featured_vacancy_1', 'featured_vacancy_2', 'featured_vacancy_3', 'featured_vacancy_4',

        'cv_introduction', 'cv_useful_articles', 'cv_instructions', 'cv_personal_details_instructions', 'cv_personal_profile_instructions', 'cv_personal_profile_example',
        'cv_experience_instructions', 'cv_key_skills_example', 'cv_tasks_example', 'cv_education_instructions', 'cv_education_example', 'cv_additional_interests_instructions',
        'cv_additional_interests_example', 'cv_references_instructions', 'cv_references_example'
    ];



    public function client()
    {
        return $this->belongsTo(Client::class);
    }


    /**
     * registerMediaCollections
     * Declares Sptie media collections for later use
     *
     * @return void
     */
    public function registerMediaCollections(): void
    {
        //for storing 1 banner
        $this->addMediaCollection('login_block_banner')->useDisk('media')->singleFile();

    }


    /**
     * registerMediaConversions
     * This conversion is applied whenever a model is saved
     *
     * @param  mixed $media
     * @return void
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('small')
              ->crop(Manipulations::CROP_CENTER, 1006, 276)
              ->performOnCollections('login_block_banner')  //perform conversion of the following collections
              ->nonQueued(); //image created directly

    }

}
