@extends('layouts.app')

@section('content')
    <!-- Dependencias (Asegúrate de que estén en tu layout principal) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style> body { font-family: 'Inter', sans-serif; } </style>

<div class="bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Barra lateral (Sidebar) -->
        <aside class="w-64 bg-gray-900 text-gray-300 p-4 fixed h-full shadow-lg">
            <div class="text-white text-2xl font-bold mb-10 pl-2">NeuroLux</div>
            <nav class="space-y-2">
                <a href="{{ route('blog.index') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-700 hover:text-white transition-colors">
                    <i class="fas fa-home w-6 text-center"></i>
                    <span class="ml-4">Home</span>
                </a>
                <a href="{{ route('nosotros.index') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-700 hover:text-white transition-colors">
                    <i class="fas fa-users w-6 text-center"></i>
                    <span class="ml-4">Nosotros</span>
                </a>
                <a href="{{ route('seguimiento.index') }}" class="flex items-center px-4 py-3 rounded-lg bg-yellow-500 text-gray-900 font-bold">
                    <i class="fas fa-chart-line w-6 text-center"></i>
                    <span class="ml-4">Seguimiento</span>
                </a>
                <a href="#" class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-700 hover:text-white transition-colors">
                    <i class="fas fa-cog w-6 text-center"></i>
                    <span class="ml-4">Configuración</span>
                </a>
            </nav>
        </aside>

        <!-- Contenido principal -->
        <main class="flex-1 ml-64 p-8">
            <div class="container mx-auto">
                <!-- Cabecera -->
                <div class="flex justify-between items-center mb-8">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">Selecciona a tu estudiante</h1>
                        <p class="text-gray-500">Haz clic en un estudiante para ver su progreso y actividades.</p>
                    </div>
                    <!-- LÍNEA CORREGIDA: El href ahora apunta a la ruta correcta. -->
                    <a href="{{ route('seguimiento.create') }}" class="bg-blue-600 text-white font-semibold px-5 py-2.5 rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-plus mr-2"></i> Añadir estudiante
                    </a>
                </div>

                <!-- Lista de Pacientes -->
                <div class="space-y-4">
                    @forelse ($children as $child)
                        <div class="bg-white p-4 sm:p-6 rounded-xl shadow-md flex items-center justify-between space-x-4 sm:space-x-6">
                            <div class="flex items-center space-x-4">
                                <img src="{{ $child->photo_path ? asset('storage/' . $child->photo_path) : 'https://placehold.co/80x80/E2E8F0/4A5568?text=' . strtoupper(substr($child->name, 0, 1)) }}" 
                                     alt="Foto de {{ $child->name }}" class="w-16 h-16 sm:w-20 sm:h-20 rounded-full object-cover">
                                <div>
                                    <h2 class="text-lg sm:text-xl font-bold text-gray-800">{{ $child->name }}</h2>
                                    <p class="text-sm text-gray-500">{{ $child->age }} años</p>
                                </div>
                            </div>
                            
                            <div class="flex-1 max-w-xs hidden sm:block">
                                <div class="flex justify-between items-center mb-1">
                                    <span class="text-sm font-medium text-gray-600">Progreso General</span>
                                    <span class="text-sm font-bold text-blue-600">{{ $child->overall_progress ?? 0 }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $child->overall_progress ?? 0 }}%"></div>
                                </div>
                            </div>
                            
                            <a href="{{ route('seguimiento.show', $child) }}" class="text-sm font-semibold text-white bg-blue-600 px-4 py-2.5 rounded-lg hover:bg-blue-700 transition-colors whitespace-nowrap">
                                Ver Dashboard
                            </a>
                        </div>
                    @empty
                        <div class="bg-white text-center p-12 rounded-xl shadow-md">
                            <i class="fas fa-folder-open fa-3x text-gray-300 mb-4"></i>
                            <h3 class="text-xl font-bold text-gray-700">No tienes pacientes asignados</h3>
                            <p class="text-gray-500 mt-2">Haz clic en "Añadir Paciente" para empezar el seguimiento.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </main>
    </div>
</div>
@endsection

