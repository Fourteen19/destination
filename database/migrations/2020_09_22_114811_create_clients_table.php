<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();
            $table->string('name')->nullable();
            $table->string('subdomain')->unique();
            $table->string('website');
            $table->string('contact');
            $table->enum('suspended', ['Y', 'N'])->default('N');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('clients_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('client_id');
            $table->text('chat_app')->nullable();
            $table->string('font', 255)->nullable();

            $table->foreign('client_id')
                    ->references('id')
                    ->on('clients')
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
        Schema::dropIfExists('clients_settings');
        Schema::dropIfExists('clients');
    }
}
