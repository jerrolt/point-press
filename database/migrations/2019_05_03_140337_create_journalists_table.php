<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJournalistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journalists', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            
            $table->string('firstname', 50);
            $table->string('lastname', 50);            
            $table->string('title', 100)->nullable();                       
            
            $table->string('youtube', 100)->nullable();
            $table->string('twitter', 100)->nullable();
            $table->string('facebook', 100)->nullable();
            $table->string('instagram', 100)->nullable();           
            $table->string('steemit', 100)->nullable();
            $table->string('bitchute', 100)->nullable();

              
            /** 
	            For options, crawl: 
	            https://en.wikipedia.org/wiki/List_of_political_parties_in_the_United_States 
	        **/
            $table->string('political_party', 100)->default('independent');                      
            $table->unsignedInteger('likes')->default(0);   
            $table->unsignedInteger('dislikes')->default(0);        
            $table->text('description')->nullable();   
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('journalists');
    }
}
