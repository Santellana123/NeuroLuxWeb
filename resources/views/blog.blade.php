@extends('layouts.app')

@section('content')
<div class="app-layout">
    {{-- Barra lateral --}}
    <div class="sidebar">
        <div class="logo">NeurOLux</div>
        <a href="{{ route('home') }}"><span class="icon">&#x1F3E0;</span> Home</a>
        <a href="#"><span class="icon">&#x1F464;</span> Nosotros</a>
        <a href="#"><span class="icon">&#x1F4CA;</span> Seguimiento</a>
        <a href="#"><span class="icon">&#x2699;&#xFE0F;</span> Configuración</a>
    </div>

    {{-- Contenido principal --}}
    <div class="main-content">
        {{-- Barra superior con búsqueda y opciones de autenticación --}}
        <div class="topbar">
            <input type="search" placeholder="Buscar..." aria-label="Buscar" />

            @guest
                <div class="auth-buttons">
                    <a href="{{ route('login') }}">Iniciar Sesión</a>
                    <a href="{{ route('registro') }}">Registrarse</a>
                </div>
            @else
                <div class="user-info d-flex align-items-center">
                    {{-- Avatar del usuario --}}
                    <div class="post-avatar me-2" style="background-image: url('{{ asset('storage/' . (Auth::user()->profile_photo_path ?? 'avatars/default.png')) }}')"></div>
                    <div class="me-auto fw-bold">{{ Auth::user()->name }}</div>
                    
                    {{-- Botón para editar perfil --}}
                    <button class="btn btn-primary btn-sm me-2" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                        Editar Perfil
                    </button>
                    
                    {{-- Botón para crear un post (restaurado) --}}
                    <button class="create-btn" data-bs-toggle="modal" data-bs-target="#createPostModal">Crear +</button>

                    {{-- Botón para cerrar sesión --}}
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm">Cerrar Sesión</button>
                    </form>
                </div>
            @endguest
        </div>

        {{-- Bucle para mostrar las publicaciones dinámicas --}}
        @foreach ($posts as $post)
        <div class="post-card">
            <div class="post-header">
                {{-- Avatar del usuario que creó el post --}}
                <div class="post-avatar" style="background-image: url('{{ asset('storage/' . ($post->user->profile_photo_path ?? 'avatars/default.png')) }}')"></div>
                {{-- Nombre de usuario del creador del post --}}
                <div class="post-username">{{ $post->user->name }}</div>
                {{-- Etiquetas (tags) del post --}}
                <div class="post-tags">#{{ implode(' #', explode(' ', $post->tags ?? 'tags')) }}</div>
                
                {{-- Botón de edición, solo si el post pertenece al usuario actual --}}
                @if (Auth::check() && Auth::user()->id === $post->user_id)
                    <button class="edit-btn" data-bs-toggle="modal" data-bs-target="#editPostModal"
                            data-post-id="{{ $post->id }}"
                            data-post-title="{{ $post->title }}"
                            data-post-content="{{ $post->content }}">
                        <span class="icon">&#x270E;</span>
                    </button>
                @endif
            </div>
            {{-- Contenido del post --}}
            <h4>{{ $post->title }}</h4>
            <div class="post-text">{{ $post->content }}</div>
            {{-- Muestra la imagen si existe, sino un marcador de posición --}}
            @if(isset($post->image_path))
                <img src="{{ asset('storage/' . $post->image_path) }}" alt="Imagen del post" class="post-image" />
            @endif
            {{-- Botones de acción del post --}}
            <div class="post-actions">
                <span class="like-btn" data-post-id="{{ $post->id }}" style="color: {{ Auth::check() && $post->likes->contains('user_id', Auth::id()) ? 'red' : 'gray' }}; cursor: pointer;">
                    &#10084; <span class="likes-count">{{ $post->likes->count() }}</span>
                </span>
                <span class="comment-btn" data-bs-toggle="modal" data-bs-target="#commentsModal" data-post-id="{{ $post->id }}">
                    &#128172; <span class="comments-count">{{ $post->comments->count() }}</span>
                </span>
                <span title="Compartir">&#128257;</span>
            </div>
        </div>
        @endforeach

        {{-- Paginación, se muestra solo si hay más de una página --}}
        @if ($posts->lastPage() > 1)
            <div class="pagination-container">
                {{ $posts->links() }}
            </div>
        @endif
    </div>
</div>

{{-- MODALES --}}
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
            <form id="editPostForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editPostTitle" class="form-label">Título</label>
                        <input type="text" class="form-control" id="editPostTitle" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="editPostContent" class="form-label">Contenido</label>
                        <textarea class="form-control" id="editPostContent" name="content" rows="3" required></textarea>
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
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="commentsModalLabel">Comentarios</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="commentsContainer" class="mb-4">
                    {{-- Los comentarios se cargarán aquí --}}
                </div>
                {{-- Formulario para añadir un nuevo comentario --}}
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // JS para manejar el formulario de edición
    $('#editPostModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Botón que activó el modal
        var postId = button.data('post-id');
        var postTitle = button.data('post-title');
        var postContent = button.data('post-content');

        var modal = $(this);
        modal.find('#editPostTitle').val(postTitle);
        modal.find('#editPostContent').val(postContent);
        
        // Se actualiza la acción del formulario para que apunte a la ruta correcta
        var form = modal.find('#editPostForm');
        form.attr('action', '/blog/' + postId + '/edit');
    });

    // JS para manejar los likes
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
                // Actualiza el contador de likes
                button.find('.likes-count').text(response.likes_count);
                
                // Cambia el color del botón
                if (response.status === 'liked') {
                    button.css('color', 'red');
                } else {
                    button.css('color', 'gray');
                }
            },
            error: function(error) {
                console.error('Error al dar like:', error);
            }
        });
    });

    // JS para manejar los comentarios
    $('.comment-btn').on('click', function(e) {
        e.preventDefault();
        var button = $(this);
        var postId = button.data('post-id');
        
        // Carga los comentarios existentes
        loadComments(postId);

        // Actualiza la acción del formulario de comentarios
        $('#addCommentForm').attr('action', '/blog/' + postId + '/comment');
    });

    function loadComments(postId) {
        // Simplemente para demostración, puedes obtener los datos reales desde una API si lo deseas
        var comments = {!! json_encode($posts->flatMap(fn($post) => $post->comments)->toArray()) !!}.filter(comment => comment.post_id === postId);
        var commentsContainer = $('#commentsContainer');
        commentsContainer.empty();
        
        if (comments.length > 0) {
            comments.forEach(comment => {
                var commentHtml = `
                    <div class="d-flex align-items-center mb-3">
                        <div class="post-avatar me-2" style="background-image: url('${comment.user.profile_photo_path || 'https://via.placeholder.com/40'}')"></div>
                        <div>
                            <div class="fw-bold">${comment.user.name}</div>
                            <div>${comment.content}</div>
                        </div>
                    </div>
                `;
                commentsContainer.append(commentHtml);
            });
        } else {
            commentsContainer.append('<p class="text-center text-muted">No hay comentarios aún.</p>');
        }
    }
</script>
@endsection