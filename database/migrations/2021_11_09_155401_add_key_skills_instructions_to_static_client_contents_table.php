<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKeySkillsInstructionsToStaticClientContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('static_client_contents', function (Blueprint $table) {
            $table->text('cv_key_skills_instructions')->nullable()->after('cv_experience_instructions');
            $table->text('cv_layout_instructions')->nullable()->after('cv_references_example');
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
            $table->dropColumn(['cv_key_skills_instructions', 'cv_layout_instructions']);
        });
    }
}
