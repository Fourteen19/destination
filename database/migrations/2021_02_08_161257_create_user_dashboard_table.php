<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDashboardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dashboards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('slot_1')->nullable();
            $table->foreignId('slot_2')->nullable();
            $table->foreignId('slot_3')->nullable();
            $table->foreignId('slot_4')->nullable();
            $table->foreignId('slot_5')->nullable();
            $table->foreignId('slot_6')->nullable();

            $table->timestamps();

            $table->foreign('user_id')
            ->references('id')
            ->on('users');

            $table->foreign('slot_1')
            ->references('id')
            ->on('contents_live');

            $table->foreign('slot_2')
            ->references('id')
            ->on('contents_live');

            $table->foreign('slot_3')
            ->references('id')
            ->on('contents_live');

            $table->foreign('slot_4')
            ->references('id')
            ->on('contents_live');

            $table->foreign('slot_5')
            ->references('id')
            ->on('contents_live');

            $table->foreign('slot_6')
            ->references('id')
            ->on('contents_live');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('dashboards', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['slot_1']);
            $table->dropForeign(['slot_2']);
            $table->dropForeign(['slot_3']);
            $table->dropForeign(['slot_4']);
            $table->dropForeign(['slot_5']);
            $table->dropForeign(['slot_6']);
        });

        Schema::dropIfExists('dashboards');
    }
}
