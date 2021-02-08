<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInstitutionsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('institution_id')->after('personal_email');
            $table->foreignId('client_id')->after('personal_email');

            $table->foreign('institution_id')
                ->references('id')
                ->on('institutions');

            $table->foreign('client_id')
                ->references('id')
                ->on('clients');

        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['institution_id', 'client_id']);
        });

    }
}
