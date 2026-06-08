<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            
            $table->id();
            $table->text('main_title');
            $table->text('main_content');

            $table->text('vision_1');
            $table->text('vision_2');
            $table->text('vision_3');
            $table->text('vision_4');
            $table->text('vision_5');
            $table->text('vision_6');

            $table->integer('products_count')->default(1);
            $table->integer('posts_count')->default(5);
            $table->integer('customers_count')->default(3);
            $table->integer('videos_count')->default(1);

            //contact section
            $table->text('facebook_url');
            $table->text('whatsapp_url');
            $table->text('telegram_url');

            $table->text('company_address');
            $table->text('company_email');
            $table->text('company_phone');
            $table->text('company_mobile');

            $table->text('office_hours');
            $table->text('footer');

            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
