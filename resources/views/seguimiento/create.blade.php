@extends('layouts.app')

@section('content')
    <!-- Dependencias de Estilos y Fuentes -->
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
            <div class="container mx-auto max-w-2xl">
                <!-- Cabecera -->
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-gray-800">Añadir Nuevo Paciente</h1>
                    <p class="text-gray-500">Completa la información para registrar un nuevo perfil.</p>
                </div>

                <!-- Formulario -->
                <div class="bg-white p-8 rounded-xl shadow-md">
                    <form action="{{ route('seguimiento.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-6">
                            <!-- Nombre Completo -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Nombre Completo</label>
                                <input type="text" name="name" id="name" required
                                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                       value="{{ old('name') }}">
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Edad -->
                            <div>
                                <label for="age" class="block text-sm font-medium text-gray-700">Edad</label>
                                <input type="number" name="age" id="age" required
                                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                       value="{{ old('age') }}">
                                @error('age')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Diagnóstico -->
                            <div>
                                <label for="diagnosis" class="block text-sm font-medium text-gray-700">Diagnóstico (Opcional)</label>
                                <input type="text" name="diagnosis" id="diagnosis"
                                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                       value="{{ old('diagnosis') }}">
                            </div>

                            <!-- Foto de Perfil -->
                            <div>
                                <label for="photo" class="block text-sm font-medium text-gray-700">Foto de Perfil (Opcional)</label>
                                <input type="file" name="photo" id="photo"
                                       class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                @error('photo')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Botones de Acción -->
                        <div class="mt-8 flex justify-end space-x-4">
                            <a href="{{ route('seguimiento.index') }}" class="px-6 py-2.5 text-sm font-semibold text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 transition-colors">
                                Cancelar
                            </a>
                            <button type="submit" class="px-6 py-2.5 text-sm font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors">
                                Guardar Paciente
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection