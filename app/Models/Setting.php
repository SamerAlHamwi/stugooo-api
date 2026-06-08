<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        "main_title", "main_content",
        "vision_1", "vision_2","vision_3","vision_4","vision_5","vision_6",
        "products_count", "posts_count","customers_count", "videos_count",
        "facebook_url", "whatsapp_url","telegram_url",
        "company_address","company_email", "company_phone","company_mobile", 
        "office_hours","footer",
        'youtube_url',
        'instagram_url',
        'tiktok_url',
        "be_partner"
    ];




}
