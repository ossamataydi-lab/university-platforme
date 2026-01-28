<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\Module;
use App\Models\Filier;
use App\Notifications\GeneralNotification;
use Illuminate\Support\Facades\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExerciceController extends Controller
{
    public function index(Request $request)
    {
        $query = Exercise::with('module');

        if ($request->has('search') && !empty($request->search)) {
            $query->whereHas('module', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('filiere_id') && !empty($request->filiere_id)) {
            $query->whereHas('module', function ($q) use ($request) {
                $q->where('filiere_id', $request->filiere_id);
            });
        }

        $exercises = $query->paginate(10);
        $filiers = Filier::all();

        return view('exercises.index', compact('exercises', 'filiers'));
    }
    // public function indeex(){
    //     $exercises = Exercise::with('module')->paginate(10);
    //     return view('exames.index', compact('exercises'));
    // }

    public function create()
    {
        $modules = Module::all();
        $filiere = Filier::all();
        return view('exercises.create', compact('modules', 'filiere'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'module_id'   => 'required|exists:modules,id',
            'file_path'        => 'required|mimes:pdf,doc,docx,ppt,pptx|max:20480', // 20MB
        ]);

        $file_path = $request->file('file_path')->store('exercises');

        $exercise = Exercise::create([
            'title'       => $request->title,
            'description' => $request->description,
            'file_path'   => $file_path,
            'module_id'   => $request->module_id,
        ]);

        // Notify students
        $students = User::where('role', 'student')->get();
        Notification::send($students, new GeneralNotification('New Exercise Added', 'A new exercise "' . $exercise->title . '" has been added.'));

        return redirect()->route('exercises.index')->with('success', 'Exercise uploaded successfully.');
    }

    public function show(Exercise $exercise)
    {
        return view('exercises.show', compact('exercise'));
    }

    public function download(Exercise $exercise)
    {
        if (! Storage::exists($exercise->file_path)) {
            return redirect()->route('exercises.index')->with('error', 'File not found.');
        }
        return Storage::download($exercise->file_path);
    }

    public function destroy(Exercise $exercise)
    {
        Storage::delete($exercise->file_path);
        $exercise->delete();

        return redirect()->route('exercises.index')->with('success', 'Exercise deleted successfully.');
    }
}
