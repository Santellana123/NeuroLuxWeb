<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
</head>
<body>
    <h1>Formulario de Registro</h1>
    <form action="{{ route('Registro.store') }}" method="POST">
        @csrf
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>
        <br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <br>

        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>
        <br>

        <button type="submit">Registrar</button>
</body>
</html>
