<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\Cours;
use App\Models\Module;
use App\Models\Filier;
use Illuminate\Support\Facades\Storage;
use App\Notifications\GeneralNotification;
use Illuminate\Support\Facades\Notification;
use App\Models\User;

class CoursesController extends Controller
{
    public function index(Request $request){
        $query = Cours::with('module');

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

        $courses = $query->paginate(10);
        $filiers = Filier::all();

        return view('courses.index', compact('courses', 'filiers'));
    }

    public function create(){
        $modules = Module::all();
        $filiere = Filier::all();
        return view('courses.create', compact('modules', 'filiere'));
    }

    public function store(Request $request){
        $request->validate([
            'title'  => 'required|string|max:255',
            'file_path' => 'required|file|mimes:pdf,doc,docx',
            'module_id' => 'required|exists:modules,id',
        ]);

        $path = $request->file('file_path')->store('courses');
        //create file
        $course = Cours::create([
            'title' => $request->title,
            'file_path' => $path,
            'module_id' => $request->module_id,
        ]);

        // Notify students
        $students = User::where('role', 'student')->get(); // Notify all users with role student
        Notification::send($students, new GeneralNotification('New Course Added', 'A new course "' . $course->title . '" has been added.'));

        return redirect()->route('courses.index')->with('success', 'Course created successfully');
    }

    public function show(Cours $course)
    {
        return view('courses.show', compact('course'));
    }

    //download file
    public function download(Cours $course)
    {
        if (Storage::exists($course->file_path)) {
            return Storage::download($course->file_path);
        }
        return redirect()->route('courses.index')->with('error', 'File not found.');
    }

    public function destroy(Cours $course)
    {
        Storage::delete($course->file_path);
        $course->delete();

        return redirect()->route('courses.index')->with('success', 'Course deleted successfully!');
    }
}
