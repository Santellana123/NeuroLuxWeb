@extends('layouts.app')

@section('content')
    <!-- Dependencias -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style> 
        body { 
            font-family: 'Inter', sans-serif; 
            background-color: #f9fafb; 
            padding-top: 70px; /* Evita que el contenido se oculte tras el navbar fijo */
        }
        .plan-card { transition: transform 0.3s ease, box-shadow 0.3s ease; border: 1px solid #e5e7eb; }
        .plan-card:hover { transform: translateY(-10px); box-shadow: 0 25px 50px -12px rgb(0 0 0 / 0.25); }
        .plan-card.premium { border-top-width: 4px; border-top-color: #4f46e5; }
        .post-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-size: cover;
            background-position: center;
            border: 2px solid #fff;
        }
    </style>

<div>
    <!-- Header / Navbar Añadido -->
    <header class="bg-white/80 backdrop-blur-md shadow-sm fixed top-0 left-0 right-0 z-50">
        <nav class="container mx-auto px-6 py-3">
            <div class="flex justify-between items-center">
                <a href="{{ route('home') }}" class="flex items-center space-x-2 text-2xl font-bold text-gray-800">
                   <img src="{{ asset('imagenes/luxinfintie.png') }}" alt="Logo NeuroLuxWeb" class="w-8 h-8 object-contain">
                    <span>NeuroLuxWeb</span>
                </a>

                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('home') }}" class="text-gray-600 hover:text-blue-600 transition duration-300">Inicio</a>
                    <a href="{{ route('nosotros.index') }}" class="text-gray-600 hover:text-blue-600 transition duration-300">Sobre Nosotros</a>
                    <a href="{{ route('blog.index') }}" class="text-gray-600 hover:text-blue-600 transition duration-300">Blog</a>
                    <a href="{{ route('subscriptions.index') }}" class="text-blue-600 font-semibold transition duration-300">Planes</a>
                </div>

                <div class="flex items-center space-x-3">
                    @guest
                        <a href="{{ route('login') }}" class="px-4 py-2 text-gray-700 bg-gray-200 hover:bg-gray-300 rounded-lg text-sm font-medium transition duration-300">Iniciar Sesión</a>
                        <a href="{{ route('registro') }}" class="px-4 py-2 text-white bg-blue-600 hover:bg-blue-700 rounded-lg text-sm font-medium transition duration-300">Registrarse</a>
                    @else
                        <div class="flex items-center space-x-4">
                            <div class="post-avatar" style="background-image: url('{{ asset('storage/' . (Auth::user()->profile_photo_path ?? 'avatars/default.png')) }}')"></div>
                            <div class="font-semibold text-gray-700">{{ Auth::user()->name }}</div>
                            <button class="px-3 py-1 text-sm text-gray-700 bg-gray-200 hover:bg-gray-300 rounded-lg" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                                Editar Perfil
                            </button>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="px-3 py-1 text-sm text-white bg-red-500 hover:bg-red-600 rounded-lg">Cerrar Sesión</button>
                            </form>
                        </div>
                    @endguest
                </div>
            </div>
        </nav>
    </header>

    <main class="py-12">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Cabecera -->
            <div class="text-center">
                <h1 class="text-4xl sm:text-5xl font-extrabold text-gray-900 tracking-tight">Elige el Plan Perfecto para Ti</h1>
                <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-600">
                    Desbloquea todo el potencial de NeuroLux con una de nuestras suscripciones.
                </p>
            </div>

            <!-- Tabla de Precios -->
            <div class="mt-16 grid grid-cols-1 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <!-- Plan Gratis -->
                <div class="plan-card bg-white rounded-2xl p-8 text-center">
                    <h3 class="text-2xl font-bold text-gray-900">Gratis</h3>
                    <p class="mt-2 text-gray-500">Para empezar a explorar</p>
                    <p class="mt-8 text-5xl font-extrabold text-gray-900">$0</p>
                    <a href="#" class="mt-8 block w-full bg-gray-200 text-gray-800 font-semibold py-3 rounded-lg">Tu Plan Actual</a>
                    <ul class="mt-8 space-y-4 text-left text-gray-600">
                        <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-3"></i>Acceso al Blog y Comunidad</li>
                        <li class="flex items-center"><i class="fas fa-times-circle text-red-500 mr-3"></i>Acceso a Seguimiento</li>
                        <li class="flex items-center"><i class="fas fa-times-circle text-red-500 mr-3"></i>Gestión de Pacientes</li>
                    </ul>
                </div>

                <!-- Plan Básico -->
                <div class="plan-card bg-white rounded-2xl p-8 text-center">
                    <h3 class="text-2xl font-bold text-gray-900">Básico</h3>
                    <p class="mt-2 text-blue-600 font-semibold">Ideal para individuos y familias</p>
                    <p class="mt-8 text-5xl font-extrabold text-gray-900">$50</p>
                    <a href="#" class="mt-8 block w-full bg-blue-600 text-white font-semibold py-3 rounded-lg hover:bg-blue-700">Suscribirse</a>
                    <ul class="mt-8 space-y-4 text-left text-gray-600">
                        <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-3"></i>Todo lo del plan Gratis, y:</li>
                        <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-3"></i>Acceso completo a Seguimiento</li>
                        <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-3"></i><strong class="text-gray-800 mr-1">3 Pacientes</strong> (para Especialistas)</li>
                        <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-3"></i>Visualización de Hijos (para Padres)</li>
                    </ul>
                </div>

                <!-- Plan Premium -->
                <div class="plan-card premium bg-white rounded-2xl p-8 text-center relative">
                    <p class="absolute top-0 -translate-y-1/2 left-1/2 -translate-x-1/2 bg-indigo-600 text-white font-semibold px-4 py-1 rounded-full text-sm">Más Popular</p>
                    <h3 class="text-2xl font-bold text-gray-900">Premium</h3>
                    <p class="mt-2 text-indigo-600 font-semibold">Para profesionales e instituciones</p>
                    <p class="mt-8 text-5xl font-extrabold text-gray-900">$200</p>
                    <a href="#" class="mt-8 block w-full bg-indigo-600 text-white font-semibold py-3 rounded-lg hover:bg-indigo-700">Suscribirse</a>
                    <ul class="mt-8 space-y-4 text-left text-gray-600">
                        <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-3"></i>Todo lo del plan Básico, y:</li>
                        <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-3"></i><strong class="text-gray-800">Pacientes Ilimitados</strong></li>
                        <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-3"></i>Reportes Avanzados</li>
                        <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-3"></i>Soporte Prioritario</li>
                    </ul>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Modal para editar el perfil (Añadido) -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfileModalLabel">Editar Perfil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('profile.update-photo') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3 text-center">
                        <label for="profile_photo" class="form-label">Cambiar foto de perfil</label>
                        <input class="form-control" type="file" id="profile_photo" name="profile_photo">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

