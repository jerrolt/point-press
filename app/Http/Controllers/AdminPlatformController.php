<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Platform;
use App\Website;

class AdminPlatformController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.platform.index');
    }
    
	/**
	 * Get a collection of all platforms.  Return in JSON format.
	 *
	 * @return \Illuminate\Http\Response JSON
	 */
	public function all()
	{
		$platforms = Platform::withTrashed()->get();  
        return response()->json([
            'platforms' => $platforms->load('websites','journalists')
        ], 200);
	}
	/**
	 * Get a collection of all website of a platform.  Return in JSON format.
	 *
	 * @return \Illuminate\Http\Response JSON
	 */	
	public function websites($id)
	{
		$websites = Website::withTrashed()->where('platform_id', $id)
			->orderByRaw("deleted_at DESC, name ASC")
			->get();
		return response()->json([
            'websites' => $websites
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
            'title'			  	=> 'required|string|max:100',
            'description'		=> 'nullable|string'
        ]);
        
        $platform = Platform::create([
	        'title'     	  	=> $request->title,
	        'description'	  	=> $request->description
        ]);
        
        //$platform->journalists()->sync($request->journalists);
        
        return response()->json([
            'message' => 'New platform created.',
            'platform' => $platform->load('websites','journalists')
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
        //
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
            'title'			  	=> 'required|string|max:100',
            'description'		=> 'nullable|string'
		]);
        
        $platform = Platform::find($id);
        $platform->title = $request->title;
        $platform->description = $request->description;
	    $platform->save();
	    
	    //$platform->journalists()->sync($request->journalists);
	    
        return response()->json([
            'message' => 'Platform update successfull!',
            'platform' => $platform->load('websites','journalists')
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
        $platform = Platform::find($id);
	    $msg = "({$id}){$platform->firstname} {$platform->lastname} has been removed.";
	    $platform->delete();        
        return response()->json([
            'message' => $msg,
            'platform' => $platform
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
	    $platform = Platform::withTrashed()->where('id', $id)->first();	    
	    if($platform->trashed())
	    {
		    $platform->restore();
	    }		    
	    $msg = "({$id}){$platform->firstname} {$platform->lastname} has been restored.";       
        return response()->json([
            'message' => $msg,
            'platform' => $platform
        ], 200);
    }
}
