<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscription
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Si no hay usuario autenticado, lo enviamos a login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // 2. Obtenemos el plan del usuario
        $plan = Auth::user()->subscription_plan;

        // 3. Lista de planes permitidos
        $allowedPlans = ['basic', 'premium'];

        // 4. Si no tiene plan o es 'free', o no está en la lista permitida
        if (!$plan || !in_array($plan, $allowedPlans)) {
            return redirect()->route('subscriptions.upgrade')
                ->with('warning', 'Necesitas un plan Básico o Premium para acceder a esta sección.');
        }

        // 5. Todo correcto → dejar pasar
        return $next($request);
    }
}


