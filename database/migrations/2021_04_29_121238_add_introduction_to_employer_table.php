<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIntroductionToEmployerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('content_employers', function (Blueprint $table) {
            $table->text('alt_block_heading')->nullable()->after('body');
            $table->text('alt_block_text')->nullable()->after('alt_block_heading');
            $table->text('lower_body')->nullable()->after('alt_block_text');
            $table->text('introduction')->nullable()->after('lower_body');
        });

        Schema::table('content_employers_live', function (Blueprint $table) {
            $table->text('alt_block_heading')->nullable()->after('body');
            $table->text('alt_block_text')->nullable()->after('alt_block_heading');
            $table->text('lower_body')->nullable()->after('alt_block_text');
            $table->text('introduction')->nullable()->after('lower_body');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('content_employers', function (Blueprint $table) {
            $table->dropColumn(['alt_block_heading', 'alt_block_text', 'lower_body', 'introduction']);
        });

        Schema::table('content_employers_live', function (Blueprint $table) {
            $table->dropColumn(['alt_block_heading', 'alt_block_text', 'lower_body', 'introduction']);
        });
    }
}
