<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaticClientContentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('static_client_contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->unique();

            //contact details
            $table->string('tel', 20)->nullable();
            $table->string('email', 255)->nullable();

            //legal
            $table->text('terms')->nullable();
            $table->text('privacy')->nullable();
            $table->text('cookies')->nullable();
            $table->enum('show_terms', ['Y','N'])->default('N');
            $table->enum('show_privacy', ['Y','N'])->default('N');
            $table->enum('show_cookies', ['Y','N'])->default('N');

            //public content
            $table->string('pre_footer_heading', 255)->nullable();
            $table->text('pre_footer_body')->nullable();
            $table->string('pre_footer_button_text', 255)->nullable();
            $table->foreignId('pre_footer_link')->nullable();

            //self assessment
            $table->text('login_intro')->nullable();
            $table->text('welcome_intro')->nullable();
            $table->text('careers_intro')->nullable();
            $table->text('subjects_intro')->nullable();
            $table->text('routes_intro')->nullable();
            $table->text('sectors_intro')->nullable();
            $table->text('assessment_completed_txt')->nullable();

            //logged in content
            $table->string('support_block_heading', 255)->nullable();
            $table->text('support_block_body')->nullable();
            $table->string('support_block_button_text', 255)->nullable();
            $table->foreignId('support_block_link')->nullable();
            $table->string('get_in_right_heading', 255)->nullable();
            $table->text('get_in_right_body')->nullable();

            //login box
            $table->string('login_block_heading', 255)->nullable();
            $table->text('login_block_body')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('client_id')
                    ->references('id')
                    ->on('clients')
                    ->onDelete('restrict');

            $table->foreign('support_block_link')
                    ->references('id')
                    ->on('pages')
                    ->onDelete('restrict');

            $table->foreign('pre_footer_link')
                    ->references('id')
                    ->on('pages')
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

        Schema::table('static_client_contents', function (Blueprint $table) {
            $table->dropForeign(['client_id', 'support_block_link', 'pre_footer_link']);
        });

        Schema::dropIfExists('static_client_contents');
    }
}
