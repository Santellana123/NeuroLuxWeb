@extends('layouts.app')

@section('content')
    <!--
        NOTA: Este diseño utiliza Tailwind CSS. 
        Asegúrate de que Tailwind CSS esté configurado en tu proyecto o 
        incluye el CDN en tu archivo de layout principal (layouts/app.blade.php) para que los estilos se apliquen correctamente.
        <script src="https://cdn.tailwindcss.com"></script>
    -->
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        /* Custom styles to complement Tailwind */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc; /* light gray background */
        }
        .hero-section {
            background-size: cover;
            background-position: center;
            height: 75vh;
            transition: background-image 1s ease-in-out; /* Transición suave para el cambio de imagen */
        }
        .post-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-size: cover;
            background-position: center;
            border: 2px solid #fff;
        }
    </style>

<div class="text-gray-800">

    <!-- Header / Navbar -->
    <header class="bg-white/80 backdrop-blur-md shadow-sm fixed top-0 left-0 right-0 z-50">
        <nav class="container mx-auto px-6 py-3">
            <div class="flex justify-between items-center">
                <a href="{{ route('home') }}" class="flex items-center space-x-2 text-2xl font-bold text-gray-800">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    <span>NeuroLuxWeb</span>
                </a>

                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('home') }}" class="text-gray-600 hover:text-blue-600 transition duration-300">Inicio</a>
                    <a href="{{ route('nosotros.index') }}" class="text-gray-600 hover:text-blue-600 transition duration-300">Sobre Nosotros</a>
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

    <main>
        <!-- Hero Section con capa de contraste -->
        <section class="hero-section relative text-white flex items-center justify-center">
            
            <!-- Capa oscura semitransparente para mejorar la legibilidad del texto -->
            <div class="absolute inset-0 bg-black/60 z-10"></div>

            <!-- Contenido de texto, ahora con z-20 para estar por encima de la capa oscura -->
            <div class="container mx-auto px-6 text-center relative z-20">
                <div class="max-w-4xl mx-auto">
                    <h1 class="text-4xl md:text-6xl font-bold">Herramienta digital para potenciar el aprendizaje</h1>
                    <p class="mt-4 text-lg md:text-xl text-gray-200">
                        NeuroLux TEA combina herramientas educativas, sensoriales y terapéuticas para mejorar la comunicación, autorregulación e interacción social en niños con TEA.
                    </p>
                </div>
            </div>
        </section>
        <!-- Features Section -->
        <section class="py-20 bg-white">
            <div class="container mx-auto px-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 pt-12">
                    <!-- Feature 1 -->
                    <div class="text-center p-8 bg-gray-50 rounded-xl shadow-md hover:shadow-xl transition-shadow duration-300">
                        <div class="flex items-center justify-center h-16 w-16 bg-blue-100 text-blue-600 rounded-full mx-auto mb-4">
                            <i class="fas fa-puzzle-piece fa-2x"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Desarrollo Integral</h3>
                        <p class="text-gray-600">Abarca comunicación, cognición, rutinas y habilidades socioemocionales en una sola plataforma.</p>
                    </div>
                    <!-- Feature 2 -->
                    <div class="text-center p-8 bg-gray-50 rounded-xl shadow-md hover:shadow-xl transition-shadow duration-300">
                        <div class="flex items-center justify-center h-16 w-16 bg-green-100 text-green-600 rounded-full mx-auto mb-4">
                            <i class="fas fa-cogs fa-2x"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Personalización Avanzada</h3>
                        <p class="text-gray-600">Adapta colores, sonidos, pictogramas y niveles de dificultad a las necesidades sensoriales de cada niño.</p>
                    </div>
                    <!-- Feature 3 -->
                    <div class="text-center p-8 bg-gray-50 rounded-xl shadow-md hover:shadow-xl transition-shadow duration-300">
                        <div class="flex items-center justify-center h-16 w-16 bg-purple-100 text-purple-600 rounded-full mx-auto mb-4">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Seguimiento Colaborativo</h3>
                        <p class="text-gray-600">Permite a padres, terapeutas y docentes registrar y compartir avances de forma organizada y accesible.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- About/Mission Section -->
        <section class="py-20">
            <div class="container mx-auto px-6">
                <div class="flex flex-col md:flex-row items-center gap-12">
                    <div class="md:w-1/2">
                        <img src="{{ asset('imagenes/NuestraMicion.png') }}" alt="Equipo de NeuroLux trabajando en la aplicación" class="rounded-xl shadow-2xl w-full"
                        onerror="this.onerror=null;this.src='https://placehold.co/600x400/3498db/ffffff?text=Error+cargando+imagen';">
                    </div>
                    <div class="md:w-1/2">
                        <h2 class="text-3xl font-bold mb-4">Transformando el Aprendizaje en una Experiencia Única</h2>
                        <p class="text-gray-600 mb-4">
                            NeuroLux TEA nace de la necesidad de herramientas efectivas y accesibles. Nuestro enfoque validado en campo integra tecnología y empatía para crear un entorno de aprendizaje seguro y motivador, fortaleciendo el vínculo entre los niños y sus cuidadores.
                        </p>
                        <p class="text-gray-600 mb-6">
                            Colaboramos estrechamente con psicólogos, neurólogos y docentes para asegurar que nuestra solución sea práctica, relevante y verdaderamente impactante.
                        </p>
                        <a href="{{ route('nosotros.index') }}" class="px-6 py-3 text-white bg-gray-800 hover:bg-black rounded-lg font-semibold transition duration-300">Conoce más sobre nosotros</a>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Join Community Section -->
        <section class="py-20 bg-blue-600 text-white">
            <div class="container mx-auto px-6 text-center">
                 <div class="max-w-3xl mx-auto">
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">Únete a Nuestra Comunidad</h2>
                    <p class="text-lg md:text-xl mb-8 text-blue-200">
                        Forma parte de un movimiento que apoya el desarrollo y la inclusión a través de la tecnología.
                    </p>
                    <a href="#" class="px-8 py-3 bg-white text-blue-600 font-bold rounded-lg shadow-lg hover:bg-gray-200 transition duration-300 transform hover:scale-105">
                        Conoce Más
                    </a>
                 </div>
            </div>
        </section>
        
        <script>
            // Script para el carrusel de imágenes de fondo
            document.addEventListener('DOMContentLoaded', function () {
                const heroSection = document.querySelector('.hero-section');
                const images = [
                    "{{ asset('imagenes/lux.png') }}"
                ];
                let currentImageIndex = 0;
    
                function changeBackgroundImage() {
                    currentImageIndex = (currentImageIndex + 1) % images.length;
                    heroSection.style.backgroundImage = `url('${images[currentImageIndex]}')`;
                }
    
                heroSection.style.backgroundImage = `url('${images[currentImageIndex]}')`;
    
                setInterval(changeBackgroundImage, 5000);
            });
        </script>

    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
        <div class="container mx-auto px-6 py-10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">NeuroLuxWeb</h3>
                    <p class="text-gray-400">Transformando ideas en realidad digital ilimitada para un aprendizaje inclusivo.</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Enlaces Rápidos</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('nosotros.index') }}" class="text-gray-400 hover:text-white">Sobre Nosotros</a></li>
                        <li><a href="{{ route('blog.index') }}" class="text-gray-400 hover:text-white">Blog</a></li>
                        <!-- ENLACE AÑADIDO EN FOOTER -->
                        <li><a href="{{ route('subscriptions.index') }}" class="text-gray-400 hover:text-white">Planes</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Contacto</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Síguenos</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-facebook fa-2x"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-twitter fa-2x"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-linkedin fa-2x"></i></a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-6 text-center text-gray-500">
                <p>&copy; {{ date('Y') }} NeuroLux. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

</div>

<!-- Modal para editar el perfil (estilo Bootstrap) -->
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
