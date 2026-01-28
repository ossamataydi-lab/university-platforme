<?php

namespace App\Http\Controllers;

use App\Models\Exame;
use App\Models\Module;
use App\Models\Filier;
use App\Models\User;
use App\Notifications\GeneralNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;

class ExamesController extends Controller
{

    public function index(Request $request)
    {
        $query = Exame::with('module');

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

        $exames = $query->paginate(10);
        $filiers = Filier::all();

        return view('exames.index', ['exames' => $exames, 'filiers' => $filiers]);
    }
    public function create()
    {
        $modules = Module::all();
        $filiere = Filier::all();
        return view('exames.create', compact('modules', 'filiere'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'module_id'   => 'required|exists:modules,id',


            'file_path'        => 'required|mimes:pdf,doc,docx,ppt,pptx|max:20480', // 20MB
        ]);
        $file_path = $request->file('file_path')->store('exames');

        $exame = Exame::create([
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $file_path,
            'module_id' => $request->module_id,
        ]);

        $students = User::where('role', 'student')->get();
        Notification::send($students, new GeneralNotification('New Exam Added', 'A new Exame "' . $exame->title . '" has been added.'));

        return redirect()->route('exames.index')->with('success', 'exame uploaded successfully.');
    }

    // public function show(string $id)
    // {

    // }

    public function download(Exame $exame)
    {
        if (! Storage::exists($exame->file_path)) {
            return redirect()->route('exames.index')->with('error', 'File not found.');
        }
        return Storage::download($exame->file_path);
    }


    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Exame $exame)
    {
        Storage::delete($exame->file_path);
        $exame->delete();

        return redirect()->route('exames.index')->with('success', 'exame deleted successfully.');
    }
}
