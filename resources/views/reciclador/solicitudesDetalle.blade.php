@extends('layouts.app')
@php
    use Carbon\Carbon;
@endphp
@section('content')
<head>
    <meta charset="UTF-8">
    <title>Detalle de Solicitud</title>
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
    </style>
</head>
<body>
<div class="container py-5">
    <h2 class="header-title text-center">Detalles de la Solicitud #{{ $solicitud->id }}</h2>

    <div class="card p-4">
        @if($solicitud->hogar)
            <p><span class="info-label">Solicitante:</span> {{ $solicitud->hogar->first_name }} {{ $solicitud->hogar->last_name }}</p>
        @else
            <p><span class="info-label">Solicitante:</span> No disponible</p>
        @endif
        <p><span class="info-label">Fecha de Solicitud:</span> {{ Carbon::parse($solicitud->assignment_date)->translatedFormat('d \d\e F \d\e Y \- h:i A') }}</p>
        <p><span class="info-label">Dirección:</span> {{ $solicitud->address }}</p>

        <p><span class="info-label">Materiales Solicitados:</span></p>
        <ul>
            @foreach($solicitud->materials as $material)
                <li>{{ $material->name }} - Cantidad: {{ $material->pivot->quantity }}</li>
            @endforeach
        </ul>

        <div class="d-flex flex-column flex-md-row gap-3 mt-4">
            <form action="{{ route('reciclador.solicitudes.aceptar', $solicitud->id) }}" method="POST"
                  onsubmit="return confirm('¿Estás seguro de aceptar esta solicitud?');">
                @csrf
                @method('PUT')
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-circle"></i> Aceptar Solicitud
                </button>
            </form>
            <a href="{{ route('reciclador.solicitudes') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Volver
            </a>
        </div>
    </div>
</div>
</body>
@endsection