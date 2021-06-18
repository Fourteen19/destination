<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddClientIdToVacanciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vacancies', function (Blueprint $table) {
            $table->foreignId('client_id')->nullable()->after('region_id');
            $table->foreignId('updated_by')->nullable()->after('map');

            $table->foreign('client_id')
                    ->references('id')
                    ->on('clients')
                    ->onDelete('restrict');

            $table->foreign('updated_by')
                    ->references('id')
                    ->on('admins')
                    ->onDelete('restrict');
        });

        Schema::table('vacancies_live', function (Blueprint $table) {
            $table->foreignId('client_id')->nullable()->after('region_id');
            $table->foreignId('updated_by')->nullable()->after('map');

            $table->foreign('client_id')
                    ->references('id')
                    ->on('clients')
                    ->onDelete('restrict');

            $table->foreign('updated_by')
                    ->references('id')
                    ->on('admins')
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
        Schema::table('vacancies', function (Blueprint $table) {
            $table->dropForeign(['client_id']);
            $table->dropForeign(['updated_by']);
            $table->dropColumn(['client_id', 'updated_by']);
        });

        Schema::table('vacancies_live', function (Blueprint $table) {
            $table->dropForeign(['client_id']);
            $table->dropForeign(['updated_by']);
            $table->dropColumn(['client_id', 'updated_by']);
        });
    }
}
