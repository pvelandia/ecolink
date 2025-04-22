@extends('layouts.app')

@section('content')
<head>
    <meta charset="UTF-8">
    <title>Solicitudes Pendientes</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #e6f5e5; /* Color de fondo consistente */
            font-family: 'Arial', sans-serif;
        }
        .card {
            border-radius: 1rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2); /* Sombra más pronunciada para efecto 3D */
            margin-bottom: 20px;
            padding: 20px;
            transition: transform 0.2s; /* Transición suave para el efecto hover */
        }
        .card:hover {
            transform: translateY(-5px); /* Efecto de elevación al pasar el mouse */
        }
        .header-title {
            font-size: 2rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 30px;
        }
        .info-label {
            font-weight: 600;
            color: #28a745; /* Color verde para las etiquetas de información */
        }
        .btn-custom {
            background-color: #28a745; /* Color personalizado para los botones */
            color: white;
        }
        .btn-custom:hover {
            background-color: #218838; /* Color al pasar el mouse */
        }
        .text-green {
            color: #28a745; /* Color verde para el texto */
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <h2 class="header-title text-center text-green">Solicitudes en espera de aceptacion de un reciclador.</h2>

        @if($solicitudes->isEmpty())
            <div class="alert alert-info text-center">
                No tienes solicitudes pendientes en este momento.
            </div>
        @else
            <div class="row">
                @foreach($solicitudes->take(30) as $solicitud)
                    <div class="col-md-4">
                        <div class="card">
                            <h4><strong>Solicitud #{{ $solicitud->id }}</strong></h4>
                            <p><span class="info-label">Dirección:</span> {{ $solicitud->address ?? 'Ninguna' }}</p>
                            <p><span class="info-label">Fecha de Solicitud:</span> {{ \Carbon\Carbon::parse($solicitud->created_at)->format('d/m/Y') }}</p>
                            <p><span class="info-label">Estado:</span> Pendiente</p>
                            <p><span class="info-label">Materiales:</span></p>
                            <ul>
                                @foreach($solicitud->materials as $material)
                                    <li>{{ $material->name }} (Cantidad: {{ $material->pivot->quantity }})</li>
                                @endforeach
                            </ul>

                            {{-- Botón de eliminar --}}
                            <div class="text-center"> <!-- Contenedor para centrar el botón -->
                                <form action="{{ route('hogar.eliminarSolicitud', $solicitud->id) }}" method="POST" onsubmit="return confirm('¿Seguro que quieres eliminar esta solicitud?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger mt-2">Eliminar Solicitud</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
        <div class="text-center">
            <a href="{{ route('solicitudes.create') }}" class="btn btn-custom mt-3">¡Crea una nueva!</a>
        </div>
        <div class="text-center mt-3">
            <a href="{{ route('hogar.home') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Volver
            </a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
@endsection