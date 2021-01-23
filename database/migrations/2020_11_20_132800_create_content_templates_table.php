<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->enum('show', ['Y', 'N'])->default('N');
            $table->string('slug')->nullable();
            $table->string('slug_plural')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('content_templates');
    }
}
