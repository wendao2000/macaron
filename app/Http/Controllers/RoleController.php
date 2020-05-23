<?php

namespace App\Http\Controllers;

class RoleController extends Controller
{
    public function index() {
        return response()->view('role');
    }
}
