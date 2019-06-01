<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Platform extends Model
{
    use SoftDeletes;
    
    protected $guarded = [];
    
    /**
     * Return a collection of Journalists
     *
     * @return App\Journalist
     */   
    public function journalists()
    {
		return $this->belongsToMany(Journalist::class, 'journalist_platform', 'platform_id', 'journalist_id');    
    }
    
    /**
     * Return a collection of Websites
     *
     * @return App\Website
     */    
    public function websites()
    {
	    return $this->hasMany(Website::class, 'platform_id');
    }
}
