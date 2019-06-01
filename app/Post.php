<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
	use SoftDeletes;
	
    protected $guarded = [];

    /**
     * Returns the Journalist
     *
     * @return App\Journalist
     */
    public function journalist()
    {
	    return $this->belongsTo(Journalist::class, 'journalist_id');
    } 

    /**
     * Return a collection of Comments
     *
     * @return App\Comment
     */    
    public function comments()
    {
	    return $this->hasMany(Comment::class, 'post_id');
    }
    
    /**
     * Return a collection of Websites
     *
     * @return App\Website
     */   
    public function websites()
    {
		return $this->belongsToMany(Website::class, 'post_website', 'post_id', 'website_id');    
    }
}
