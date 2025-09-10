<?php

namespace App\Http\Controllers;

use App\Models\Child;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SeguimientoController extends Controller
{
    /**
     * Muestra la lista de selección de pacientes.
     */
    public function index()
    {
        $user = Auth::user();
        $children = $user->children; 
        return view('seguimiento.index', ['children' => $children]);
    }

    /**
     * Muestra el formulario para añadir un nuevo paciente.
     */
    public function create()
    {
        return view('seguimiento.create');
    }

    /**
     * Guarda el nuevo paciente en la base de datos.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|integer|min:0',
            'diagnosis' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $imagePath = null;
        if ($request->hasFile('photo')) {
            $imagePath = $request->file('photo')->store('children_photos', 'public');
        }

        Child::create([
            'name' => $validatedData['name'],
            'age' => $validatedData['age'],
            'diagnosis' => $validatedData['diagnosis'],
            'photo_path' => $imagePath,
            'specialist_id' => Auth::id(),
            'overall_progress' => 0,
            'progress_communication' => 0,
            'progress_activities' => 0,
            'progress_routines' => 0,
            'progress_multimedia' => 0,
            'progress_autonomy' => 0,
        ]);

        return redirect()->route('seguimiento.index')->with('success', 'Paciente añadido correctamente.');
    }

    /**
     * Muestra el dashboard detallado de UN paciente específico.
     */
    public function show(Child $child)
    {
        // Verificar que el especialista es el dueño del niño
        if ($child->specialist_id !== Auth::id()) {
            abort(403, 'Acceso no autorizado.');
        }

        // Cargar relaciones necesarias para el seguimiento completo
        $child->load([
            'activities',
            'routines',
            'achievements',
            'pictograms',
            'sentences.pictograms',
            'teaLogs',
            'specialist'
        ]);

        return view('seguimiento.show', ['child' => $child]);
    }
}
