<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Journalist extends Model
{
    use SoftDeletes;
    
    /**
	 *  
	 *	$fillable - a whitelist... attributes that are mass assignable. 
     * 	$hidden   -
     *	$guarded  - a blacklist... attributes that aren't mass assignable.
     *
     */	
    protected $guarded = [];
    
    /**
     * Return a collection of Posts
     *
     * @return App\Post
     */    
    public function posts()
    {
	    return $this->hasMany(Post::class, 'journalist_id');
    }
    
    /**
     * Return a collection of Platforms
     *
     * @return App\Platform
     */    
    public function platforms()
    {
		return $this->belongsToMany(Platform::class, 'journalist_platform', 'journalist_id', 'platform_id');    
    }
}
