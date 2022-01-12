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
            $table->char('colour_bg1', 9)->nullable()->default('#865e9dff')->after('chat_app');
            $table->char('colour_bg2', 9)->nullable()->default('#28334aff')->after('colour_bg1');
            $table->char('colour_bg3', 9)->nullable()->default('#ff7500ff')->after('colour_bg2');
            $table->char('colour_txt1', 9)->nullable()->default('#28334aff')->after('colour_bg3'); //$t-dark
            $table->char('colour_txt2', 9)->nullable()->default('#444444ff')->after('colour_txt1'); //$t-def
            $table->char('colour_txt3', 9)->nullable()->default('#ffffffff')->after('colour_txt2'); //$t-light
            $table->char('colour_txt4', 9)->nullable()->default('#ff7500ff')->after('colour_txt3'); //$t-alt
            $table->char('colour_link1', 9)->nullable()->default('#865e9dff')->after('colour_txt4'); //$link-def
            $table->char('colour_link2', 9)->nullable()->default('#28334aff')->after('colour_link1'); //$link-hf
            $table->char('colour_button1', 9)->nullable()->default('#e0e0e0ff')->after('colour_link2'); //$but-light-1
            $table->char('colour_button2', 9)->nullable()->default('#ffffffff')->after('colour_button1'); //$but-light-2
            $table->char('colour_button3', 9)->nullable()->default('#865e9dff')->after('colour_button2'); //$but-dark-1
            $table->char('colour_button4', 9)->nullable()->default('#28334aff')->after('colour_button3'); //$but-dark-2
            //$table->string('logo_path', 255)->nullable()->default('')->after('colour_button4');
            //$table->string('logo_alt', 255)->nullable()->default('')->after('logo_path');
            $table->text('font_url')->nullable()->default('<link rel="stylesheet" href="https://use.typekit.net/ruw0ofr.css">')->after('colour_button4');
            $table->string('font_family', 255)->nullable()->default('font-family: proxima-nova,sans-serif;')->after('font_url');

            $table->dropColumn(['font']);
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
                                //'logo_path',
                                //'logo_alt',
                                'font_url',
                                'font_family',
                            ]);
            $table->string('font', 255)->nullable();
        });


    }
}
