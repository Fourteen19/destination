<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIntroductionToAdminInstitutionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin_institution', function (Blueprint $table) {
            $table->text('introduction')->nullable()->after('institution_id');
            $table->text('times_location')->nullable()->after('introduction');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admin_institution', function (Blueprint $table) {
            $table->dropColumn(['introduction', 'times_location']);
        });

    }
}
