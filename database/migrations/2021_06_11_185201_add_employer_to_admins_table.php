<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmployerToAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->foreignId('employer_id')->nullable()->after('client_id');

            $table->foreign('employer_id')
                    ->references('id')
                    ->on('employers')
                    ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('admins', function (Blueprint $table) {
            $table->dropForeign(['employer_id']);
            $table->dropColumn(['employer_id']);
        });
    }
}
