<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ForumResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
//yang ada di dalam tanda '' adalah nama data yang akan ditampilkan pada user 
// yang disamping tanda -> adalah data dalam database

// kita bisa melakukan apapun sebelum mengoper data ke client
// contoh 'title' => ucfirst($this->title) agar huruf pertamanya besar
          'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
            'slug' => $this->slug,
            'category' => $this->category,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'user' => $this->user,
            'comments' => $this->Comments,

        ];
    }
}
