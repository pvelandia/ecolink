@extends('layouts.app')
@php
    use Carbon\Carbon;
@endphp
@section('content')
<head>
    <meta charset="UTF-8">
    <title>Solicitudes Aceptadas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #e6f5e5; /* Color de fondo consistente */
            font-family: 'Arial', sans-serif;
        }
        .card {
            border-radius: 1rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2); /* Sombra más pronunciada para efecto 3D */
            margin-bottom: 30px;
            transition: transform 0.2s; /* Transición suave para el efecto hover */
        }
        .card:hover {
            transform: translateY(-5px); /* Efecto de elevación al pasar el mouse */
        }
        .header-title {
            color: #28a745; /* Color verde para el título */
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 30px;
        }
        .btn-lg {
            font-size: 1.2rem;
            padding: 1rem 2rem;
        }
        .btn-container {
            display: flex;
            justify-content: center; /* Centrar los botones */
            gap: 10px; /* Espacio entre los botones */
        }
        .info-label {
            font-weight: 600;
            color: #28a745; /* Color verde para las etiquetas de información */
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
        <h2 class="header-title text-center">Solicitudes "Aceptadas" en espera de que las apruebes</h2>
        @if($solicitudes->isEmpty())
            <div class="alert alert-info text-center">
                <i class="bi bi-exclamation-circle"></i> No tienes solicitudes "Aceptadas" en este momento.
            </div>
        @else
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="list-unstyled mb-0">
                    @foreach ($errors->all() as $error)
                        <li><i class="bi bi-exclamation-circle"></i> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                <i class="bi bi-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                <i class="bi bi-x-circle"></i> {{ session('error') }}
            </div>
        @endif

            <div class="row">
                @foreach($solicitudes->take(20) as $solicitud)
                    <div class="col-md-6">
                        <div class="card p-4">
                            <h4><strong>Solicitud #{{ $solicitud->id }}</strong></h4>
                            <p><span class="info-label">Dirección:</span> {{ $solicitud->address }}</p>
                            <p><span class="info-label">Estado:</span> Aceptada</p>
                            <p><span class="info-label">Reciclador Asignado:</span> {{ $solicitud->reciclador->first_name }} {{ $solicitud->reciclador->last_name }}</p>
                            <h6><span class="info-label">Material por recoger:</span></h6>
                            <ul>
                                @foreach($solicitud->materials as $material)
                                    <li>{{ $material->name }} - Cantidad: {{ $material->pivot->quantity }}</li>
                                @endforeach
                            </ul>
                            
                            <p><span class="info-label">Fecha de Recolección:</span> {{ Carbon::parse($solicitud->assignment_date)->translatedFormat('d \d\e F \d\e Y \- h:i A') }}</p>
                            <div class="btn-container">
                            <form 
                                action="{{ route('hogar.solicitudes.aprobar', $solicitud->id) }}" 
                                method="POST" 
                                onsubmit="return confirm('¿Estás seguro de que quieres aprobar esta solicitud?');">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-success btn-lg w-100">Aprobar</button>
                            </form>

                            <form 
                                action="{{ route('hogar.solicitudes.rechazar', $solicitud->id) }}" 
                                method="POST" 
                                onsubmit="return confirm('¿Estás seguro de que quieres rechazar esta solicitud?');">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-danger btn-lg w-100">Rechazar</button>
                            </form>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
        <div class="text-center mt-3">
            <a href="{{ route('hogar.home') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Volver </a>
        </div>
    </div>
    <!-- Bootstrap JS & Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/ umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

</body>
@endsection