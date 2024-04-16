<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthUserTrait;
use App\Models\Forum;
use App\Models\ForumComment;
use App\Models\User;
class ForumCommentController extends Controller
{
    use AuthUserTrait;
    public function __construct()
    {
      
     //agar tidak perlu menambahalam 'api' pada auth()
        return auth()->shouldUse('api');
    }

  
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request , $forumId)
    {
       
        $this->validateRequest();


         $user = $this->getAuthuser();
       

              
          
           $user->forum_Comments()->create([
      
              'body' => request('body'),
             'forum_id' => $forumId,
              ]);
          
          
              //generate token,auto login , atau hanya respon berhasil
              return response()->json(['message' => 'Successfully commented']);
          
    }

    private function validateRequest()
    {
    
        $validator = Validator::make(request()->all(), [
            
              'body' => 'required|min:5',
              
              ]);
          
              if($validator->fails()){
                 response()->json($validator->messages(),422)->send();
                exit;
             }
    
        
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $forumId, $commentId)
    {
        $this->validateRequest();
   
        $forumComment=ForumComment::find($commentId);
              
       $this->checkOwnership($forumComment->user_id);
        
           $forumComment->update([
        
              'body' => request('body'),
           
              ]);
          
          
              //generate token,auto login , atau hanya respon berhasil
              return response()->json(['message' => 'Successfully comment updated']);
            
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $forumId , $commentId)
    {
        $forumComment = Forumcomment::find($commentId);  
    
       

        $this->checkOwnership($forumComment->user_id);
        
  $forumComment->delete();
  return response()->json(['message' => 'succesfully deleted the comment']);
    }
}
