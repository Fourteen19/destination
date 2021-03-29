<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsArticlesSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients_articles_settings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('client_id')->nullable();
            $table->unsignedTinyInteger('school_year')->nullable();

            $table->enum('dashboard_slot_1_type', ['managed', 'algorithmic'])->default('algorithmic');
            $table->foreignId('dashboard_slot_1_id')->nullable();
            $table->enum('dashboard_slot_2_type', ['managed', 'algorithmic'])->default('algorithmic');
            $table->foreignId('dashboard_slot_2_id')->nullable();
            $table->enum('dashboard_slot_3_type', ['managed', 'algorithmic'])->default('algorithmic');
            $table->foreignId('dashboard_slot_3_id')->nullable();
            $table->enum('dashboard_slot_4_type', ['managed', 'algorithmic'])->default('algorithmic');
            $table->foreignId('dashboard_slot_4_id')->nullable();
            $table->enum('dashboard_slot_5_type', ['managed', 'algorithmic'])->default('algorithmic');
            $table->foreignId('dashboard_slot_5_id')->nullable();
            $table->enum('dashboard_slot_6_type', ['managed', 'algorithmic'])->default('algorithmic');
            $table->foreignId('dashboard_slot_6_id')->nullable();

            $table->enum('article_feature_slot', ['managed', 'algorithmic'])->default('algorithmic');
            $table->foreignId('article_feature_slot_1')->nullable();

            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('restrict');
            $table->foreign('dashboard_slot_1_id')->references('id')->on('contents_live')->onDelete('SET NULL');
            $table->foreign('dashboard_slot_2_id')->references('id')->on('contents_live')->onDelete('SET NULL');
            $table->foreign('dashboard_slot_3_id')->references('id')->on('contents_live')->onDelete('SET NULL');
            $table->foreign('dashboard_slot_4_id')->references('id')->on('contents_live')->onDelete('SET NULL');
            $table->foreign('dashboard_slot_5_id')->references('id')->on('contents_live')->onDelete('SET NULL');
            $table->foreign('dashboard_slot_6_id')->references('id')->on('contents_live')->onDelete('SET NULL');

            $table->unique(['client_id', 'school_year']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients_articles_settings');
    }
}
