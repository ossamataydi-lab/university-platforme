<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Filier;
use App\Notifications\GeneralNotification;
use Illuminate\Support\Facades\Notification;
use App\Models\User;

class FilierContoller extends Controller
{
    public function index()
    {
        $filieres = Filier::paginate(9);
        return view('filiers.index', compact('filieres'));
    }
    public function create()
    {
        return view('filier.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:filieres',
            'description' => 'nullable|string|max:500'

        ]);
        $filier = Filier::create($request->only('name', 'description'));


        for ($i = 1; $i <= 6; $i++) {
            \App\Models\Semester::create([
                'filiere_id' => $filier->id,
                'semester' => 'S' . $i,
            ]);
        }

        // Notify students
        $students = User::where('role', 'student')->get();
        Notification::send($students, new GeneralNotification('New Filier Added', 'A new filier "' . $filier->name . '" has been added.'));

        return redirect()->route('filier.index')->with('success', 'Filiere created successfully');
    }

    public function show(Filier $filier)
    {
        $modules = $filier->modules;
        return view('filier.show', compact('filier', 'modules'));
    }

    public function edit(Filier $filier)
    {
        $filieres = Filier::all();
        return view('filier.edit', compact('filieres', 'filier'));
    }

    public function update(Request $request, Filier $filier)
    {
        $request->validate([
            'name' => 'required|unique:filieres,name,' . $filier->id,
            'description' => 'nullable|string|max:500'
        ]);
        $filier->update($request->only('name', 'description'));
        return redirect()->route('filier.index')->with('success', 'Filiere updated successfully');
    }

    public function destroy(Filier $filier)
    {
        $filier->delete();
        return redirect()->route('filier.index')->with('success', 'Filiere deleted successfully');
    }
}
