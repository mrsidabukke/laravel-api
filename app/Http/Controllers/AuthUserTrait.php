<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

trait AuthUserTrait
{
     //fungsi untuk mengambil user yang sedang login
     private function getAuthuser()
     {
              
         try {
             return auth()->userOrFail();
         }catch(\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e){
             return response()->json(['message' => 'Unauthorized, you have to log in first'])->send();
             exit;
         }
 
     }

     
     private function checkOwnership($owner)
     {
        $user = $this->getAuthuser();
          if($user->id != $owner){
              return response()->json(['message' => 'Not Authorized'],403)->send();
             exit;
          }
     }
}

// Path: app/Http/Controllers/AuthUserTrait.php