@extends('layouts.app')

@section('content')   
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .post-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background-size: cover;
            background-position: center;
        }
    </style>

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
                <!-- AQUÍ ESTÁ EL ENLACE A SEGUIMIENTO -->
                <a href="{{ route('seguimiento.index') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-700 hover:text-white transition-colors">
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
            <div class="max-w-3xl mx-auto">
                <!-- Barra superior (Topbar) -->
                <div class="flex justify-between items-center mb-8">
                    <div class="relative w-full max-w-md">
                        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="search" placeholder="Buscar en el blog..." class="w-full bg-white pl-12 pr-4 py-2.5 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="flex items-center space-x-4">
                        @guest
                            <a href="{{ route('login') }}" class="px-5 py-2.5 text-sm font-semibold text-gray-700 bg-white border border-gray-300 rounded-full hover:bg-gray-50 transition-colors">Iniciar Sesión</a>
                            <a href="{{ route('registro') }}" class="px-5 py-2.5 text-sm font-semibold text-white bg-blue-600 rounded-full hover:bg-blue-700 transition-colors">Registrarse</a>
                        @else
                            <button class="px-5 py-2.5 text-sm font-semibold text-white bg-blue-600 rounded-full hover:bg-blue-700 transition-colors" data-bs-toggle="modal" data-bs-target="#createPostModal">
                                <i class="fas fa-plus mr-2"></i>Crear Post
                            </button>
                            
                            <div class="flex items-center space-x-3">
                                <div class="post-avatar" style="background-image: url('{{ asset('storage/' . (Auth::user()->profile_photo_path ?? 'avatars/default.png')) }}')"></div>
                                <div class="font-semibold text-gray-800">{{ Auth::user()->name }}</div>
                                <button class="text-gray-500 hover:text-blue-600" data-bs-toggle="modal" data-bs-target="#editProfileModal" title="Editar Perfil">
                                    <i class="fas fa-user-edit"></i>
                                </button>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-gray-500 hover:text-red-600" title="Cerrar Sesión">
                                        <i class="fas fa-sign-out-alt"></i>
                                    </button>
                                </form>
                            </div>
                        @endguest
                    </div>
                </div>

                <!-- Feed de Publicaciones -->
                <div class="space-y-6">
                    @forelse ($posts as $post)
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <!-- Cabecera del Post -->
                        <div class="flex items-center mb-4">
                            <div class="post-avatar" style="background-image: url('{{ asset('storage/' . ($post->user->profile_photo_path ?? 'avatars/default.png')) }}')"></div>
                            <div class="ml-4">
                                <div class="font-bold text-gray-800">{{ $post->user->name }}</div>
                                <div class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</div>
                            </div>
                            <div class="ml-auto flex items-center space-x-2">
                                <div class="text-xs text-blue-500 font-semibold bg-blue-100 px-2 py-1 rounded-full">#{{ implode(' #', explode(' ', $post->tags ?? 'general')) }}</div>
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

                        <!-- Contenido del Post -->
                        <div class="mb-4">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $post->title }}</h3>
                            <p class="text-gray-700 leading-relaxed">{{ $post->content }}</p>
                        </div>
                        
                        <!-- Imagen del Post -->
                        @if(isset($post->image_path))
                            <div class="rounded-lg overflow-hidden mb-4">
                                <img src="{{ asset('storage/' . $post->image_path) }}" alt="Imagen del post" class="w-full h-auto object-cover" />
                            </div>
                        @endif

                        <!-- Acciones del Post -->
                        <div class="flex items-center justify-around text-gray-500 border-t border-gray-200 pt-4">
                            <button class="like-btn flex items-center space-x-2 hover:text-red-500 transition-colors" data-post-id="{{ $post->id }}" style="color: {{ Auth::check() && $post->likes->contains('user_id', Auth::id()) ? 'rgb(239, 68, 68)' : 'rgb(107, 114, 128)' }};">
                                <i class="fas fa-heart"></i>
                                <span class="likes-count font-medium">{{ $post->likes->count() }}</span>
                            </button>
                             <button class="comment-btn flex items-center space-x-2 hover:text-blue-500 transition-colors" data-bs-toggle="modal" data-bs-target="#commentsModal" data-post-id="{{ $post->id }}">
                                <i class="fas fa-comment"></i>
                                <span class="comments-count font-medium">{{ $post->comments->count() }}</span>
                            </button>
                             <button class="flex items-center space-x-2 hover:text-green-500 transition-colors">
                                <i class="fas fa-share-square"></i>
                                <span class="font-medium">Compartir</span>
                            </button>
                        </div>
                    </div>
                    @empty
                        <div class="bg-white rounded-xl shadow-md p-8 text-center text-gray-500">
                            <p class="text-lg">Aún no hay publicaciones en el blog.</p>
                            <p>¡Sé el primero en crear una!</p>
                        </div>
                    @endforelse
                </div>
                
                <!-- Paginación -->
                @if ($posts->lastPage() > 1)
                    <div class="mt-8">
                        {{ $posts->links() }}
                    </div>
                @endif

            </div>
        </main>
    </div>
</div>

<!-- INICIO DE MODALES -->
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

{{-- Modal para crear un nuevo post --}}
<div class="modal fade" id="createPostModal" tabindex="-1" aria-labelledby="createPostModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createPostModalLabel">Crear nuevo post</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('blog.storePost') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="postTitle" class="form-label">Título</label>
                        <input type="text" class="form-control" id="postTitle" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="postContent" class="form-label">Contenido</label>
                        <textarea class="form-control" id="postContent" name="content" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="postTags" class="form-label">Etiquetas (separadas por espacio)</label>
                        <input type="text" class="form-control" id="postTags" name="tags">
                    </div>
                    <div class="mb-3">
                        <label for="postImage" class="form-label">Subir imagen</label>
                        <input class="form-control" type="file" id="postImage" name="image">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Crear Post</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal para editar un post existente --}}
