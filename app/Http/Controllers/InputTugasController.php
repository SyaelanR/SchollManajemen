<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InputTugasController extends Controller
{
    public function index()
    {
        return view('inputtugas'); // sesuaikan nama view
    }
}
