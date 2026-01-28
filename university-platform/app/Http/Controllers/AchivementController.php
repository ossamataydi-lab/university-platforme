<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\Submission;
use App\Models\Filier;
use App\Models\Module;
use App\Models\Cours;
use Illuminate\Http\Request;

class AchivementController extends Controller
{
    public function index(){
      return view('achivement', compact('achivement'));
    }
    public function studentAchivement(Request $request)
    {
    $filieres = Filier::all();

        $modules = collect();
        $courses = collect();
        $exercises = collect();

        $selectedFilierId = $request->query('filier_id');
        $selectedModuleId = $request->query('module_id');
        $selectedType = $request->query('type'); // 'cours' or 'exercice'

        if ($selectedFilierId) {
            $modules = Module::where('filiere_id', $selectedFilierId)->get();
        }

        if ($selectedModuleId && $selectedType) {
            if ($selectedType === 'cours') {
                $courses = Cours::where('module_id', $selectedModuleId)->get();
            } elseif ($selectedType === 'exercice') {
                $exercises = Exercise::where('module_id', $selectedModuleId)->get();
            }
        }

        return view('achivement', compact(
            'filieres',
            'modules',
            'courses',
            'exercises',
            'selectedFilierId',
            'selectedModuleId',
            'selectedType'
        ));
    }
}

