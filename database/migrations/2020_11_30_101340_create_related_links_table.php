<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('related_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('content_id');
            $table->string('title', 255)->nullable();
            $table->string('url', 255)->nullable();
            $table->timestamps();

            $table->foreign('content_id')
                    ->references('id')
                    ->on('contents')
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
        Schema::dropIfExists('related_downloads');
    }
}
