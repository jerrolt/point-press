<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new Role();
        $admin->name = 'admin';
        $admin->description = 'Highest level of authorization';
        $admin->save();
        
        $journalist = new Role();
        $journalist->name = 'journalist';
        $journalist->description = 'Journalist has permission to create posts';
        $journalist->save();
        
        $user = new Role();
        $user->name = 'user';
        $user->description = 'User has permission to add comments to a post';
        $user->save();
    }
}
