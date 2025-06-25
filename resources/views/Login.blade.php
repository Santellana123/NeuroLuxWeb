<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h1>Iniciar Sesión</h1>

    <form action="#" method="POST">
        @csrf
        <label for="email">Correo:</label>
        <input type="email" name="email" required><br>

        <label for="password">Contraseña:</label>
        <input type="password" name="password" required><br>

        <button type="submit">Entrar</button>
        <button type="button" onclick="location.href='{{ route('Registro') }}'">Registrarse</button>
    </form>
</body>
</html>
