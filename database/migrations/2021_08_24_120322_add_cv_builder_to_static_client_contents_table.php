<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCvBuilderToStaticClientContentsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('static_client_contents', function (Blueprint $table) {
            $table->text('cv_introduction')->nullable()->after('featured_vacancy_4');
            $table->text('cv_useful_articles')->nullable()->after('cv_introduction');
            $table->text('cv_instructions')->nullable()->after('cv_useful_articles');
            $table->text('cv_personal_details_instructions')->nullable()->after('cv_instructions');
            $table->text('cv_personal_profile_instructions')->nullable()->after('cv_personal_details_instructions');
            $table->text('cv_personal_profile_example')->nullable()->after('cv_personal_profile_instructions');
            $table->text('cv_experience_instructions')->nullable()->after('cv_personal_profile_example');
            $table->text('cv_key_skills_example')->nullable()->after('cv_experience_instructions');
            $table->text('cv_tasks_example')->nullable()->after('cv_key_skills_example');
            $table->text('cv_education_instructions')->nullable()->after('cv_tasks_example');
            $table->text('cv_education_example')->nullable()->after('cv_education_instructions');
            $table->text('cv_additional_interests_instructions')->nullable()->after('cv_education_example');
            $table->text('cv_additional_interests_example')->nullable()->after('cv_additional_interests_instructions');
            $table->text('cv_references_instructions')->nullable()->after('cv_additional_interests_example');
            $table->text('cv_references_example')->nullable()->after('cv_references_instructions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('static_client_contents', function (Blueprint $table) {
            $table->dropColumn(['cv_introduction', 'cv_useful_articles', 'cv_personal_details_instructions', 'cv_instructions', 'cv_personal_profile_instructions', 'cv_personal_profile_example',
                                'cv_key_skills_example', 'cv_experience_instructions', 'cv_tasks_example', 'cv_education_instructions', 'cv_education_example', 'cv_additional_interests_instructions',
                                'cv_additional_interests_example', 'cv_references_instructions', 'cv_references_example']);
        });
    }
}
