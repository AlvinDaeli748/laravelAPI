<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Helpers;
use App\Models\User;
use App\Models\Follower;
use App\Models\Following;
use Exception;
use Illuminate\Http\Client\RequestException;

class ActionController extends Controller
{
    public function followUser(Request $request)
    {
        try {
            $request->validate([
                'user_id'=> 'required',
                'target_user'=> 'required'
            ]);

            $following = Following::create([
                'user_id' => $request->user_id,
                'user_followed_id' => $request->target_user,
            ]);

            $follower = Follower::create([
                'user_id' => $following->user_followed_id,
                'user_follower_id' => $following->user_id,
            ]);

            $data = User::where('users.id','=',$following->user_id)->join('followings', 'users.id','=','followings.user_id');

            return print_r($data);
            if($data){
                return Helpers::getData(200, 'Success', $data);
            } else {
                return Helpers::getData(400, 'Failed');
            }

        } catch (Exception $err) {
            return $err;
        }
    }

    public function unfollowUser(Request $request)
    {

    }
}
