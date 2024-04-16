<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Models\User;
class UserController extends Controller
{
    public function show($username)
    {
        // kode dibawah berfungsi untuk mengembalikan nilai yang ada pada username
        // lalu fungsi select berfungsi untukk mmemilih data mana yang akan ditampilkan
        return new UserResource( 
        User::where('username', $username)->first()
        );
    }

    public function getActivity($username)
    {
 
    return new UserResource(
    User::where('username',$username)
           ->with('forums','forum_comments')->first()    
    );

    }
}
