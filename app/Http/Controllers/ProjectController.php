<?php

namespace App\Http\Controllers;

class ProjectController extends Controller
{
    public function index() {
        return response()->view('project');
    }
}
