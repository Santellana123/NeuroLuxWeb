{{-- resources/views/partials/modals.blade.php --}}

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
                    {{-- Los comentarios se cargarán aquí dinámicamente vía JS --}}
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