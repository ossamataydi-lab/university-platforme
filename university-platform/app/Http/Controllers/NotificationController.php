<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\User;
use App\Notifications\NewContentAdded;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $notifications = $user ? $user->notifications : collect();
        return view('notifications.index', compact('notifications'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
        ]);

        $user = \App\Models\User::findOrFail($request->user_id);
        $user->notify(new \App\Notifications\GeneralNotification($request->title, $request->message));
        return back()->with('success', 'Notification envoyée avec succès.');
    }

    // Marquer une notification comme lue
    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->where('id', $id)->first();

        if ($notification) {
            $notification->markAsRead();
        }

        return back();
    }

    // Marquer toutes comme lues
    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return back();
    }

    // Delete a notification
    public function destroy($id)
    {
        $notification = Auth::user()->notifications()->where('id', $id)->first();

        if ($notification) {
            $notification->delete();
        }

        return back();
    }
}

