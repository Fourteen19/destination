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
            $table->string('slug', 255)->nullable()->after('title');
            $table->string('contact_name', 255)->nullable()->after('slug');
            $table->string('contact_number', 255)->nullable()->after('contact_name');
            $table->string('contact_email', 255)->nullable()->after('contact_number');
            $table->string('contact_link', 255)->nullable()->after('contact_email');

            $table->foreignId('role_id')->nullable()->after('contact_link');
            $table->foreignId('region_id')->nullable()->after('role_id');
            $table->enum('all_clients', ['Y', 'N'])->default('N')->after('region_id');

            $table->string('category', 255)->nullable()->after('all_clients');
            $table->string('online_link', 255)->nullable()->after('category');
            $table->text('lead_para')->nullable()->after('online_link');
            $table->text('description')->nullable()->after('lead_para');
            $table->string('video', 255)->nullable()->after('description');
            $table->string('map', 255)->nullable()->after('video');
            $table->softDeletes();

            $table->foreign('role_id')
                    ->references('id')
                    ->on('vacancy_roles')
                    ->onDelete('restrict');

            $table->foreign('region_id')
                    ->references('id')
                    ->on('vacancy_regions')
                    ->onDelete('restrict');

            $table->unique(['slug', 'deleted_at']);

        });


        Schema::create('vacancies_live', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();
            $table->string('title', 255)->nullable();
            $table->string('slug', 255)->nullable();
            $table->string('contact_name', 255)->nullable();
            $table->string('contact_number', 255)->nullable();
            $table->string('contact_email', 255)->nullable();
            $table->string('contact_link', 255)->nullable();
            $table->enum('all_clients', ['Y', 'N'])->default('N');

            $table->foreignId('role_id')->nullable();
            $table->foreignId('region_id')->nullable();

            $table->string('category', 255)->nullable();
            $table->string('online_link', 255)->nullable();
            $table->text('lead_para')->nullable();
            $table->text('description')->nullable();
            $table->string('video', 255)->nullable();
            $table->string('map', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('role_id')
                    ->references('id')
                    ->on('vacancy_roles')
                    ->onDelete('restrict');

            $table->foreign('region_id')
                    ->references('id')
                    ->on('vacancy_regions')
                    ->onDelete('restrict');

            $table->unique(['slug', 'deleted_at']);

        });


        Schema::create('clients_vacancies', function (Blueprint $table) {
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('vacancy_id');

            $table->primary(['client_id', 'vacancy_id']);

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('Restrict');
            $table->foreign('vacancy_id')->references('id')->on('vacancies')->onDelete('Restrict');
        });


        Schema::create('clients_vacancies_live', function (Blueprint $table) {
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('vacancy_live_id');

            $table->primary(['client_id', 'vacancy_live_id']);

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('Restrict');
            $table->foreign('vacancy_live_id')->references('id')->on('vacancies_live')->onDelete('Restrict');
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
            $table->dropForeign(['role_id']);
            $table->dropForeign(['region_id']);
            $table->dropUnique(['slug', 'deleted_at']);


            $table->dropColumn(['uuid', 'title', 'slug', 'contact_name', 'contact_number', 'contact_email', 'contact_link',
                                'role_id', 'region_id', 'all_clients', 'category', 'online_link', 'lead_para', 'description', 'video', 'map']);

            $table->dropSoftDeletes();
        });


        Schema::table('vacancies', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropForeign(['region_id']);
            $table->dropUnique(['slug', 'deleted_at']);

            $table->dropColumn(['uuid', 'title', 'slug', 'contact_name', 'contact_number', 'contact_email', 'contact_link',
                                'role_id', 'region_id', 'all_clients', 'category', 'online_link', 'lead_para', 'description', 'video', 'map']);

            $table->dropSoftDeletes();
        });

        Schema::dropIfExists('vacancy_regions');
        Schema::dropIfExists('vacancy_roles');
        Schema::dropIfExists('clients_vacancies');
        Schema::dropIfExists('clients_vacancies_live');
        Schema::dropIfExists('vacancies_live');

    }
}
