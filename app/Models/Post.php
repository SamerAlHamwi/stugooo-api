<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id", "slug", "title", "summary", "content", "main_image", "card_image", "published", "tags",
    ];

    protected $casts = [
        'tags' => 'array',
        'published' => 'boolean'
    ];


    public function user(){
        return $this->belongsTo(User::class);
    }

}
