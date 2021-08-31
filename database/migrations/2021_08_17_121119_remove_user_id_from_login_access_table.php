<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveUserIdFromLoginAccessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('login_access', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropIndex('login_access_user_id_foreign');
            $table->dropColumn('user_id');
            $table->index(['client_id', 'institution_id', 'year_id']);
            $table->dropIndex('login_access_client_id_user_id_institution_id_year_id_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('login_access', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('year_id');

            $table->index(['client_id', 'user_id', 'institution_id', 'year_id']);
            $table->dropIndex('login_access_client_id_institution_id_year_id_index');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('restrict');
        });
    }
}
