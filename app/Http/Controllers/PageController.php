<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Muestra la página "Sobre Nosotros".
     */
    public function about()
    {
        return view('nosotros');
    }
}