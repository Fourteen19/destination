<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTablePageStandardChangeLeadPara extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::statement('ALTER TABLE page_standard MODIFY lead TEXT;');
        DB::statement('ALTER TABLE page_standard_live MODIFY lead TEXT;');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE page_standard MODIFY lead VARCHAR(255);');
        DB::statement('ALTER TABLE page_standard_live MODIFY lead VARCHAR(255);');
    }
}
