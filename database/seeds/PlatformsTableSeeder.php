<?php

use Illuminate\Database\Seeder;

use App\Platform;

class PlatformsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $platform = Platform::create([
			'title' => 'Counter Think',
			'description' => 'An indepedent news media platform.'
	    ]);
	    $platform = Platform::create([
			'title' => 'The Savage Nation',
			'description' => 'An indepedent news media platform.  KSFO-AM-1650'
	    ]);
	    $platform = Platform::create([
			'title' => 'The Crow House',
			'description' => 'An indepedent news media platform.'
	    ]);
    }
}
