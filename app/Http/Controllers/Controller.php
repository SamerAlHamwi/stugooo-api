<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
    use Illuminate\Support\Facades\Mail;
    use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function getPost($id){
        return view("blog", [
            "post"=> Post::findOrFail($id),
            "posts"=> Post::take(4)->get(),
        ]);

    }

    public function getPosts(){
        return view("blogs", [
            "posts"=> Post::where('published',true )->paginate(8),
        ]);

    }

        //sen contact us email

     public function send(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'message' => 'required|string',
        ]);

        $details = [
            'name'    => $request->name,
            'email'   => $request->email,
            'message' => $request->message,
        ];

        // إرسال البريد
        Mail::send('emails.contact', $details, function ($mail) use ($request) {
            $mail->to(['info@stugooo.com', 'sales@stugooo.com'])
                 ->subject('Yeni İletişim Mesajı');
        });

        return back()->with('success', 'Mesajınız başarıyla gönderildi!');
    }

}
