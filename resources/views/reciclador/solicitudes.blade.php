@extends('layouts.app')

@php
    use Carbon\Carbon;
@endphp

@section('content')
<head>
    <meta charset="UTF-8">
    <title>Solicitudes Pendientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #e6f5e5;
            font-family: 'Arial', sans-serif;
        }
        .card {
            border-radius: 1rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            margin-bottom: 30px;
            padding: 20px;
            transition: transform 0.2s;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .header-title {
            color: #28a745;
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 30px;
        }
        .info-label {
            font-weight: 600;
            color: #28a745;
        }
    </style>
</head>
<body>
<div class="container py-5">
    <h2 class="header-title text-center">Solicitudes Pendientes</h2>

    @if($solicitudes->isEmpty())
        <div class="alert alert-info text-center">
            <i class="bi bi-exclamation-circle"></i> No tienes solicitudes pendientes en este momento.
        </div>
    @else
        <div class="row">
            @foreach($solicitudes as $solicitud)
                <div class="col-md-6 col-lg-4">
                    <div class="card">
                        <h4><strong>Solicitud #{{ $solicitud->id }}</strong></h4>
                        <p><span class="info-label">Dirección:</span> {{ $solicitud->address ?? 'Ninguna' }}</p>
                        <p><span class="info-label">Fecha de Solicitud:</span> {{ Carbon::parse($solicitud->assignment_date)->translatedFormat('d \d\e F \d\e Y \- h:i A') }}</p>
                        <h6><span class="info-label">Materiales:</span></h6>
                        <ul>
                            @foreach($solicitud->materials as $material)
                                <li>{{ $material->name }} - Cantidad: {{ $material->pivot->quantity }}</li>
                            @endforeach
                        </ul>

                        <div class="text-center mt-3">
                            <a href="{{ route('reciclador.solicitudesDetalle', $solicitud->id) }}" class="btn btn-primary w-100">
                                <i class="bi bi-eye"></i> Ver detalles
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <div class="text-center mt-4">
        <a href="{{ route('reciclador.menu') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>
</div>
</body>
@endsection