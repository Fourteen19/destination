<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            //$table->string('name');
            $table->uuid('uuid')->unique();
            $table->string('first_name', 50)->nullable();
            $table->string('last_name', 50)->nullable();
            $table->string('email')->unique();
            $table->string('personal_email')->unique()->nullable();
            $table->enum('type', ['user', 'admin'])->default('user');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->unsignedInteger('system_id')->nullable();
            $table->date('birth_date')->nullable();
            $table->unsignedTinyInteger('school_year')->nullable();
            $table->string('postcode', 10)->nullable();
            $table->float('roni', 8, 2)->default(0);
            $table->float('rodi', 8, 2)->default(0);
            $table->unsignedInteger('nb_logins')->default(0);
            $table->timestamp('last_login_date')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::dropIfExists('users');

    }
}
