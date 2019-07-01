<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Journalist;
use App\Post;
use App\Platform;

class AdminJournalistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.journalist.index');
    }

	/**
	 * Get a collection of all Journalists.  Return in JSON format.
	 *
	 * @return \Illuminate\Http\Response JSON
	 */
	public function all()
	{
		$journalists = Journalist::withTrashed()->get();
        return response()->json([
            'journalists' => $journalists->load('posts','platforms')
        ], 200);
	}
	
	
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
		    //'photo' => 'mimes:jpeg,bmp,png'
            'firstname'       	=> 'required|alpha|max:50',
            'lastname'        	=> 'required|alpha|max:50',
            'title'			  	=> 'nullable|string',
            'description'		=> 'nullable|string',
            'political_party' 	=> 'required|string',
	        'likes'			  	=> 'required|integer',
	        'dislikes'		  	=> 'required|integer',
        ]);
        
        $journalist = Journalist::create([
	        'firstname' 	  	=> ucfirst(strtolower($request->firstname)),
	        'lastname'		  	=> ucfirst(strtolower($request->lastname)),
	        'title'     	  	=> $request->title,
	        'description'	  	=> $request->description,	        
	        'facebook'		  	=> $request->facebook,
	        'twitter'		  	=> $request->twitter,
	        'instagram'	      	=> $request->instagram,
	        'youtube' 		  	=> $request->youtube,
	        'steemit'		  	=> $request->steemit,
			'bitchute' 		  	=> $request->bitchute,
	        'political_party'	=> $request->political_party,
	        'likes'			  	=> $request->likes,
	        'dislikes'		  	=> $request->dislikes
        ]);
        $journalist->platforms()->sync($request->platforms);
        
        return response()->json([
            'message' => 'New journalist created successfully!',
            'journalist' => $journalist->load('posts','platforms')
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $journalist = Journalist::find($id);
        return response()->json([
            'journalist' => $journalist->load('posts','platforms')
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
	    $this->validate($request, [
		    //'photo' => 'mimes:jpeg,bmp,png'

            'firstname'       	=> 'required|alpha|max:50',
            'lastname'        	=> 'required|alpha|max:50',
            'title'			  	=> 'nullable|string',
            'description'		=> 'nullable|string',
            'political_party' 	=> 'required|string',
	        'likes'			  	=> 'integer',
	        'dislikes'		  	=> 'integer',
        ]);
        
        $journalist = Journalist::find($id);
        $journalist->firstname = ucfirst(strtolower($request->firstname));
        $journalist->lastname = ucfirst(strtolower($request->lastname));
        $journalist->title = $request->title;
        $journalist->description = $request->description;
        $journalist->political_party = $request->political_party;
        $journalist->likes = $request->likes;
        $journalist->dislikes = $request->dislikes;       
        $journalist->youtube = $request->youtube;
	    $journalist->twitter = $request->twitter;
	    $journalist->facebook = $request->facebook;
	    $journalist->instagram = $request->instagram;
	    $journalist->steemit = $request->steemit;
	    $journalist->bitchute = $request->bitchute;
	    
	    $journalist->save();
	    $journalist->platforms()->sync($request->platforms);
	    
        return response()->json([
            'message' => 'Journalist updated successfully!',
            'journalist' => $journalist->load('posts','platforms')
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {	    
	    $journalist = Journalist::find($id);
	    $msg = "({$id}){$journalist->firstname} {$journalist->lastname} has been removed.";
	    $journalist->delete();
        
        return response()->json([
            'message' => $msg,
            'journalist' => $journalist
        ], 200);        
    }
    /**
     * Restore the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */ 
	public function restore($id)
    {	    
	    $journalist = Journalist::withTrashed()->where('id', $id)->first();	    
	    if($journalist->trashed())
	    {
		    $journalist->restore();
	    }		    
	    $msg = "({$id}){$journalist->firstname} {$journalist->lastname} has been restored.";       
        return response()->json([
            'message' => $msg,
            'journalist' => $journalist
        ], 200);
    }
}
