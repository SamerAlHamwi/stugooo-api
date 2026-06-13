<?php

use App\Models\Post;
use App\Models\Video;
use App\Models\Product;
use App\Models\Setting;
use App\Models\CustomerSaying;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ZohoController;
use App\Http\Controllers\GoogleMeetController;
use App\Http\Controllers\ZoomMeetingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/oauth/zoho/authorize', [ZohoController::class, 'login']);
Route::get('/auth/zoho/redirect', [ZohoController::class, 'handleRedirect']);
Route::get('/auth/zoho/zoho-status', [ZohoController::class, 'handleZohoStatus']);
Route::get('/auth/zoho/refresh-token', [ZohoController::class, 'refreshToken']);
Route::get('/auth/zoho/revoke-token', [ZohoController::class, 'revokeToken']);

Route::get('auth/zoho/createMeeting', [ZohoController::class, 'createMeeting']);
Route::get('auth/zoho/updateMeeting', [ZohoController::class, 'updateMeeting']);
Route::get('auth/zoho/deleteMeeting', [ZohoController::class, 'deleteMeeting']);
Route::get('auth/zoho/initilization', [ZohoController::class, 'initilizationView']);

Route::get('/oauth/google/authorize', [GoogleMeetController::class, 'login']);
Route::get('/auth/google/redirect', [GoogleMeetController::class, 'handleRedirect']);
Route::get('/auth/google/google-status', [GoogleMeetController::class, 'handleGoogleStatus']);
Route::get('auth/google/createMeeting', [GoogleMeetController::class, 'createMeeting']);
Route::get('auth/google/deleteMeeting', [GoogleMeetController::class, 'deleteMeeting']);
Route::get('auth/google/revoke-token', [GoogleMeetController::class, 'revokeToken']);

Route::get('/oauth/zoom/authorize', [ZoomMeetingController::class, 'login']);
Route::get('/auth/zoom/redirect', [ZoomMeetingController::class, 'handleRedirect']);
Route::get('/auth/zoom/zoom-status', [ZoomMeetingController::class, 'handleZoomStatus']);
Route::post('auth/zoom/createMeeting', [ZoomMeetingController::class, 'createMeeting']);
Route::delete('auth/zoom/deleteMeeting', [ZoomMeetingController::class, 'deleteMeeting']);

Route::get('/embed/{videoId}', function($videoId) {
    return view('embed', ['videoId' => $videoId]);
});


Route::get('/', function () {
    $settings = Setting::first();
    $products = Product::where('published', true)->take($settings->products_count)->get();
    $posts = Post::where('published', true)->take($settings->posts_count)->get();
    $said = CustomerSaying::where('published', true)->take($settings->customers_count)->get();
    $videos = Video::where('published', true)->take($settings->videos_count)->get();
    $data = json_decode(json_encode([
        'settings' => $settings,
        'products' => $products,
        'posts'    => $posts,
        'said'     => $said,
        'videos'   => $videos,
    ]));

    return view('welcome')->with(['data' => $data]);
})->name('home');

Route::get("post/{id}", [Controller::class,'getPost'])->name('post');
Route::get("posts/", [Controller::class,'getPosts'])->name('posts');

// مسار لتغيير اللغة
Route::get('/set-locale/{locale}', function(Request $request, $locale){


            Session::put('locale', $locale);
            App::setLocale($locale);
                
        return redirect()->back();
})->name('set.locale');




 
Route::get('/partner', function () {
    $settings = Setting::first();

    return view('be_partner', ['be_partner' => $settings->be_partner]);
})->name('partner');


Route::post('/contact/send', [Controller::class, 'send'])->name('contact.send');
