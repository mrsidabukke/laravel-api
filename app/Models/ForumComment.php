<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Forum;

class ForumComment extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user()

    {
        // fungsi dar select adalah untuk memilih data yang akan ditampilkan
        // id dan username adalah data yang akan ditampilkan
        return $this->belongsTo(User::class)->select('id', 'username');
    }

    public function forum()

    {
        return $this->belongsTo(Forum::class);
    }
}
