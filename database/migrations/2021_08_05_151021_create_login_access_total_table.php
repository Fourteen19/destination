<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoginAccessTotalTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('login_access_total', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id');
            $table->foreignId('year_id');
            $table->bigInteger('total')->default(0);
            $table->timestamps();

            $table->foreign('client_id')
                ->references('id')
                ->on('clients')
                ->onDelete('restrict');

            $table->foreign('year_id')
                ->references('id')
                ->on('years')
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
        Schema::dropIfExists('login_access_total');
    }
}
