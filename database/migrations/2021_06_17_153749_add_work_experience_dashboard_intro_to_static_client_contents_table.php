<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWorkExperienceDashboardIntroToStaticClientContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('static_client_contents', function (Blueprint $table) {
            $table->text('we_dashboard_intro')->nullable()->after('we_intro');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('static_client_contents', function (Blueprint $table) {
            $table->dropColumn(['we_dashboard_intro']);
        });
    }
}
