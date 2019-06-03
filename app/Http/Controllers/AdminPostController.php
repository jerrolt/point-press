<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//include for enhanced form validation
use Validator;
use Illuminate\Validation\Rule; 

//Models that are used
use App\Post;
use App\Website;
use App\Journalist;

class AdminPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.post.index');
    }

	/**
	 * Get a collection of all posts. JSON response.
	 *
	 * @return \Illuminate\Http\Response JSON
	 */
	public function all()
	{		
		$posts = Post::withTrashed()->orderByRaw('date_posted DESC, title ASC')->get(); 		
        return response()->json([
            'posts' => $posts
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
			'journalist_id'		=> 'required|integer|gt:0',
            'title'			  	=> 'required|unique:posts,title|string|max:100',
            'href'				=> 'required|unique:posts,href|string|max:100',
            'content'			=> 'required|string|min:10', 
            'date_posted'		=> 'required|date',
            'likes'				=> 'required|integer|gte:0',
            'dislikes'			=> 'required|integer|gte:0',       
		]);
				
        $post = Post::create([
	        'journalist_id'	=> $request->journalist_id,
	        'title'     	=> $request->title,
	        'href'			=> $request->href,
	        'content'	  	=> $request->content,
	        'status'		=> $request->status,
	        'likes'			=> $request->likes,
	        'dislikes'		=> $request->dislikes,
	        'date_posted'	=> $request->date_posted,
        ]);
	    
	    return response()->json([
            'message' 	=> 'New post created!',
            'post' 		=> $post
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
        $post = Post::withTrashed()->where('id',$id)->first(); 
        return response()->json([
            'post' => $post
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
		    'journalist_id'		=> 'required|integer|gt:0',		
			'title'				=> [
				'required',
				'string',
				'max:100',
				Rule::unique('posts', 'title')->ignore($id)
			],
			'href'				=> [
				'required',
				'string',
				'max:100',
				Rule::unique('posts', 'href')->ignore($id)
			],
		    'content'			=> 'required|string|min:10', 
            'date_posted'		=> 'required|date',
            'likes'				=> 'required|integer|gte:0',
            'dislikes'			=> 'required|integer|gte:0',
		])->validate();
		
	    $post = Post::withTrashed()->where('id',$id)->first();	    
        $post->journalist_id = $request->journalist_id;
	    $post->title = $request->title;
	    $post->href = $request->href;
	    $post->content = $request->content;
	    $post->status = $request->status;
	    $post->likes = $request->likes;
	    $post->dislikes = $request->dislikes;
	    $post->date_posted = $request->date_posted;
        $post->save();
	    
	    return response()->json([
            'message' 	=> 'Post update successful',
            'post' 		=> $post
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
        $post = Post::find($id);
	    $msg = "({$id}){$post->title} has been removed.";
	    $post->delete();        
        return response()->json([
            'message' => $msg,
            'post' => $post
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
	    $post = Post::withTrashed()->where('id', $id)->first();	    
	    if($post->trashed())
	    {
		    $post->restore();
	    }		    
	    $msg = "({$id}){$post->title} has been restored.";       
        return response()->json([
            'message' => $msg,
            'post' => $post
        ], 200);
    }
}
