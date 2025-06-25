<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function mostrarRegistro()
    {
        return view('registro');
    }

    public function mostrarLogin()
    {
        return view('login');
    }

    // Reemplaza "encriptar" por esta función "store"
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        $datos = [
            'nombre' => $request->nombre,
            'email' => $request->email,
            'password_encriptada' => Hash::make($request->password)
        ];

        return view('registro_resultado', compact('datos'));
    }
}
