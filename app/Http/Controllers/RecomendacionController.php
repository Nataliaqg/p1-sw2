<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RecomendacionController extends Controller
{
    public function index(){
        return view('recomendacion.index');
    }
}
