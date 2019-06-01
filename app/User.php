<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    /**
     * The attributes that should be blacklisted (non mass-fillable).
     *
     * @return App\Role Collection
     */
    public function roles()
    {
	    // Role::class or App\Role
		return $this->belongsToMany('App\Role', 'role_user', 'user_id', 'role_id');   
    }
        
    /**
	 *	@param string|array $roles
	 */
	public function authorizeRoles($roles)
	{
		if(is_array($roles))
		{
			return $this->hasAnyRole($roles) || abort(401,'Unauthorized Action');
		}
		return $this->hasRole($roles) || abort(401,'Unauthorized Action');
	}
	 
    /**
	 *	Check against multiple roles
	 *
	 *	@param string|array $roles
	 */	 
	public function hasAnyRole($roles)
	{
		return null !== $this->roles()->whereIn('name', $roles)->first();
	}
	 
    /**
	 *	@param string|array $roles
	 */	 
	public function hasRole($role)
	{
		return null !== $this->roles()->where('name', $role)->first();
	}
	 
}
