<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinkWebsiteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('link_website', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('link_id');
            //$table->foreign('link_id')->references('id')->on('links');
            $table->unsignedInteger('website_id');
            $table->foreign('website_id')->references('id')->on('websites');
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
        Schema::dropIfExists('link_website');
    }
}
