<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <div class="login-container">
        <h3>Iniciar Sesión</h3>

        {{-- Mensaje de error --}}
        @if(session('error'))
            <div class="error-message">{{ session('error') }}</div>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf

            {{-- Campo de Correo --}}
            <div class="input-group">
                <label for="email">Correo</label>
                <input type="email" name="email" id="email" required>
            </div>

            {{-- Campo de Contraseña --}}
            <div class="input-group">
                <label for="password">Contraseña</label>
                <input type="password" name="password" id="password" required>
            </div>

            {{-- Botón Ingresar --}}
            <button type="submit" class="btn">Ingresar</button>

            {{-- Enlace para Registrarse --}}
            <div class="register-link">
                <a href="{{ route('register') }}">Registrarse</a>
            </div>
        </form>
    </div>

</body>
</html>
