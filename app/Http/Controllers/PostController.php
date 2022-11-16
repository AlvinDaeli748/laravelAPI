<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Like;
use App\Models\Comment;
use App\Helpers\Helpers;
use Exception;
use Illuminate\Http\Client\RequestException;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Post::all();

        if($data){
            return Helpers::getData(200, 'Success', $data);
        } else {
            return Helpers::getData(400, 'Failed');
        }
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
        try {
            $request->validate([
                'user_id' => 'required',
                'images' => 'required',
                'caption' => 'required',
            ]);

            $post = Post::create([
                'user_id' => $request->user_id,
                'images' => $request->images,
                'caption' => $request->caption,
            ]);

            
            
            $data = Post::where('user_id','=',$post->user_id)->get();


            if($data){
                return Helpers::getData(200, 'Success', $data);
            } else {
                return Helpers::getData(400, 'Failed');
            }

        } catch (Exception $err) {
            // return Helpers::getData(400, 'Failed', $err);
            return $err;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Post::where('user_id','=',$id)->get();


            if($data){
                return Helpers::getData(200, 'Success', $data);
            } else {
                return Helpers::getData(400, 'Failed');
            }
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getPostLikeDetails($id)
    {
        $data = Like::where('user_id','=',$id)->get();


            if($data){
                return Helpers::getData(200, 'Success', $data);
            } else {
                return Helpers::getData(400, 'Failed');
            }
    }

    public function likePost(Request $request)
    {
        try {
            $request->validate([
                'post_id' => 'required',
                'user_id' => 'required'
            ]);

            $like = Like::where(['post_id'=>$request->post_id, 'user_id'=>$request->user_id])->get();

            if($like->count() <= 0){
                $like = Like::create([
                    'post_id' => $request->post_id,
                    'user_id' => $request->user_id,
                ]);
    
                $post = Post::findOrFail($like->post_id);
    
                $post->update([
                    'like_count' => $post->like_count+1,
                ]);
    
                $data = Post::where('id','=',$post->id)->get();
    
                if($data){
                    return Helpers::getData(200, 'Success', $data);
                } else {
                    return Helpers::getData(400, 'Failed');
                }
            }

            else{
                return Helpers::getData(400, 'Like has been added');
            }


        } catch (Exception $err) {
            return $err;
        }
    }
    
    public function unlikePost(Request $request)
    {
        try {
            $request->validate([
                'post_id' => 'required',
                'user_id' => 'required'
            ]);

            $like = Like::where(['post_id'=>$request->post_id, 'user_id'=>$request->user_id])->get();

            if($like->count() > 0){
                $post = Post::findOrFail($request->post_id);
                
                $post->update([
                    'like_count' => $post->like_count-1,
                ]);
                
                $like->each->delete();

                $data = Post::where('id','=',$post->id)->get();
    
                if($data){
                    return Helpers::getData(200, 'Success', $data);
                } else {
                    return Helpers::getData(400, 'Failed');
                }
            }

            else{
                return Helpers::getData(400, 'Like already deleted');
            }


        } catch (Exception $err) {
            return $err;
        }
    }

    public function getPostCommentDetails($id)
    {
        $data = Comment::where('user_id','=',$id)->get();


            if($data){
                return Helpers::getData(200, 'Success', $data);
            } else {
                return Helpers::getData(400, 'Failed');
            }
    }

    public function commentPost(Request $request)
    {
        try {
            $request->validate([
                'post_id' => 'required',
                'user_id' => 'required',
                'comment' => 'required'
            ]);

            $comment = Comment::create([
                'post_id' => $request->post_id,
                'user_id' => $request->user_id,
                'comment' => $request->comment,
            ]);

            $post = Post::findOrFail($comment->post_id);

            $post->update([
                'comment_count' => $post->comment_count+1,
            ]);

            $data = Post::where('id','=',$post->id)->get();

            if($data){
                return Helpers::getData(200, 'Success', $data);
            } else {
                return Helpers::getData(400, 'Failed');
            }

        } catch (Exception $err) {
            return $err;
        }   
    }
}
