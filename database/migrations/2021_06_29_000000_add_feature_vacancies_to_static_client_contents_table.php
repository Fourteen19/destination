<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFeatureVacanciesToStaticClientContentsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('static_client_contents', function (Blueprint $table) {
            $table->foreignId('featured_vacancy_1')->nullable()->after('no_event');
            $table->foreignId('featured_vacancy_2')->nullable()->after('featured_vacancy_1');
            $table->foreignId('featured_vacancy_3')->nullable()->after('featured_vacancy_2');
            $table->foreignId('featured_vacancy_4')->nullable()->after('featured_vacancy_3');

            $table->foreign('featured_vacancy_1')
                    ->references('id')
                    ->on('vacancies_live')
                    ->onDelete('SET NULL');

            $table->foreign('featured_vacancy_2')
                    ->references('id')
                    ->on('vacancies_live')
                    ->onDelete('SET NULL');

            $table->foreign('featured_vacancy_3')
                    ->references('id')
                    ->on('vacancies_live')
                    ->onDelete('SET NULL');

            $table->foreign('featured_vacancy_4')
                    ->references('id')
                    ->on('vacancies_live')
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
        Schema::table('static_client_contents', function (Blueprint $table) {
            $table->dropForeign(['featured_vacancy_1']);
            $table->dropForeign(['featured_vacancy_2']);
            $table->dropForeign(['featured_vacancy_3']);
            $table->dropForeign(['featured_vacancy_4']);

            $table->dropColumn(['featured_vacancy_1',
                                'featured_vacancy_2',
                                'featured_vacancy_3',
                                'featured_vacancy_4',
                            ]);
        });
    }
}
