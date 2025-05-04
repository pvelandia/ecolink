<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenido a EcoLink</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-green-50 to-green-100 text-gray-800">
    <div class="min-h-screen flex flex-col items-center justify-center px-6">
        <div class="bg-white rounded-2xl shadow-lg p-10 max-w-xl w-full text-center animate-fade-in">
            <h1 class="text-4xl font-extrabold text-green-700 mb-4">¡Bienvenido a <span class="text-green-600">EcoLink</span> ♻️</h1>
            <p class="text-lg mb-6">
                Cuidar el planeta empieza por nosotros. 
                Únete a nuestra misión de reducir, reutilizar y reciclar. 🌍  
                EcoLink te conecta con un sistema eficiente de gestión de residuos en Facatativá.
            </p>
            <div class="flex justify-center space-x-4">
                <a href="{{ route('login') }}" class="px-6 py-3 bg-green-600 text-white rounded-full shadow hover:bg-green-700 transition transform hover:-translate-y-1">
                    Iniciar Sesión
                </a>
                <a href="{{ route('register') }}" class="px-6 py-3 border border-green-600 text-green-700 rounded-full shadow hover:bg-green-100 transition transform hover:-translate-y-1">
                    Registrarse
                </a>
            </div>
        </div>
    </div>

    <!-- Animación simple -->
    <style>
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fade-in 0.8s ease-out;
        }
    </style>
</body>
</html>
