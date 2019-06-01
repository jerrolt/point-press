<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJournalistPlatformTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journalist_platform', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('journalist_id');
            $table->foreign('journalist_id')->references('id')->on('journalists');
            $table->unsignedInteger('platform_id');
            $table->foreign('platform_id')->references('id')->on('platforms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('journalist_platform');
    }
}
