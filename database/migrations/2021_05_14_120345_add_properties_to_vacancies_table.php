<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPropertiesToVacanciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('lookup_area', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('client_id')->unsigned();
            $table->string('name', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('client_id')->references('id')->on('clients');
        });

        Schema::create('lookup_role', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });


        Schema::table('vacancies', function (Blueprint $table) {
            $table->uuid('uuid')->unique()->after('id');
            $table->string('title', 255)->nullable()->after('uuid');
            $table->string('contact_name', 255)->nullable()->after('title');
            $table->string('contact_number', 255)->nullable()->after('contact_name');
            $table->string('contact_email', 255)->nullable()->after('contact_number');
            $table->string('contact_link', 255)->nullable()->after('contact_email');
            $table->string('employer_name', 255)->nullable()->after('contact_link');

            $table->foreignId('role_id')->after('employer_name');
            $table->foreignId('area_id')->after('role_id');

            $table->string('category', 255)->nullable()->after('area_id');
            $table->string('online_link', 255)->nullable()->after('category');
            $table->text('lead_para')->nullable()->after('online_link');
            $table->text('text')->nullable()->after('lead_para');
            $table->string('video', 255)->nullable()->after('text');
            $table->string('map', 255)->nullable()->after('video');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('role_id')
                    ->references('id')
                    ->on('lookup_role')
                    ->onDelete('restrict');

            $table->foreign('area_id')
                    ->references('id')
                    ->on('lookup_area')
                    ->onDelete('restrict');
        });


        Schema::create('vacancies_live', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vacancy_id');
            $table->uuid('uuid')->unique();
            $table->string('title', 255)->nullable();
            $table->string('contact_name', 255)->nullable();
            $table->string('contact_number', 255)->nullable();
            $table->string('contact_email', 255)->nullable();
            $table->string('contact_link', 255)->nullable();
            $table->string('employer_name', 255)->nullable();

            $table->foreignId('role_id');
            $table->foreignId('area_id');

            $table->string('category', 255)->nullable();
            $table->string('online_link', 255)->nullable();
            $table->text('lead_para')->nullable();
            $table->text('text')->nullable();
            $table->string('video', 255)->nullable();
            $table->string('map', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();

             $table->foreign('vacancy_id')
                    ->references('id')
                    ->on('vacancies')
                    ->onDelete('restrict');

            $table->foreign('role_id')
                    ->references('id')
                    ->on('lookup_role')
                    ->onDelete('restrict');

            $table->foreign('area_id')
                    ->references('id')
                    ->on('lookup_area')
                    ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {


        Schema::table('vacancies_live', function (Blueprint $table) {
            $table->dropForeign(['vacancy_id']);
            $table->dropForeign(['role_id']);
            $table->dropForeign(['area_id']);

            $table->dropColumn(['uuid', 'title', 'contact_name', 'contact_number', 'contact_email', 'contact_link', 'employer_name',
                                'category', 'online_link', 'lead_para', 'text', 'video', 'map']);
            $table->dropSoftDeletes();
        });


        Schema::table('vacancies', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropForeign(['area_id']);

            $table->dropColumn(['uuid', 'title', 'contact_name', 'contact_number', 'contact_email', 'contact_link', 'employer_name',
                                'role_id', 'area_id', 'category', 'online_link', 'lead_para', 'text', 'video', 'map']);
            $table->dropSoftDeletes();
        });

        Schema::dropIfExists('lookup_area');
        Schema::dropIfExists('lookup_role');
        Schema::dropIfExists('vacancies_live');

    }
}
