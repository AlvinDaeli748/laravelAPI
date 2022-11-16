<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Helpers;
use App\Models\User;
use App\Models\Profile;
use DB;
use Exception;
use Illuminate\Http\Client\RequestException;

class SearchController extends Controller
{
    public function search($param)
    {
        // $data = User::where('users.id','=',$user->id)->join('profiles', 'users.id', '=', 'profiles.user_id')->get();
        $data = User::join('profiles', 'users.id', '=', 'profiles.user_id')
        ->where('email', 'LIKE',  "%$param%")
        ->orWhere('username', 'LIKE', "%$param%")
        ->get();
        

        if($data->count() > 0){
            return Helpers::getData(200, 'Success', $data);
        } else {
            return Helpers::getData(200, 'Data Not Found');
        }
    }
}
