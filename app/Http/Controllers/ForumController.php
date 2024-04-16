<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\AuthUserTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Forum;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ForumResource;
use App\Http\Resources\ForumsResource;
class ForumController extends Controller
{
    use AuthUserTrait;
    
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
      
     //agar tidak perlu menambahalam 'api' pada auth()
        return auth()->shouldUse('api');
    }

    public function index()
    {

        // //untuk menampilkans semua forum
        // return Forum::all();
    
        // //untuk menampilkan semua forum dengan user
        // return Forum::with('user')->get();  

        // untuk mengambil username harus dengan id karna id adalah relasinya
        // paginate untuk membatasi jumlah data yang ditampilkan
        // fungsi collection adalah untuk mentranformasi semua datanya
        return ForumsResource::collection(
           Forum::with('user')->withCount('comments')->paginate(3)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       
        $this->validateRequest();


         $user = $this->getAuthuser();
       

              
          
           $user->forums()->create([
              'title' => request('title'),
              'body' => request('body'),
              'slug' => Str::slug(request('title'),'-').'-'.time(),
              'category' => request('category'),
              ]);
          
          
              //generate token,auto login , atau hanya respon berhasil
              return response()->json(['message' => 'Successfully posted']);
          
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {


        return new ForumResource(
           Forum::with('user' ,'comments.user' )->find($id)
        );
    }

    public function filtertag(string $tag)
    {
        return ForumResource::collection(
         Forum::with('user')->where('category', $tag)->paginate(3)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $this->validateRequest();
   
        $forum=Forum::find($id);
              
       $this->checkOwnership($forum->user_id);
        
           $forum->update([
              'title' => request('title'),
              'body' => request('body'),
              'category' => request('category'),
              ]);
          
          
              //generate token,auto login , atau hanya respon berhasil
              return response()->json(['message' => 'Successfully updated']);
            
    }

    //fungsi untuk validasi request
    private function validateRequest()
    {
    
        $validator = Validator::make(request()->all(), [
            'title' => 'required|min:5',
              'body' => 'required|min:5',
              'category' => 'required',
              ]);
          
              if($validator->fails()){
                 response()->json($validator->messages())->send();
                exit;
             }
    
        
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $forum = Forum::find($id);  
    
       

        $this->checkOwnership($forum->user_id);
        
  $forum->delete();
  return response()->json(['message' => 'succesfully deleted']);
    }


   

    //fungsi untuk mengecek kepemilikan forum
  
}
