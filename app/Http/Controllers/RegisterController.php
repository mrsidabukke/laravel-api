<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function register()
    {
       
 $validator=validator::make(request()->all(),[
  'username' => 'required|unique:users',
    'email' => 'required|email|unique:users',
    'password' => 'required',
    ]);

    //jika validasi gagal
      if($validator->fails()){
         return response()->json($validator->messages(),422);
      }

 $user = User::create([
    'username' => request('username'),
    'email' => request('email'),
    'password' => Hash::make(request('password')),
    ]);


    //generate token,auto login , atau hanya respon berhasil
    return response()->json(['message' => 'Successfully created user!']);

 
    }
}
