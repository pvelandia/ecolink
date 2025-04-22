@extends('layouts.app')

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenido a EcoLink</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-green-50 text-gray-800">
    <div class="min-h-screen flex flex-col items-center justify-center text-center px-6">
        <h1 class="text-4xl font-bold text-red-700 mb-4">¡Bienvenido a EcoLink! ♻️</h1>
        <p class="text-lg mb-6 max-w-2xl">
            Tu cuenta ha sido suspendida por un administrador. Por favor, comunícate con nosotros para reactivarla.
        </p>

        <div class="space-y-4">
            <a href="tel:+573222889715" class="block px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-green-700 transition no-underline">
                📞 +57 322 2889715
            </a>
            <a href="mailto:ecolink.reciclaje.25@gmail.com" class="block px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition no-underline">
                📧 ecolink.reciclaje.25@gmail.com
            </a>
        </div>

        <div class="mt-10 text-sm text-gray-600 italic">
            Universidad de Cundinamarca - Extensión Facatativá
        </div>
    </div>
</body>
</html>