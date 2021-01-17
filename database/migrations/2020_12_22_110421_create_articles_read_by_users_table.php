<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesReadByUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_live_user', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('content_live_id');
            $table->unsignedTinyInteger('school_year');
            $table->unsignedInteger('nb_read')->default(1);
            $table->dateTime('feedback_date')->nullable();
            $table->enum('feedback', ['Y', 'N'])->nullable();
            $table->timestamps();

            $table->primary(['user_id', 'content_live_id', 'school_year']);

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('content_live_id')->references('id')->on('contents_live');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('content_live_user');
    }
}
