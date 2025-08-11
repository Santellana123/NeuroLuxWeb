@extends('layouts.app')

@section('content')
    {{-- Barra superior (Navbar) --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('logo.png') }}" alt="Logo NeurOLux"> 
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Sobre mí</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('blog.index') }}">Blog</a></li>
                </ul>

                {{-- Opciones de autenticación (Login/Perfil) --}}
                <div class="d-flex">
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-primary me-2">Iniciar Sesión</a>
                        <a href="{{ route('registro') }}" class="btn btn-outline-light">Registrarse</a>
                    @else
                        <div class="user-info d-flex align-items-center">
                            {{-- Avatar del usuario --}}
                            <div class="post-avatar me-2" style="background-image: url('{{ asset('storage/' . (Auth::user()->profile_photo_path ?? 'avatars/default.png')) }}')"></div>
                            <div class="me-auto fw-bold text-white me-2">{{ Auth::user()->name }}</div>
                            
                            {{-- Botón para editar perfil --}}
                            <button class="btn btn-light btn-sm me-2" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                                Editar Perfil
                            </button>
                            
                            {{-- Botón para cerrar sesión --}}
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline-light btn-sm">Cerrar Sesión</button>
                            </form>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </nav>
    
    {{-- Contenido principal --}}
    <main>
        {{-- Sección de banner principal --}}
        <div class="hero-banner">
            <div class="hero-content">
                <h1 class="display-4 fw-bold">Monitorea el progreso de tus hijos</h1>
                <p class="lead">Una plataforma que te ayuda a estar al tanto del aprendizaje y desarrollo de tus hijos.</p>
                <div class="mt-4">
                    {{-- Botones de acción del banner --}}
                    <a href="{{ route('blog.index') }}" class="btn btn-primary btn-lg me-2">Ir al Blog ></a>
                </div>
            </div>
        </div>

        {{-- Sección de dos columnas (Blog y Nosotros) --}}
        <section class="container my-5">
            <div class="row justify-content-center text-center">
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <img src="{{ asset('img/blog_placeholder.jpg') }}" class="card-img-top" alt="Imagen del blog">
                        <div class="card-body">
                            <h4 class="card-title">Blog</h4>
                            <p class="card-text">Lee artículos interesantes sobre el desarrollo y aprendizaje de tus hijos.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <img src="{{ asset('img/about_placeholder.jpg') }}" class="card-img-top" alt="Imagen de sobre mí">
                        <div class="card-body">
                            <h4 class="card-title">Sobre mí</h4>
                            <p class="card-text">Descubre la historia y la visión detrás de nuestra plataforma de monitoreo.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-light text-center p-3 mt-auto">
        &copy; {{ date('Y') }} MonitoreoPadres. Todos los derechos reservados.
    </footer>

    {{-- Modal para editar el perfil --}}
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