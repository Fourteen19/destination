<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentAccessTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_access', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id');
            $table->foreignId('institution_id');
            $table->foreignId('year_id');
            $table->foreignId('user_id');
            $table->foreignId('content_id');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('restrict');

            $table->foreign('content_id')
                ->references('id')
                ->on('content')
                ->onDelete('restrict');

            $table->foreign('client_id')
                ->references('id')
                ->on('clients')
                ->onDelete('restrict');

            $table->foreign('institution_id')
                ->references('id')
                ->on('institutions')
                ->onDelete('restrict');

            $table->foreign('year_id')
                ->references('id')
                ->on('years')
                ->onDelete('restrict');

            $table->index(['client_id', 'user_id', 'institution_id', 'year_id'], 'users_access_client_institution_year_index');
        });

    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('content_access');
    }
}
