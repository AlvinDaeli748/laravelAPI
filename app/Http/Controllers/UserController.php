<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Profile;
use App\Models\Follower;
use App\Models\Following;
use App\Helpers\Helpers;
use Exception;
use Illuminate\Http\Client\RequestException;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::all();

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
                'first_name' => 'required',
                'last_name' => 'required',
                'date_of_birth' => 'required',
                'email' => 'required',
                'username' => 'required',
                'password' => 'required'
            ]);

            $user = User::create([
                'email' => $request->email,
                'password' => $request->password,
            ]);

            $profile = Profile::create([
                'user_id' => $user->id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'username' => $request->username,
                'images' => "test",
                'date_of_birth' => $request->date_of_birth,
            ]);
            
            $data = User::where('users.id','=',$user->id)->join('posts', 'users.id', '=', 'posts.user_id')->get();


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
        $data = User::where('users.id','=',$id)->join('profiles', 'users.id', '=', 'profiles.user_id')->get();

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
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            $user = User::findOrFail($id);

            $user->update([
                'email' => $request->email,
                'password' => $request->password
            ]);

            $data = User::where('id','=',$user->id)->get();

            if($data){
                return Helpers::getData(200, 'Success', $data);
            } else {
                return Helpers::getData(400, 'Failed');
            }

        } catch (Exception $err) {
            return Helpers::getData(400, 'Failed', $err);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        $data = $user->delete();

        if($data){
            return Helpers::getData(200, 'Delete Success',);
        } else {
            return Helpers::getData(400, 'Delete Failed');
        }
    }

    public function registerUser(Request $request)
    {
        try {
            $request->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'date_of_birth' => 'required',
                'email' => 'required',
                'username' => 'required',
                'password' => 'required'
            ]);

            $user = User::create([
                'email' => $request->email,
                'password' => $request->password,
            ]);

            $profile = Profile::create([
                'user_id' => $user->id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'username' => $request->username,
                'images' => "test",
                'date_of_birth' => $request->date_of_birth,
            ]);
            
            $data = User::where('users.id','=',$user->id)->join('posts', 'users.id', '=', 'posts.user_id')->get();


            if($data){
                return Helpers::getData(200, 'Success', $data);
            } else {
                return Helpers::getData(400, 'Failed');
            }

        } catch (Exception $err) {
            return Helpers::getData(400, 'Failed', $err);
            // return $err;
        }
    }

    public function loginUser(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            $data = User::where(['email'=>$request->email, 'password'=>$request->password])->get();

            if($data){
                return Helpers::getData(200, 'Success Login');
            } else {
                return Helpers::getData(400, 'Failed Login');
            }

        } catch (Exception $err) {
            // return Helpers::getData(400, 'Failed', $err);
            return $err;
        }
    }

    public function getUserProfile()
    {

    }

    public function getUserFollowing()
    {

    }

    public function getUserFollowers()
    {

    }


}
