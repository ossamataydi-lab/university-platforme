<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Filier;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        if (! $user instanceof User) {
            abort(403, 'Unauthenticated.');
        }

        if (request()->wantsJson() || request()->is('api/*')) {
            return response()->json($user);
        }

        $filieres = Filier::all();
        $filiere = $user->student ? $user->student->filier : null;
        $semesters = Semester::all();
        $groupedSemesters = Semester::all()->groupBy('filiere_id');
        $semester = $user->student ? $user->student->semester : null;

        return view('profile', compact('user', 'filieres', 'filiere', 'semesters', 'groupedSemesters', 'semester'));
    }

    public function update(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $request->validate([
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:500',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'semester_id' => 'nullable|exists:semesters,id',
        ]);

        if ($request->hasFile('avatar')) {
            if ($user->avatar && $user->avatar !== '') {
                Storage::delete($user->avatar);
            }

            $avatarPath = $request->file('avatar')->store('avatars');
        } else {
            $avatarPath = $user->avatar;
        }

        $user->update([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'bio'        => $request->bio ?: '',
            'email'      => $request->email,
            'avatar'     => $avatarPath ?: '',
        ]);

        // Handle filiere and semester update
        if ($request->filiere_id) {
            $user->student()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'filiere_id' => $request->filiere_id,
                    'semester_id' => $request->semester_id ?: null
                ]
            );
        } elseif ($user->student) {
            $user->student->delete();
        }

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully!');
    }
}
