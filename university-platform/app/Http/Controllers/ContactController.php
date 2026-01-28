<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }
    public function send(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'email'   => 'required|email',
            'message' => 'required|max:255',
        ]);

        Mail::raw($request->message, function ($msg) use ($request) {
            $msg->to('taydiossama@gmail.com')
                ->subject('Contact From ' . $request->first_name . ' ' . $request->last_name);
        });
        return back()->with('success', 'Your message has been sent successfuly');
    }
}
