<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    public function index()
    {
        // You can return a view or data here
        return view('submission.index');
    }
}
