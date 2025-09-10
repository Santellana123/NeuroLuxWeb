@extends('layouts.app')

@section('content')
    <!-- Dependencias -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style> 
        body { font-family: 'Inter', sans-serif; background-color: #f9fafb; }
    </style>

<div class="flex items-center justify-center min-h-screen">
    <div class="text-center max-w-2xl mx-auto p-8">
        <i class="fas fa-lock fa-4x text-yellow-400 mb-6"></i>
        
        <h1 class="text-4xl sm:text-5xl font-extrabold text-gray-900 tracking-tight">Acceso Exclusivo para Suscriptores</h1>
        
        @if(session('warning'))
            <p class="mt-4 text-lg text-red-600 bg-red-100 px-4 py-2 rounded-md">
                {{ session('warning') }}
            </p>
        @endif
        
        <p class="mt-6 text-xl text-gray-600">
            El módulo de seguimiento de pacientes es una herramienta premium. Para crear perfiles, monitorizar el progreso y acceder a todas las funcionalidades, por favor, elige uno de nuestros planes de pago.
        </p>
        
        <div class="mt-10">
            <a href="{{ route('subscriptions.index') }}" class="px-8 py-4 bg-blue-600 text-white font-bold rounded-lg shadow-lg hover:bg-blue-700 transition duration-300 transform hover:scale-105 text-lg">
                Ver Planes y Precios
            </a>
        </div>
    </div>
</div>
@endsection

