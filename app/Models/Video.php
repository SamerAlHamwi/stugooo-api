<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'title', 'content', 'video_url', 'card_image', 'published', 'tags'
    ];

    protected $casts = [
        'tags' => 'array',
        'published' => 'boolean'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
}
