<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
	use SoftDeletes;
	
    protected $guarded = [];
    
    /**
     * Return a collection of Post
     *
     * @return App\Post
     */
    public function post()
    {
	    return $this->belongsTo(Post::class, 'post_id');
    } 
}
