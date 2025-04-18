@extends('layouts.app')

@section('content')
<head>
    <meta charset="UTF-8">
    <title>Solicitudes Pendientes</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Arial', sans-serif;
        }
        .card {
            border-radius: 1rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            padding: 20px;
        }
        .header-title {
            font-size: 2rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 30px;
        }
        .info-label {
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <h2 class="header-title text-center">Solicitudes Pendientes</h2>

        @if($solicitudes->isEmpty())
            <div class="alert alert-info text-center">
                No tienes solicitudes pendientes en este momento.
            </div>
        @else
            @foreach($solicitudes as $solicitud)
                <div class="card">
                    <h5 class="mb-3">Solicitud #{{ $solicitud->id }}</h5>
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
                    <form action="{{ route('hogar.eliminarSolicitud', $solicitud->id) }}" method="POST" onsubmit="return confirm('¿Seguro que quieres eliminar esta solicitud?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger mt-2">Eliminar Solicitud</button>
                    </form>
                </div>
            @endforeach
        @endif
        <div class="text-center">
                <a href="{{ route('solicitudes.create') }}" class="btn btn-secondary mt-3">¡Crea una nueva!</a>
        </div>
        <div class="text-center">
                <a href="{{ route('hogar.home') }}" class="btn btn-secondary mt-3">Volver</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
@endsection