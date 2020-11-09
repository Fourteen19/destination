<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsHaveManyInstitutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_institution', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->unsigned();
            $table->foreignId('institution_id')->unsigned();
            $table->timestamps();
            
            $table->unique(['admin_id', 'institution_id']);

            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('restrict');
            $table->foreign('institution_id')->references('id')->on('institutions')->onDelete('restrict');

        });
    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_institution');
    }
}
