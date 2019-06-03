<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Website;

class AdminWebsiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.website.index');
    }

	/**
	 * Get a collection of all websites. JSON response.
	 *
	 * @return \Illuminate\Http\Response JSON
	 */
	public function all()
	{		
		$websites = Website::withTrashed()->orderByRaw('deleted_at DESC, name ASC')->get(); 		
        return response()->json([
            'websites' => $websites->load('posts')
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
            'name'			  	=> 'required|unique:websites,name|string|max:100',
            'url'				=> 'required|unique:websites,url|string|max:100',
            'description'		=> 'nullable|string'
		]);
				
        $website = Website::create([
	        'platform_id'	=> $request->platform_id,
	        'name'     	  	=> $request->name,
	        'url'				=> $request->url,
	        'description'	  	=> $request->description
        ]);
	    
	    return response()->json([
            'message' => 'New website created!',
            'website' => $website
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
        $website = Website::withTrashed()->where('id',$id)->first();
        return response()->json([
            'website' => $website
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
        //
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
	    Validator::make($request->all(), [			
			'name'				=> [
				'required',
				'string',
				'max:100',
				Rule::unique('websites', 'name')->ignore($id)
			],
			'url'				=> [
				'required',
				'string',
				'max:100',
				Rule::unique('websites', 'url')->ignore($id)
			],
		    'description' 		=> 'nullable|string',
		])->validate();
        
        $website = Website::withTrashed()->where('id',$id)->first($id);
        $website->name = $request->name;
        $website->url = $request->url;
        $website->description = $request->description;
	    $website->save();
	    	    
	    return response()->json([
            'message' => 'Website update successful!',
            'website' => $website
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
        $website = Website::find($id);
	    $msg = "({$id}){$website->url} has been removed.";
	    $website->delete();        
        return response()->json([
            'message' => $msg,
            'website' => $website
        ], 200);
    }
    public function hardDelete($id){	    
	    $website = Website::withTrashed()->where('id', $id)->first();
	    $msg = "Website permanently removed.";
	    $website->forceDelete();        
        return response()->json([
            'message' => $msg
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
	    $website = Website::withTrashed()->where('id', $id)->first();	    
	    if($website->trashed())
	    {
		    $website->restore();
	    }		    
	    $msg = "({$id}){$website->url} has been restored.";       
        return response()->json([
            'message' => $msg,
            'website' => $website
        ], 200);
    }
}
