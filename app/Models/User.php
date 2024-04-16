<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Forum;
use App\Models\ForumComment;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Tymon\JWTAuth\Contracts\Providers\JWT;

//jika menggunakan jwt kita harus menambahkan use Tymon\JWTAuth\Contracts\JWTSubject; dan use Tymon\JWTAuth\Contracts\Providers\JWT;
// dan juga implementasikan JWTSubject pada class User
class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    //return $this->hasMany(Forum::class); berfungsi untuk menghubungkan model User dengan model Forum
    public function forums()
    {
        return $this->hasMany(Forum::class)->orderBy('id','desc')->limit(5);
    }

    public function forum_comments()
    {
        return $this->hasMany(ForumComment::class)->orderBy('id','desc')->limit(5);
    }
   

    //jika kita ingin menggunakan JWT, kita harus menambahkan dua method berikut pada model User
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

}
