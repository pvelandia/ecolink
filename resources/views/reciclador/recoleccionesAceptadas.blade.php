@extends('layouts.app')
@php
    use Carbon\Carbon;
@endphp
@section('content')
<head>
    <meta charset="UTF-8">
    <title>Solicitudes Aceptadas</title>
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
        .col-md-6 {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
<div class="container py-5">
    <h2 class="header-title text-center">Solicitudes Aceptadas en Espera de Aprobación</h2>

    @if ($asignaciones->isEmpty())
        <div class="alert alert-info text-center">
            <i class="bi bi-exclamation-circle"></i> No tienes solicitudes aceptadas en este momento.
        </div>
    @else
        <div class="row">
            @foreach ($asignaciones as $asignacion)
                <div class="col-md-6">
                    <div class="card p-4">
                        <h4><strong>Solicitud #{{ $asignacion->id }}</strong></h4>
                        <p><span class="info-label">Dirección:</span> {{ $asignacion->hogar->address ?? 'Ninguna' }}</p>
                        <p><span class="info-label">Estado:</span> Aceptada</p>
                        <p><span class="info-label">Solicitante (Hogar):</span> {{ $asignacion->hogar->first_name }} {{ $asignacion->hogar->last_name }}</p>

                        <h6><span class="info-label">Materiales a Recolectar:</span></h6>
                        <ul>
                            @foreach ($asignacion->materials as $material)
                                <li>{{ $material->name }} - Cantidad: {{ $material->pivot->quantity }}</li>
                            @endforeach
                        </ul>

                        <p><span class="info-label">Fecha de Solicitud:</span> 
                            {{ Carbon::parse($asignacion->assignment_date)->translatedFormat('d \d\e F \d\e Y \- h:i A') }}
                        </p>

                        <div class="text-center mt-3">
                            <form action="{{ route('reciclador.cancelar.solicitud', $asignacion->id) }}" method="POST"
                                  onsubmit="return confirm('¿Estás seguro de cancelar esta solicitud?');">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-danger">
                                    <i class="bi bi-x-circle"></i> Cancelar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <div class="text-center mt-3">
        <a href="{{ route('reciclador.menu') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>
</div>
</body>
@endsection