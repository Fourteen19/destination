<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddClosingDateToVacanciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vacancies', function (Blueprint $table) {
            $table->date('display_until')->nullable()->after('map');
        });

        Schema::table('vacancies_live', function (Blueprint $table) {
            $table->date('display_until')->nullable()->after('map');
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
            $table->dropColumn(['display_until']);
        });

        Schema::table('vacancies_live', function (Blueprint $table) {
            $table->dropColumn(['display_until']);
        });
    }

}
