@extends('layouts.app')

@section('content')
    <!-- Dependencias de Estilos y Fuentes -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style> 
        body { font-family: 'Inter', sans-serif; background-color: #f9fafb; padding-top: 70px; /* Añade padding para que el contenido no quede debajo del navbar fijo */ }
        .team-card, .mission-card { transition: transform 0.3s ease, box-shadow 0.3s ease; }
        .team-card:hover, .mission-card:hover { transform: translateY(-8px); box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1); }
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
    <!-- BARRA DE NAVEGACIÓN AÑADIDA -->
    <header class="bg-white/80 backdrop-blur-md shadow-sm fixed top-0 left-0 right-0 z-50">
        <nav class="container mx-auto px-6 py-3">
            <div class="flex justify-between items-center">
                <a href="{{ route('home') }}" class="flex items-center space-x-2 text-2xl font-bold text-gray-800">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    <span>NeuroLuxWeb</span>
                </a>

                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('home') }}" class="text-gray-600 hover:text-blue-600 transition duration-300">Inicio</a>
                    <a href="{{ route('nosotros.index') }}" class="text-blue-600 font-semibold transition duration-300">Sobre Nosotros</a>
                    <a href="{{ route('blog.index') }}" class="text-gray-600 hover:text-blue-600 transition duration-300">Blog</a>
                    <a href="{{ route('subscriptions.index') }}" class="text-gray-600 hover:text-blue-600 transition duration-300">Planes</a>
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

    <main class="container mx-auto px-4 sm:px-6 lg:px-8 py-16">
        
        <!-- Sección Principal (Hero) - SIN IMAGEN -->
        <section class="text-center my-12">
            <h1 class="text-4xl sm:text-6xl font-extrabold text-gray-900 tracking-tight">Sobre Nosotros</h1>
            <p class="mt-4 max-w-3xl mx-auto text-lg text-gray-600">
                Somos un equipo de estudiantes apasionados por la tecnología y la innovación, dedicados a crear soluciones con un impacto social positivo.
            </p>
        </section>

        <!-- "TABLA" DE MISIÓN, VISIÓN Y VALORES -->
        <section class="my-24">
            <div class="max-w-7xl mx-auto">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Tarjeta de Misión -->
                    <div class="mission-card bg-white rounded-2xl shadow-lg p-8 text-center border-t-4 border-blue-500">
                        <div class="flex-shrink-0 flex items-center justify-center h-20 w-20 bg-blue-100 text-blue-600 rounded-full mx-auto">
                            <i class="fas fa-bullseye fa-3x"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900 mt-6 mb-3">Nuestra Misión</h2>
                        <p class="text-gray-600 leading-relaxed">
                            Ser de apoyo a niños con Trastorno del Espectro Autista, así como a sus cuidadores y profesionales a través de una aplicación intuitiva de entorno Windows.
                        </p>
                    </div>
                    <!-- Tarjeta de Visión -->
                    <div class="mission-card bg-white rounded-2xl shadow-lg p-8 text-center border-t-4 border-green-500">
                        <div class="flex-shrink-0 flex items-center justify-center h-20 w-20 bg-green-100 text-green-600 rounded-full mx-auto">
                            <i class="fas fa-eye fa-3x"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900 mt-6 mb-3">Nuestra Visión</h2>
                        <p class="text-gray-600 leading-relaxed">
                            Construir una comunidad global inclusiva en la que todos los niños con TEA tengan acceso a herramientas que les permitan alcanzar su máximo potencial.
                        </p>
                    </div>
                    <!-- Tarjeta de Valores -->
                    <div class="mission-card bg-white rounded-2xl shadow-lg p-8 text-center border-t-4 border-purple-500">
                         <div class="flex-shrink-0 flex items-center justify-center h-20 w-20 bg-purple-100 text-purple-600 rounded-full mx-auto">
                            <i class="fas fa-gem fa-3x"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900 mt-6 mb-3">Nuestros Valores</h2>
                        <ul class="text-gray-600 space-y-2">
                            <li><span class="font-semibold">Inclusión</span></li>
                            <li><span class="font-semibold">Empatía</span></li>
                            <li><span class="font-semibold">Responsabilidad Ética</span></li>
                            <li><span class="font-semibold">Especialización</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- Objetivos Secundarios (Mantenido) -->
        <section class="my-24">
            <div class="max-w-7xl mx-auto">
                <h3 class="text-center text-3xl font-extrabold text-gray-900 tracking-tight mb-12">Objetivos Secundarios</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-100 p-8 rounded-2xl shadow-sm">
                        <h4 class="text-xl font-bold text-gray-800 mb-4">Comunicación e Interacción Social</h4>
                        <ul class="space-y-3 text-gray-700">
                            <li class="flex items-start"><i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i><span>Mejorar habilidades verbales y no verbales.</span></li>
                            <li class="flex items-start"><i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i><span>Facilitar relaciones y comprensión social.</span></li>
                        </ul>
                    </div>
                    <div class="bg-gradient-to-br from-purple-50 to-pink-100 p-8 rounded-2xl shadow-sm">
                        <h4 class="text-xl font-bold text-gray-800 mb-4">Flexibilidad en el Pensamiento y la Conducta</h4>
                        <ul class="space-y-3 text-gray-700">
                            <li class="flex items-start"><i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i><span>Fomentar flexibilidad y habilidades cognitivas.</span></li>
                            <li class="flex items-start"><i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i><span>Promover comportamientos adaptativos y pasivos.</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- Sección del Equipo (Mantenida) -->
        <section class="my-24 bg-gray-50 py-20 rounded-2xl">
            <div class="text-center mb-16">
                <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight">Conoce a nuestro equipo</h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-8 max-w-7xl mx-auto">
                @php
                    $team = [
                        ['name' => 'Eduardo A. Martinez Villalobos', 'role' => 'Ing. Informática', 'image' => 'https://placehold.co/400x400/E2E8F0/4A5568?text=EM'],
                        ['name' => 'Yuridia A. Briseño Gonzalez', 'role' => 'Ing. en Gestión Empresarial', 'image' => 'https://placehold.co/400x400/E2E8F0/4A5568?text=YBG'],
                        ['name' => 'Juan Carlos Santellan Bernal', 'role' => 'Ing. Informática', 'image' => 'https://placehold.co/400x400/E2E8F0/4A5568?text=JCS'],
                        ['name' => 'Axel Gael Carlin Guzman', 'role' => 'Ing. Informática', 'image' => 'https://placehold.co/400x400/E2E8F0/4A5568?text=ACG'],
                        ['name' => 'Evelyn H. Esparza Romero', 'role' => 'Ing. en Gestión Empresarial', 'image' => 'https://placehold.co/400x400/E2E8F0/4A5568?text=EER'],
                    ];
                @endphp
                @foreach ($team as $member)
                <div class="team-card bg-white rounded-xl shadow-lg overflow-hidden text-center">
                    <img src="{{ $member['image'] }}" alt="Foto de {{ $member['name'] }}" class="w-full h-56 object-cover">
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-900">{{ $member['name'] }}</h3>
                        <p class="text-blue-600 font-medium">{{ $member['role'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </section>

    </main>
</div>

<!-- MODAL AÑADIDO: Para que el botón "Editar Perfil" funcione -->
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
                    <button type="button" class="btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection