<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Helpers\Helpers;
use Exception;

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
                'email' => 'required|email',
                'password' => 'required',
            ]);

            $user = User::create([
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = User::where('id','=',$id)->get();

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
}
