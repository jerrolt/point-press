<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    $role = Role::where('name','admin')->first();
        $userAdmin = new User();
        $userAdmin->name ='J Taylor';
        $userAdmin->email = 'gene0904@gmail.com';
        $userAdmin->password = bcrypt('password');
        $userAdmin->save();
        $userAdmin->roles()->attach($role);
    }
}
