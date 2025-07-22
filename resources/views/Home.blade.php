<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>LuxWeb - Inicio</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
</head>
<body>
    <!-- ENCABEZADO SUPERIOR -->
    <header>
        <div class="top-bar">
            <div class="logo">
                <img src="{{ asset('img/logo.png') }}" alt="Logo LuxWeb">
                <span>LuxWeb</span>
            </div>
            <nav class="main-menu">
                <a href="#">Inicio</a>
                <a href="#">Sobre mí</a>
                <a href="#">Servicios</a>
                <a href="{{ route('blog') }}">Blog</a>
                <a href="#">Contacto</a>
            </nav>
        </div>
    </header>
        
    </section>
    <section class="bloques">
        <div class="bloque">
            <h2>Blog</h2>
            <img src="{{ asset('img/blog.jpg') }}" alt="Blog">
        </div>
        <div class="bloque">
            <h2>Servicios</h2>
            <img src="{{ asset('img/servicios.jpg') }}" alt="Servicios">
        </div>
        <div class="bloque">
            <h2>Tienda</h2>
            <img src="{{ asset('img/tienda.jpg') }}" alt="Tienda">
        </div>
    </section>
</body>
</html>
