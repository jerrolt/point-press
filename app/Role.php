<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $guarded = [];
    
    /**
     * The attributes that should be blacklisted - not mass-fillable.
     *
     * @return App\User
     */
    public function users()
    {
		return $this->belongsToMany(User::class, 'role_user', 'role_id', 'user_id');   
    }
}
