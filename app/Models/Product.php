<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",  "title",  "content", "image",  "published", "tags","android_url","ios_url"
    ];

    protected $casts = [
        'tags' => 'array',
        'published' => 'boolean'
    ];


    public function user(){
        return $this->belongsTo(User::class);
    }

}
