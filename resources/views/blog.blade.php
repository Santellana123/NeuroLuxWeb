<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>NeuroLuxWeb - Blog</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">NeuroLuxWeb</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('Home') }}">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('Login') }}">Login</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <!-- Blog Post Creation -->
        <div class="card mb-4">
            <div class="card-header">Crear nuevo blog</div>
            <div class="card-body">
                <form>
                    <div class="mb-3">
                        <label for="blogImage" class="form-label">Subir imagen</label>
                        <input class="form-control" type="file" id="blogImage">
                    </div>
                    <div class="mb-3">
                        <label for="blogContent" class="form-label">Contenido</label>
                        <textarea class="form-control" id="blogContent" rows="3" placeholder="Escribe tu blog aquí..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Publicar</button>
                </form>
            </div>
        </div>

        <!-- Blog List Example -->
        <h3 class="mb-3">Blogs de la comunidad</h3>
        <div class="row">
            <!-- Blog Card Example -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span><strong>Juan Pérez</strong></span>
                        <span class="text-muted" style="font-size: 0.9em;">2025-07-4</span>
                    </div>
                    <img src="https://via.placeholder.com/400x200" class="card-img-top" alt="Imagen del blog">
                    <div class="card-body">
                        <p class="card-text">Este es un ejemplo de contenido de blog V:</p>
                        <div class="d-flex mb-2">
                            <button class="btn btn-outline-primary btn-sm me-2">👍 Like</button>
                            <button class="btn btn-outline-secondary btn-sm me-2">💬 Comentar</button>
                            <button class="btn btn-outline-success btn-sm">🔗 Compartir</button>
                        </div>
                        <div>
                            <input type="text" class="form-control" placeholder="Escribe un comentario...">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Puedes duplicar el bloque anterior para más blogs -->
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>