<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Website extends Model
{
    use SoftDeletes;
	
    protected $guarded = [];
 
    /**
     * Return a the Platform
     *
     * @return App\Platform
     */
    public function platform()
    {
	    return $this->belongsTo(Platform::class, 'platform_id');
    } 
    
    /**
     * Return a collection of Posts
     *
     * @return App\Post
     */   
    public function posts()
    {
		return $this->belongsToMany(Post::class, 'post_website', 'website_id', 'post_id');    
    }
}
