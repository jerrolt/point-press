<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            
            $table->unsignedInteger('journalist_id');  
            $table->foreign('journalist_id')->references('id')->on('journalists');
                                        
            $table->string('title', 100)->nullable(false);
            $table->string('href', 50)->nullable(false);
            $table->text('content')->nullable(false);             
            $table->enum('status', ['pending', 'approved', 'disapproved', 'enabled', 'disabled'])->default('pending');
            $table->unsignedInteger('likes')->default(0);   
            $table->unsignedInteger('dislikes')->default(0);          
            $table->date('date_posted')->useCurrent();  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