<div class="modal fade" id="editPostModal" tabindex="-1" aria-labelledby="editPostModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPostModalLabel">Editar Post</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editPostForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editPostTitle" class="form-label">Título</label>
                        <input type="text" class="form-control" id="editPostTitle" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="editPostContent" class="form-label">Contenido</label>
                        <textarea class="form-control" id="editPostContent" name="content" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="editPostTags" class="form-label">Etiquetas (separadas por espacio)</label>
                        <input type="text" class="form-control" id="editPostTags" name="tags">
                    </div>
                    <div class="mb-3">
                        <label for="editPostImage" class="form-label">Subir nueva imagen</label>
                        <input class="form-control" type="file" id="editPostImage" name="image">
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

{{-- Modal de Comentarios --}}
<div class="modal fade" id="commentsModal" tabindex="-1" aria-labelledby="commentsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="commentsModalLabel">Comentarios</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="commentsContainer" class="mb-4">
                    {{-- Los comentarios se cargarán aquí dinámicamente --}}
                </div>
                <form id="addCommentForm" method="POST">
                    @csrf
                    <div class="input-group">
                        <input type="text" class="form-control" name="content" placeholder="Escribe un comentario..." required>
                        <button class="btn btn-primary" type="submit">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- FIN DE MODALES -->


<!-- SCRIPTS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // JS para manejar el formulario de edición
        const editPostModal = document.getElementById('editPostModal');
        if (editPostModal) {
            editPostModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const postId = button.getAttribute('data-post-id');
                const postTitle = button.getAttribute('data-post-title');
                const postContent = button.getAttribute('data-post-content');
                const postTags = button.getAttribute('data-post-tags');

                const modalTitle = editPostModal.querySelector('.modal-title');
                const modalBodyInputTitle = editPostModal.querySelector('#editPostTitle');
                const modalBodyInputContent = editPostModal.querySelector('#editPostContent');
                const modalBodyInputTags = editPostModal.querySelector('#editPostTags');
                const form = editPostModal.querySelector('#editPostForm');

                modalBodyInputTitle.value = postTitle;
                modalBodyInputContent.value = postContent;
                modalBodyInputTags.value = postTags;
                form.action = '/blog/' + postId;
            });
        }

        // JS para manejar los likes con jQuery
        $('.like-btn').on('click', function(e) {
            e.preventDefault();
            var button = $(this);
            var postId = button.data('post-id');
            
            $.ajax({
                url: '/blog/' + postId + '/like',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    button.find('.likes-count').text(response.likes_count);
                    if (response.status === 'liked') {
                        button.css('color', 'rgb(239, 68, 68)'); // red-500
                    } else {
                        button.css('color', 'rgb(107, 114, 128)'); // gray-500
                    }
                },
                error: function(error) {
                    console.error('Error al dar like:', error);
                    // Opcional: Re-autenticar al usuario si el error es 401
                    if(error.status === 401) {
                        window.location.href = '/login';
                    }
                }
            });
        });

        // JS para manejar los comentarios con jQuery
        $('#commentsModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var postId = button.data('post-id');
            
            loadComments(postId);

            $('#addCommentForm').off('submit').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                var content = form.find('input[name="content"]').val();

                $.ajax({
                    url: '/blog/' + postId + '/comment',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        content: content
                    },
                    success: function() {
                        loadComments(postId); // Recargar comentarios
                        form.find('input[name="content"]').val(''); // Limpiar input
                        // Actualizar contador en la página principal
                        var commentCountSpan = $('.comment-btn[data-post-id="' + postId + '"]').find('.comments-count');
                        var currentCount = parseInt(commentCountSpan.text());
                        commentCountSpan.text(currentCount + 1);
                    },
                    error: function(error) {
                         if(error.status === 401) {
                            alert('Debes iniciar sesión para comentar.');
                            window.location.href = '/login';
                        }
                    }
                });
            });
        });

        function loadComments(postId) {
            var commentsContainer = $('#commentsContainer');
            commentsContainer.html('<p class="text-center">Cargando comentarios...</p>');

            $.ajax({
                url: '/blog/' + postId + '/comments', // Asegúrate que esta ruta exista en web.php
                type: 'GET',
                success: function(comments) {
                    commentsContainer.empty();
                    if (comments.length > 0) {
                        comments.forEach(function(comment) {
                            var defaultAvatar = '{{ asset("avatars/default.png") }}';
                            var avatarUrl = comment.user.profile_photo_path ? '{{ asset("storage") }}/' + comment.user.profile_photo_path : defaultAvatar;

                            var commentHtml = `
                                <div class="d-flex align-items-start mb-3">
                                    <img src="${avatarUrl}" class="rounded-circle" style="width: 40px; height: 40px; margin-right: 15px;">
                                    <div class="w-100">
                                        <div class="d-flex justify-content-between">
                                            <strong class="text-dark">${comment.user.name}</strong>
                                            <small class="text-muted">${new Date(comment.created_at).toLocaleString()}</small>
                                        </div>
                                        <p class="mb-0">${comment.content}</p>
                                    </div>
                                </div>
                            `;
                            commentsContainer.append(commentHtml);
                        });
                    } else {
                        commentsContainer.append('<p class="text-center text-muted">No hay comentarios aún. ¡Sé el primero!</p>');
                    }
                },
                error: function() {
                    commentsContainer.html('<p class="text-center text-danger">No se pudieron cargar los comentarios.</p>');
                }
            });
        }
    });
</script>
@endsection
