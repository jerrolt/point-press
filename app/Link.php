<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    //blacklist fields
    protected $guarded = [];
    
    /**
     * The attributes that should be blacklisted - not mass-fillable.
     *
     * @return App\User
     */
    public function posts()
    {
		return $this->belongsTo(Post::class,'post_id');   
    }
}
