<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('site_id');
            $table->string('banner_path_1', 100)->nullable();
            $table->string('banner_1_title', 100)->nullable();
            $table->string('banner_1_description', 100)->nullable();
            $table->string('banner_path_2', 100)->nullable();
            $table->string('banner_2_title', 100)->nullable();
            $table->string('banner_2_description', 100)->nullable();
            $table->string('banner_path_3', 100)->nullable();
            $table->string('banner_3_title', 100)->nullable();
            $table->string('banner_3_description', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
