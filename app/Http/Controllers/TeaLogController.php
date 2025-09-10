<?php
// app/Http/Controllers/TeaLogController.php

namespace App\Http\Controllers;

use App\Models\TeaLog;
use Illuminate\Http\Request;

class TeaLogController extends Controller
{
    /**
     * Muestra la lista de tés y el formulario.
     */
    public function index()
    {
        // Obtenemos todos los registros, el más nuevo primero
        $logs = TeaLog::latest()->get(); 
        
        // Retornamos la vista y le pasamos los logs
        return view('tracker', ['logs' => $logs]);
    }

    /**
     * Guarda un nuevo registro de té en la base de datos.
     */
    public function store(Request $request)
    {
        // Validación simple: el campo es requerido
        $request->validate([
            'tea_type' => 'required|string|max:100',
        ]);

        // Creamos el nuevo registro
        TeaLog::create([
            'tea_type' => $request->tea_type,
        ]);

        // Redirigimos de vuelta a la página principal
        return redirect()->route('tracker.index');
    }
}