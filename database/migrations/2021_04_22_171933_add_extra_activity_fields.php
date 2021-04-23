<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraActivityFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('content_activities', function (Blueprint $table) {
            $table->text('introduction')->nullable()->after('body');
            $table->text('alt_block_heading')->nullable()->after('introduction');
            $table->text('alt_block_text')->nullable()->after('alt_block_heading');
            $table->text('lower_body')->nullable()->after('alt_block_text');
            $table->text('think_about')->nullable()->after('lower_body');
        });

        Schema::table('content_activities_live', function (Blueprint $table) {
            $table->text('introduction')->nullable()->after('body');
            $table->text('alt_block_heading')->nullable()->after('introduction');
            $table->text('alt_block_text')->nullable()->after('alt_block_heading');
            $table->text('lower_body')->nullable()->after('alt_block_text');
            $table->text('think_about')->nullable()->after('lower_body');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('content_activities', function (Blueprint $table) {
            $table->dropColumn(['introduction', 'alt_block_heading', 'alt_block_text', 'think_about', 'lower_body']);
        });

        Schema::table('content_activities_live', function (Blueprint $table) {
            $table->dropColumn(['introduction', 'alt_block_heading', 'alt_block_text', 'think_about', 'lower_body']);
        });
    }
}
