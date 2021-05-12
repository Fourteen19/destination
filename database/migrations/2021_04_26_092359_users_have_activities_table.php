<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UsersHaveActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('content_activity_user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('content_live_id')->unsigned();
            $table->enum('completed', ['Y', 'N'])->default('N');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('content_live_id')->references('id')->on('contents');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('content_activity_user');
    }
}
