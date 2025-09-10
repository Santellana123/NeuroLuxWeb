<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    /**
     * Muestra la página principal de planes de suscripción.
     */
    public function index()
    {
        return view('planes');
    }

    /**
     * Muestra la página de aviso para que el usuario mejore su plan.
     * Esta función apunta a tu archivo 'uplan.blade.php'.
     */
    public function upgrade()
    {
        return view('uplan'); // Apunta a resources/views/uplan.blade.php
    }
}

