<?php

use Illuminate\Database\Seeder;

use App\Journalist;
use App\Platform;
use App\Website;

class JournalistsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    $platform = Platform::create([
			'title' => 'Info Wars',
			'description' => 'Indepedent Media Platform'
	    ]);	        
	    	    
	    //Journalists
		$journalist = Journalist::create([
	        'firstname' 	  => 'Alex',
	        'lastname'		  => 'Jones',
	        'title'     	  => 'Infowars Reporter & Journalist',
	        'description'	  => 'https://rationalwiki.org/wiki/Alex_Jones',
	        
	        'political_party' => 'independent',
	        'facebook'		  => 'https://www.facebook.com/realalexjones',
	        'twitter'		  => 'https://twitter.com/hashtag/alexjones',
	        'instagram'	      => 'https://www.instagram.com/real_alexjones',
        ]);
        $platform->journalists()->attach($journalist); 
        
        $journalist = Journalist::create([
	        'firstname' 	  => 'David',
	        'lastname'		  => 'Knight',
	        'title'     	  => 'Infowars Reporter & Journalist',
	        'description'     => 'Real News with David Knight host, weekdays at 8am - 11am',
	        'political_party' => 'independent',
        ]); 
        $platform->journalists()->attach($journalist); 
        
        $journalist = Journalist::create([
	        'firstname' 	  => 'Owen',
	        'lastname'		  => 'Shroyer',
	        'title'     	  => 'Infowars Reporter & Journalist',
	        'description'	  => 'The WarRoom host, weekdays at 3pm - 6pm',
	        'political_party' => 'independent',
	    ]); 
	    $platform->journalists()->attach($journalist);
        
        $journalist = Journalist::create([
	        'firstname' 	  => 'Millie',
	        'lastname'		  => 'Weaver',
	        'title'     	  => 'Infowars Reporter & Journalist',
	        'description'	  => 'Infowars Reporter & Journalist',
	        'facebook'		  => 'https://www.facebook.com/MillennialMillie',
	        'twitter'		  => 'https://twitter.com/millie__weaver',
	        'instagram'	      => 'https://www.instagram.com/millieweaver',
	        'political_party' => 'independent',
        ]);
		$platform->journalists()->attach($journalist);

        $website = Website::create([
	        'platform_id' => $platform->id,
	        'name' => 'InfoWars',
	        'url'  => 'https://www.infowars.com',
	        'description' => 'Indepedent Media Platform'
        ]);
        
        
        /*------------------------------------------------------------------------*/
	    $platform = Platform::create([
			'title' => 'Freedom Radio',
			'description' => 'Independent Media - video and podcast'
	    ]);

		$journalist = Journalist::create([
	        'firstname' 	  => 'Stefan',
	        'lastname'		  => 'Molyneux',
	        'title'     	  => 'FreedomRadio Journalist',
	        'description'	  => 'FreedomRadio reporter and journalist funded completely by listeners',
	        'political_party' => 'independent',
	        'facebook'		  => 'https://www.facebook.com/stefan.molyneux',
	        'twitter'		  => 'https://twitter.com/stefanmolyneux',
	        'instagram'	      => 'https://www.instagram.com/stefanmolyneux',
	        
        ]);
        $platform->journalists()->attach($journalist);             
        
		$record = [
	        'platform_id' => $platform->id,
	        'name' => 'FreedomRadio Newsletter',
	        'url'  => 'https://www.fdrurl.com/newsletter',
	        'description' => 'Indepedent Media Platform'
        ];
        $website = Website::create($record);
        
        $record = [
	        'platform_id' => $platform->id,
	        'name' => 'FreedomRadio Donations',
	        'url'  => 'https://www.freedomainradio.com.com/donate',
	        'description' => 'Freedom Radio donations website'
        ];
        $website = Website::create($record);
        /*------------------------------------------------------------------------*/
    }
}
