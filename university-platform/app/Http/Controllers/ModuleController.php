<?php

namespace App\Http\Controllers;

use App\Models\Filier;
use App\Models\Module;
use App\Models\Student;
use App\Notifications\GeneralNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function index()
    {
        $search = request()->input('search');

        $filiereFilter = request()->input('filiere_id');

        $query = Filier::with(['semesters.modules.semester']);

        if ($search) {
            $query->where('name', 'like', "%$search%")
                ->orWhereHas('modules', function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%");
                });
        }

        if ($filiereFilter) {
            $query->where('id', $filiereFilter);
        }

        $filieres = $query->get();

        // also pass full list for the filter dropdown
        $allFilieres = Filier::all();

        return view('modules.index', compact('filieres', 'allFilieres'));
    }

    //create module
    public function create()
    {
        $filieres = Filier::with('semesters')->get();
        return view('modules.create', compact('filieres'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'chaine' => 'nullable|string|max:255',
            'teatcher_name' => 'required|string|max:255',
            'filiere_id' => 'required|exists:filieres,id',
            'semester_id' => 'required|exists:semesters,id',
        ]);

        $module = Module::create($request->only('name', 'teatcher_name', 'description', 'chaine', 'filiere_id', 'semester_id'));

        // Notify students
        $students = Student::where('filiere_id', $module->filiere_id)->get();
        \Illuminate\Support\Facades\Notification::send($students, new \App\Notifications\GeneralNotification('New Module Added', 'A new module "' . $module->name . '" has been added.'));

        return redirect()->route('modules.index')->with('success', 'Module created successfully.');
    }
    //show module
    public function show(Module $module)
    {
        $courses = $module->courses;
        $exercises = $module->exercises;
        return view('modules.show', compact('module', 'courses', 'exercises'));
    }

    //edit module
    public function edit(Module $module)
    {
        $filieres = Filier::with('semesters')->get();
        return view('modules.edit', compact('module', 'filieres'));
    }

    //update
    public function update(Request $request, Module $module)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'chaine' => 'nullable|string|max:255',
            'teatcher_name' => 'required|string|max:255',
            'filiere_id' => 'required|exists:filieres,id',
            'semester_id' => 'required|exists:semesters,id',
        ]);

        $module->update($request->only('name', 'description', 'Chaine', 'filiere_id', 'teatcher_name', 'semester_id'));

        return redirect()->route('modules.index')->with('success', 'Module updated successfully.');
    }
    //destroy module
    public function destroy(Module $module)
    {
        $module->delete();
        return redirect()->route('modules.index')->with('success', 'Module deleted successfully.');
    }
}
