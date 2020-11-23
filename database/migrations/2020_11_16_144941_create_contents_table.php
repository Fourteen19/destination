<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('title', 255)->nullable();
            $table->string('slug')->nullable();

            //$table->unsignedBigInteger('contentable_id');
            //$table->string('contentable_type');

            $table->morphs('contentable');

            $table->foreignId('client_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('client_id')
                    ->references('id')
                    ->on('clients')
                    ->onDelete('restrict');

            $table->index(['slug', 'client_id']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contents', function (Blueprint $table) {
            $table->dropForeign(['client_id']);
            $table->dropIndex(['slug', 'client_id']);
        });

        Schema::dropIfExists('contents');
    }
}