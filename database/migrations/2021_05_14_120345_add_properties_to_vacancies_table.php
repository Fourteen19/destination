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

        Schema::create('vacancy_regions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();
            $table->bigInteger('client_id')->unsigned();
            $table->string('name', 255)->nullable();
            $table->enum('display', ['Y', 'N'])->default('N');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('client_id')->references('id')->on('clients');
        });

        Schema::create('vacancy_roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();
            $table->string('name', 255)->nullable();
            $table->enum('display', ['Y', 'N'])->default('N');
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
            $table->foreignId('client_id')->after('area_id');
            $table->enum('all_clients', ['Y', 'N'])->default('N')->after('client_id');

            $table->string('category', 255)->nullable()->after('all_clients');
            $table->string('online_link', 255)->nullable()->after('category');
            $table->text('lead_para')->nullable()->after('online_link');
            $table->text('text')->nullable()->after('lead_para');
            $table->string('video', 255)->nullable()->after('text');
            $table->string('map', 255)->nullable()->after('video');
            $table->softDeletes();

            $table->foreign('role_id')
                    ->references('id')
                    ->on('vacancy_roles')
                    ->onDelete('restrict');

            $table->foreign('area_id')
                    ->references('id')
                    ->on('vacancy_regions')
                    ->onDelete('restrict');

            $table->foreign('client_id')
                    ->references('id')
                    ->on('clients')
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
            $table->enum('all_clients', ['Y', 'N'])->default('N');

            $table->foreignId('role_id');
            $table->foreignId('area_id');
            $table->foreignId('client_id');

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
                    ->on('vacancy_roles')
                    ->onDelete('restrict');

            $table->foreign('area_id')
                    ->references('id')
                    ->on('vacancy_regions')
                    ->onDelete('restrict');

            $table->foreign('client_id')
                    ->references('id')
                    ->on('clients')
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
            $table->dropForeign(['client_id']);

            $table->dropColumn(['uuid', 'title', 'contact_name', 'contact_number', 'contact_email', 'contact_link', 'employer_name',
                                'role_id', 'area_id', 'client_id', 'all_clients', 'category', 'online_link', 'lead_para', 'text', 'video', 'map']);
            $table->dropSoftDeletes();
        });


        Schema::table('vacancies', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropForeign(['area_id']);
            $table->dropForeign(['client_id']);

            $table->dropColumn(['uuid', 'title', 'contact_name', 'contact_number', 'contact_email', 'contact_link', 'employer_name',
                                'role_id', 'area_id', 'client_id', 'all_clients', 'category', 'online_link', 'lead_para', 'text', 'video', 'map']);

            $table->dropSoftDeletes();
        });

        Schema::dropIfExists('vacancy_regions');
        Schema::dropIfExists('vacancy_roles');
        Schema::dropIfExists('vacancies_live');

    }
}
