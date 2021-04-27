<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWorkExperienceFieldToStaticClienttable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('static_client_contents', function (Blueprint $table) {
            $table->text('we_intro')->after('free_articles_message')->nullable();
            $table->text('we_button_text')->after('we_intro')->nullable();
            $table->foreignId('we_button_link')->after('we_button_text')->nullable();

            $table->foreign('we_button_link')
                    ->references('id')
                    ->on('pages_live')
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
            $table->dropForeign(['we_button_link']);
            $table->dropColumn(['we_intro', 'we_button_text', 'we_button_link']);
        });
    }
}
