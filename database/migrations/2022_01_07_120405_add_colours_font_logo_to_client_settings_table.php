<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColoursFontLogoToClientSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('client_settings', function (Blueprint $table) {
            $table->char('colour_bg1', 7)->nullable()->default('#865e9d')->after('chat_app');
            $table->char('colour_bg2', 7)->nullable()->default('#28334a')->after('colour_bg1');
            $table->char('colour_bg3', 7)->nullable()->default('#ff7500')->after('colour_bg2');
            $table->char('colour_txt1', 7)->nullable()->default('#28334a')->after('colour_bg3'); //$t-dark
            $table->char('colour_txt2', 7)->nullable()->default('#444444')->after('colour_txt1'); //$t-def
            $table->char('colour_txt3', 7)->nullable()->default('#ffffff')->after('colour_txt2'); //$t-light
            $table->char('colour_txt4', 7)->nullable()->default('#ff7500')->after('colour_txt3'); //$t-alt
            $table->char('colour_link1', 7)->nullable()->default('#865e9d')->after('colour_txt4'); //$link-def
            $table->char('colour_link2', 7)->nullable()->default('#28334a')->after('colour_link1'); //$link-hf
            $table->char('colour_button1', 7)->nullable()->default('#e0e0e0')->after('colour_link2'); //$but-light-1
            $table->char('colour_button2', 7)->nullable()->default('#ffffff')->after('colour_button1'); //$but-light-2
            $table->char('colour_button3', 7)->nullable()->default('#865e9d')->after('colour_button2'); //$but-dark-1
            $table->char('colour_button4', 7)->nullable()->default('#28334a')->after('colour_button3'); //$but-dark-2
            $table->string('logo_path', 255)->nullable()->default('')->after('colour_button4');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('client_settings', function (Blueprint $table) {
            $table->dropColumn(['colour_bg1',
                                'colour_bg2',
                                'colour_bg3',
                                'colour_txt1',
                                'colour_txt2',
                                'colour_txt3',
                                'colour_txt4',
                                'colour_link1',
                                'colour_link2',
                                'colour_button1',
                                'colour_button2',
                                'colour_button3',
                                'colour_button4',
                                'logo_path',
                            ]);
        });
    }
}
