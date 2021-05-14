<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPropertiesToVacanciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vacancies', function (Blueprint $table) {
            $table->uuid('uuid')->unique()->after('id');
            $table->string('title', 255)->nullable()->after('uuid');
            $table->string('contact_name', 255)->nullable()->after('title');
            $table->string('contact_number', 255)->nullable()->after('contact_name');
            $table->string('contact_email', 255)->nullable()->after('contact_number');
            $table->string('contact_link', 255)->nullable()->after('contact_email');
            $table->string('employer_name', 255)->nullable()->after('contact_link');


            $table->string('role_type', 255)->nullable()->after('employer_name');
            $table->string('area', 255)->nullable()->after('role_type');


            $table->string('category', 255)->nullable()->after('area');
            $table->string('online_link', 255)->nullable()->after('category');
            $table->text('lead_para')->nullable()->after('online_link');
            $table->text('text')->nullable()->after('lead_para');
            $table->string('video', 255)->nullable()->after('text');
            $table->string('map', 255)->nullable()->after('video');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vacancies', function (Blueprint $table) {
            $table->dropColumn(['uuid', 'title', 'contact_name', 'contact_number', 'contact_email', 'contact_link', 'employer_name', 'role_type', 'area',
                                'category', 'online_link', 'lead_para', 'text', 'video', 'map']);
            $table->dropSoftDeletes();
        });
    }
}
