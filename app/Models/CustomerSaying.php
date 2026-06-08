<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerSaying extends Model
{
    use HasFactory;
    protected $fillable = [
        'content', 'customer', 'card_image', 'published'
    ];

    protected $casts = [
        'published' => 'boolean'
    ];
}
