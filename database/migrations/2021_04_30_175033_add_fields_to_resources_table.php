<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('resources', function (Blueprint $table) {
            $table->uuid('uuid')->unique()->after('id');
            $table->string('name', 255)->nullable()->after('uuid');
            $table->text('description')->nullable()->after('name');

            $table->foreignId('uploaded_by')->nullable()->after('description');

            $table->foreign('uploaded_by')
                    ->references('id')
                    ->on('admins')
                    ->onDelete('restrict');

            $table->softDeletes();

        });


        Schema::create('client_resource', function (Blueprint $table) {
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('resource_id');

            $table->primary(['client_id', 'resource_id']);

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('Restrict');
            $table->foreign('resource_id')->references('id')->on('resources')->onDelete('Restrict');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('resources', function (Blueprint $table) {
            $table->dropForeign(['uploaded_by']);
            $table->dropColumn(['uuid', 'name', 'description', 'uploaded_by']);
            $table->dropSoftDeletes();
        });

        Schema::dropIfExists('client_resource');
    }

}
