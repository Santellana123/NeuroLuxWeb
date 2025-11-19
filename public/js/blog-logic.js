/* public/js/blog-logic.js */

document.addEventListener('DOMContentLoaded', function () {
    
    // Configuración Global (CSRF Token para Ajax)
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // 1. Lógica para el Modal de Editar Post
    const editPostModal = document.getElementById('editPostModal');
    if (editPostModal) {
        editPostModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            // Extraer info de los data-attributes
            const postId = button.getAttribute('data-post-id');
            const postTitle = button.getAttribute('data-post-title');
            const postContent = button.getAttribute('data-post-content');
            const postTags = button.getAttribute('data-post-tags');

            // Rellenar el formulario
            editPostModal.querySelector('#editPostTitle').value = postTitle;
            editPostModal.querySelector('#editPostContent').value = postContent;
            editPostModal.querySelector('#editPostTags').value = postTags;
            editPostModal.querySelector('#editPostForm').action = '/blog/' + postId;
        });
    }

    // 2. Lógica de Likes
    $('.like-btn').on('click', function(e) {
        e.preventDefault();
        var button = $(this);
        var postId = button.data('post-id');
        
        $.ajax({
            url: '/blog/' + postId + '/like',
            type: 'POST',
            // No necesitamos enviar _token aquí si usamos ajaxSetup arriba
            success: function(response) {
                button.find('.likes-count').text(response.likes_count);
                // Cambiar clases de Tailwind en lugar de CSS directo
                if (response.status === 'liked') {
                    button.removeClass('text-gray-500').addClass('text-red-500');
                    button.css('color', 'rgb(239, 68, 68)'); // Fallback visual
                } else {
                    button.removeClass('text-red-500').addClass('text-gray-500');
                    button.css('color', 'rgb(107, 114, 128)'); // Fallback visual
                }
            },
            error: function(error) {
                if(error.status === 401) window.location.href = '/login';
            }
        });
    });

    // 3. Lógica de Comentarios
    $('#commentsModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var postId = button.data('post-id');
        
        loadComments(postId);

        // Manejar envío de nuevo comentario
        $('#addCommentForm').off('submit').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);
            var contentInput = form.find('input[name="content"]');
            var content = contentInput.val();

            $.ajax({
                url: '/blog/' + postId + '/comment',
                type: 'POST',
                data: { content: content },
                success: function() {
                    loadComments(postId);
                    contentInput.val('');
                    // Actualizar contador visual en el post
                    var counter = $('.comment-btn[data-post-id="' + postId + '"]').find('.comments-count');
                    counter.text(parseInt(counter.text()) + 1);
                },
                error: function(error) {
                    if(error.status === 401) {
                        alert('Inicia sesión para comentar.');
                        window.location.href = '/login';
                    }
                }
            });
        });
    });

    // Función auxiliar para cargar comentarios
    function loadComments(postId) {
        var container = $('#commentsContainer');
        container.html('<p class="text-center text-gray-500">Cargando...</p>');

        $.ajax({
            url: '/blog/' + postId + '/comments',
            type: 'GET',
            success: function(comments) {
                container.empty();
                if (comments.length > 0) {
                    comments.forEach(function(comment) {
                        // Usamos la variable global window.appConfig definida en Blade
                        var avatarPath = comment.user.profile_photo_path 
                            ? window.appConfig.storageUrl + '/' + comment.user.profile_photo_path 
                            : window.appConfig.defaultAvatar;

                        var html = `
                            <div class="flex items-start space-x-3 mb-4">
                                <img src="${avatarPath}" class="w-10 h-10 rounded-full object-cover">
                                <div class="flex-1 bg-gray-50 p-3 rounded-lg">
                                    <div class="flex justify-between items-baseline">
                                        <strong class="text-sm text-gray-900">${comment.user.name}</strong>
                                        <small class="text-xs text-gray-500">${new Date(comment.created_at).toLocaleString()}</small>
                                    </div>
                                    <p class="text-sm text-gray-700 mt-1">${comment.content}</p>
                                </div>
                            </div>`;
                        container.append(html);
                    });
                } else {
                    container.append('<p class="text-center text-gray-400 text-sm">Sin comentarios aún.</p>');
                }
            },
            error: function() {
                container.html('<p class="text-center text-red-500">Error al cargar.</p>');
            }
        });
    }
});