<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Auth\Events\Registered; // Importa el evento para la verificación de correo
use Illuminate\Validation\Rule; // Importa la regla para validar roles

class AuthController extends Controller
{
    /**
     * Muestra el formulario de registro.
     */
    public function mostrarRegistro()
    {
        return view('auth.registro');
    }

    /**
     * Almacena un nuevo usuario (con rol Y plan) y envía el correo de verificación.
     */
    public function store(Request $request)
    {
        // Validación de datos, incluyendo el nuevo campo 'role' y el plan
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => ['required', 'string', Rule::in(['parent', 'specialist'])],
            // NUEVO: El plan solo es requerido si el rol es 'specialist'
            'subscription_plan' => ['required_if:role,specialist', 'nullable', 'string', Rule::in(['basic', 'premium'])],
        ]);
        
        // Crea el usuario con el rol y el plan seleccionados
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            // NUEVO: Se guarda el plan de suscripción solo si es especialista
            'subscription_plan' => $request->role === 'specialist' ? $request->subscription_plan : null,
        ]);
        
        // Dispara el evento de registro para enviar el correo de verificación
        event(new Registered($user));
        
        // Inicia sesión al nuevo usuario
        Auth::login($user);
        
        // Redirige al usuario a la página de inicio
        return redirect()->route('home')->with('success', '¡Registro exitoso! Por favor, verifica tu correo electrónico.');
    }

    /**
     * Muestra el formulario de login.
     */
    public function mostrarLogin()
    {
        return view('auth.login');
    }

    /**
     * Maneja el intento de login.
     */
    public function login(Request $request)
    {
        // Valida las credenciales
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Intenta autenticar al usuario
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/')->with('success', '¡Inicio de sesión exitoso!');
        }

        // Si falla, redirige de nuevo con un error
        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ]);
    }
    
    /**
     * Cierra la sesión del usuario.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Sesión cerrada exitosamente.');
    }

    /**
     * Actualiza la foto de perfil del usuario autenticado.
     */
    public function updateProfilePhoto(Request $request)
    {
        $user = Auth::user();

        // Validación de la imagen
        $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Sube la imagen y obtiene la ruta
        $path = $request->file('profile_photo')->store('avatars', 'public');

        // Actualiza la ruta de la foto de perfil en el usuario
        $user->profile_photo_path = $path;
        $user->save();

        return redirect()->back()->with('success', '¡Foto de perfil actualizada!');
    }
}
