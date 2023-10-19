<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TiendaSimilarController extends Controller
{
    public function index($pdv_id)
    {
        return view('recomendacion.tiendaSimilar.index', ['pdv_id' => $pdv_id]);
    }
}
