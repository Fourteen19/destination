<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEntryRequirementsToVacanciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vacancies', function (Blueprint $table) {
            $table->string('entry_requirements', 255)->nullable()->after('description');
        });

        Schema::table('vacancies_live', function (Blueprint $table) {
            $table->string('entry_requirements', 255)->nullable()->after('description');
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
            $table->dropColumn(['entry_requirements']);
        });

        Schema::table('vacancies_live', function (Blueprint $table) {
            $table->dropColumn(['entry_requirements']);
        });
    }
}
