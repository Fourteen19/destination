<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEventsNotificationToStaticClientContentsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('static_client_contents', function (Blueprint $table) {
            $table->text('event_email_notification')->nullable()->after('featured_vacancy_3');
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
            $table->dropColumn(['event_email_notification']);
        });
    }

}
