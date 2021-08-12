<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmployerToVacanciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vacancies', function (Blueprint $table) {
            $table->foreignId('employer_id')->nullable()->after('contact_link');

            $table->foreign('employer_id')
                    ->references('id')
                    ->on('employers')
                    ->onDelete('SET NULL');
        });

        Schema::table('vacancies_live', function (Blueprint $table) {
            $table->foreignId('employer_id')->nullable()->after('contact_link');

            $table->foreign('employer_id')
                    ->references('id')
                    ->on('employers')
                    ->onDelete('SET NULL');
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
            $table->dropForeign(['employer_id']);
            $table->dropColumn(['employer_id']);
        });

        Schema::table('vacancies_live', function (Blueprint $table) {
            $table->dropForeign(['employer_id']);
            $table->dropColumn(['employer_id']);
        });
    }
}
