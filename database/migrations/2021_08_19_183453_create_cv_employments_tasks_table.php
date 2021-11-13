<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCvEmploymentsTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cv_employments_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cv_employment_id');
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('cv_employment_id')
                ->references('id')
                ->on('cv_employments')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cv_employments_tasks');
    }
}
