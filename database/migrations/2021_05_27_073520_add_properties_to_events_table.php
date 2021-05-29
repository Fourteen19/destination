<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPropertiesToEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('events', function (Blueprint $table) {
            $table->uuid('uuid')->unique()->after('id');
            $table->string('title', 255)->nullable()->after('uuid');
            $table->string('slug', 255)->nullable()->after('title');
            $table->date('date')->nullable()->after('slug');
            $table->string('start_time_hour', 2)->default(0)->nullable()->after('date');
            $table->string('start_time_min', 2)->default(0)->nullable()->after('start_time_hour');
            $table->string('end_time_hour', 2)->default(0)->nullable()->after('start_time_min');
            $table->string('end_time_min', 2)->default(0)->nullable()->after('end_time_hour');
            $table->string('venue_name', 255)->nullable()->after('end_time_min');
            $table->string('town', 255)->nullable()->after('venue_name');
            $table->string('contact_name', 255)->nullable()->after('town');
            $table->string('contact_number', 255)->nullable()->after('contact_name');
            $table->string('contact_email', 255)->nullable()->after('contact_number');
            $table->string('booking_link', 255)->nullable()->after('contact_email');

            $table->enum('all_clients', ['Y', 'N'])->default('N')->after('booking_link');

            $table->text('lead_para')->nullable()->after('all_clients');
            $table->text('description')->nullable()->after('lead_para');
            $table->string('video', 255)->nullable()->after('description');
            $table->string('map', 255)->nullable()->after('video');
            $table->enum('summary_image_type', ['Automatic', 'Custom'])->default('Automatic')->after('map');
            $table->string('summary_heading', 255)->nullable()->after('summary_image_type');
            $table->text('summary_text')->nullable()->after('summary_heading');
            $table->foreignId('updated_by')->nullable()->after('summary_text');;

            $table->softDeletes();

            $table->unique(['slug', 'deleted_at']);

            $table->foreign('updated_by')
                ->references('id')
                ->on('admins')
                ->onDelete('restrict');
        });


        Schema::create('events_live', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();
            $table->string('title', 255)->nullable();
            $table->string('slug', 255)->nullable();
            $table->date('date')->nullable();
            $table->string('start_time_hour', 2)->default(0)->nullable();
            $table->string('start_time_min', 2)->default(0)->nullable();
            $table->string('end_time_hour', 2)->default(0)->nullable();
            $table->string('end_time_min', 2)->default(0)->nullable();
            $table->string('venue_name', 255)->nullable();
            $table->string('town', 255)->nullable();
            $table->string('contact_name', 255)->nullable();
            $table->string('contact_number', 255)->nullable();
            $table->string('contact_email', 255)->nullable();
            $table->string('booking_link', 255)->nullable();

            $table->enum('all_clients', ['Y', 'N'])->default('N');

            $table->text('lead_para')->nullable();
            $table->text('description')->nullable();
            $table->string('video', 255)->nullable();
            $table->string('map', 255)->nullable();
            $table->enum('summary_image_type', ['Automatic', 'Custom'])->default('Automatic');
            $table->string('summary_heading', 255)->nullable();
            $table->text('summary_text')->nullable();
            $table->foreignId('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['slug', 'deleted_at']);

            $table->foreign('updated_by')
                ->references('id')
                ->on('admins')
                ->onDelete('restrict');

        });


        Schema::create('clients_events', function (Blueprint $table) {
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('event_id');

            $table->primary(['client_id', 'event_id']);

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('Restrict');
            $table->foreign('event_id')->references('id')->on('events')->onDelete('Restrict');
        });


        Schema::create('clients_events_live', function (Blueprint $table) {
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('event_id');

            $table->primary(['client_id', 'event_id']);

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('Restrict');
            $table->foreign('event_id')->references('id')->on('events_live')->onDelete('Restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::dropIfExists('clients_events');
        Schema::dropIfExists('clients_events_live');
        Schema::dropIfExists('events_live');

        Schema::table('events', function (Blueprint $table) {

            $table->dropUnique(['slug', 'deleted_at']);
            $table->dropForeign(['updated_by']);

            $table->dropColumn(['uuid', 'title', 'slug', 'date', 'start_time_hour', 'start_time_min', 'end_time_hour', 'end_time_min',
                                'venue_name', 'town', 'contact_name', 'contact_number', 'contact_email', 'booking_link',
                                'all_clients', 'lead_para', 'description', 'video', 'map', 'summary_image_type', 'summary_heading', 'summary_text', 'updated_by']);

            $table->dropSoftDeletes();
        });


    }
}
