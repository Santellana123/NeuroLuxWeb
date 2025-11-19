@extends('layouts.app')

{{-- SECCIÓN DE ESTILOS --}}
@section('styles')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    {{-- Aquí cargamos tu CSS extraído --}}
    <link rel="stylesheet" href="{{ asset('css/blog-custom.css') }}">
@endsection

{{-- SECCIÓN DE CONTENIDO --}}
@section('content')
<div class="bg-gray-100">
    <div class="flex min-h-screen">
        
        <aside class="w-64 bg-gray-900 text-gray-300 p-4 fixed h-full shadow-lg z-10">
            <div class="text-white text-2xl font-bold mb-10 pl-2">NeuroLux</div>
            <nav class="space-y-2">
                <a href="{{ route('blog.index') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-700 hover:text-white transition-colors">
                    <i class="fas fa-home w-6 text-center"></i><span class="ml-4">Home</span>
                </a>
                <a href="{{ route('nosotros.index') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-700 hover:text-white transition-colors">
                    <i class="fas fa-users w-6 text-center"></i><span class="ml-4">Nosotros</span>
                </a>
                <a href="{{ route('seguimiento.index') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-700 hover:text-white transition-colors">
                    <i class="fas fa-chart-line w-6 text-center"></i><span class="ml-4">Seguimiento</span>
                </a>
                <a href="#" class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-700 hover:text-white transition-colors">
                    <i class="fas fa-cog w-6 text-center"></i><span class="ml-4">Configuración</span>
                </a>
            </nav>
        </aside>

        <main class="flex-1 ml-64 p-8">
            <div class="max-w-3xl mx-auto">
                
                <div class="flex justify-between items-center mb-8">
                    <div class="relative w-full max-w-md">
                        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="search" placeholder="Buscar en el blog..." class="w-full bg-white pl-12 pr-4 py-2.5 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="flex items-center space-x-4">
                        @guest
                            <a href="{{ route('login') }}" class="px-5 py-2.5 text-sm font-semibold text-gray-700 bg-white border border-gray-300 rounded-full hover:bg-gray-50">Iniciar Sesión</a>
                            <a href="{{ route('registro') }}" class="px-5 py-2.5 text-sm font-semibold text-white bg-blue-600 rounded-full hover:bg-blue-700">Registrarse</a>
                        @else
                            <button class="px-5 py-2.5 text-sm font-semibold text-white bg-blue-600 rounded-full hover:bg-blue-700 transition-colors" data-bs-toggle="modal" data-bs-target="#createPostModal">
                                <i class="fas fa-plus mr-2"></i>Crear Post
                            </button>
                            
                            <div class="flex items-center space-x-3">
                                <div class="post-avatar" style="background-image: url('{{ asset('storage/' . (Auth::user()->profile_photo_path ?? 'avatars/default.png')) }}')"></div>
                                <div class="font-semibold text-gray-800">{{ Auth::user()->name }}</div>
                                <button class="text-gray-500 hover:text-blue-600" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                                    <i class="fas fa-user-edit"></i>
                                </button>
                                <form action="{{ route('logout') }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-gray-500 hover:text-red-600"><i class="fas fa-sign-out-alt"></i></button>
                                </form>
                            </div>
                        @endguest
                    </div>
                </div>

                <div class="space-y-6">
                    @forelse ($posts as $post)
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <div class="flex items-center mb-4">
                            <div class="post-avatar" style="background-image: url('{{ asset('storage/' . ($post->user->profile_photo_path ?? 'avatars/default.png')) }}')"></div>
                            <div class="ml-4">
                                <div class="font-bold text-gray-800">{{ $post->user->name }}</div>
                                <div class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</div>
                            </div>
                            <div class="ml-auto flex items-center space-x-2">
                                <span class="text-xs text-blue-500 font-semibold bg-blue-100 px-2 py-1 rounded-full">#{{ implode(' #', explode(' ', $post->tags ?? 'general')) }}</span>
                                @if (Auth::check() && Auth::user()->id === $post->user_id)
                                    <button class="text-gray-400 hover:text-blue-600" 
                                            data-bs-toggle="modal" data-bs-target="#editPostModal"
                                            data-post-id="{{ $post->id }}"
                                            data-post-title="{{ $post->title }}"
                                            data-post-content="{{ $post->content }}"
                                            data-post-tags="{{ $post->tags }}">
                                        <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                @endif
                            </div>
                        </div>

                        <div class="mb-4">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $post->title }}</h3>
                            <p class="text-gray-700 leading-relaxed">{{ $post->content }}</p>
                        </div>
                        
                        @if(isset($post->image_path))
                            <div class="rounded-lg overflow-hidden mb-4">
                                <img src="{{ asset('storage/' . $post->image_path) }}" class="w-full h-auto object-cover" />
                            </div>
                        @endif

                        <div class="flex items-center justify-around border-t border-gray-200 pt-4">
                            {{-- Lógica de color movida a clases de Tailwind para limpieza --}}
                            @php 
                                $userLiked = Auth::check() && $post->likes->contains('user_id', Auth::id());
                                $likeClass = $userLiked ? 'text-red-500' : 'text-gray-500';
                            @endphp
                            
                            <button class="like-btn flex items-center space-x-2 hover:text-red-500 transition-colors {{ $likeClass }}" 
                                    data-post-id="{{ $post->id }}">
                                <i class="fas fa-heart"></i>
                                <span class="likes-count font-medium">{{ $post->likes->count() }}</span>
                            </button>

                            <button class="comment-btn flex items-center space-x-2 hover:text-blue-500 transition-colors text-gray-500" 
                                    data-bs-toggle="modal" data-bs-target="#commentsModal" data-post-id="{{ $post->id }}">
                                <i class="fas fa-comment"></i>
                                <span class="comments-count font-medium">{{ $post->comments->count() }}</span>
                            </button>
                            
                            <button class="flex items-center space-x-2 hover:text-green-500 transition-colors text-gray-500">
                                <i class="fas fa-share-square"></i><span class="font-medium">Compartir</span>
                            </button>
                        </div>
                    </div>
                    @empty
                        <div class="bg-white rounded-xl shadow-md p-8 text-center text-gray-500">
                            <p class="text-lg">Aún no hay publicaciones.</p>
                        </div>
                    @endforelse
                </div>
                
                @if ($posts->lastPage() > 1)
                    <div class="mt-8">{{ $posts->links() }}</div>
                @endif
            </div>
        </main>
    </div>
</div>

{{-- Incluimos los modales que extrajimos al archivo partial --}}
@include('partials.modals')

@endsection

{{-- SECCIÓN DE SCRIPTS --}}
@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    {{-- IMPORTANTE: Pasamos variables de Blade a JS global --}}
    <script>
        window.appConfig = {
            storageUrl: "{{ asset('storage') }}",
            defaultAvatar: "{{ asset('avatars/default.png') }}",
            csrfToken: "{{ csrf_token() }}"
        };
    </script>

    {{-- Cargamos tu lógica JS externa --}}
    <script src="{{ asset('js/blog-logic.js') }}"></script>
@endsection