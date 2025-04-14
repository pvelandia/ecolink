<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenido a EcoLink</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-green-50 text-gray-800">
    <div class="min-h-screen flex flex-col items-center justify-center text-center px-6">
        <h1 class="text-4xl font-bold text-green-700 mb-4">¡Bienvenido a EcoLink! ♻️</h1>
        <p class="text-lg mb-6 max-w-2xl">
            Cuidar el planeta empieza por nosotros. Únete a nuestra misión de reducir, reutilizar y reciclar. 🌍  
            EcoLink te conecta con un sistema eficiente de gestión de residuos en Facatativá.
        </p>
        <div class="space-x-4">
            <a href="{{ route('login') }}" class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                Iniciar Sesión
            </a>
            <a href="{{ route('register') }}" class="px-6 py-3 border border-green-600 text-green-700 rounded-lg hover:bg-green-100 transition">
                Registrarse
            </a>
        </div>
    </div>
</body>
</html>
