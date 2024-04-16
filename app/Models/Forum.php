<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\ForumComment;

class Forum extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function user()

    {
        return $this->belongsTo(User::class)->select('id', 'username');
    }

    public function comments()
    {
        return $this->hasMany(ForumComment::class);
    }
}
