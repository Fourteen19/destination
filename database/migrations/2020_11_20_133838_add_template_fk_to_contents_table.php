<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTemplateFkToContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contents', function (Blueprint $table) {

            $table->string('slug')->unique()->after('uuid');

            $table->foreignId('template_id')->nullable()->after('client_id');

            $table->foreign('template_id')
                    ->references('id')
                    ->on('content_templates')
                    ->onDelete('restrict');

            $table->string('class_name')->after('template_id');

        });

        //drop columns as they will be moved to the specific content tables
        if (Schema::hasColumn('contents', 'title')) {

            Schema::table('contents', function (Blueprint $table) {
                $table->dropColumn('title');
                $table->dropColumn('body');
            });
        };

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        if (Schema::hasColumn('contents', 'template_id')) {
            Schema::table('contents', function (Blueprint $table) {
                $table->dropForeign(['template_id']);
                $table->dropColumn('template_id');
            });
        };


        if (Schema::hasColumn('contents', 'slug')) {
            Schema::table('contents', function (Blueprint $table) {
                $table->dropColumn('slug');
            });
        };


        if (Schema::hasColumn('contents', 'class_name')) {
            Schema::table('contents', function (Blueprint $table) {
                $table->dropColumn('class_name');
            });
        };



        if (!Schema::hasColumn('contents', 'title')) {
            Schema::table('contents', function (Blueprint $table) {
                $table->string('title', 255)->nullable();
                $table->text('body')->nullable();
            });
        };

    }
}
