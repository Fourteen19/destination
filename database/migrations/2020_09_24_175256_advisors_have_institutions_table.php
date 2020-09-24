<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdvisorsHaveInstitutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_institution', function (Blueprint $table) {
            
            $table->bigIncrements('id');
            
            $table->foreignId('admin_id')->unsigned()->index();
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
            
            $table->foreignId('institution_id')->unsigned()->index();
            $table->foreign('institution_id')->references('id')->on('institutions')->onDelete('cascade');

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
