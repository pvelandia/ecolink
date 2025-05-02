@extends('layouts.app')
@php
    use Carbon\Carbon;
@endphp
@section('content')
<head>
    <meta charset="UTF-8">
    <title>Recolecciones Aprobadas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #e6f5e5;
            font-family: 'Arial', sans-serif;
        }
        .card {
            border-radius: 1rem;
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
        .text-success {
            color: #28a745 !important;
        }
        .card-header {
            background-color: #28a745;
            color: white;
            padding: 10px;
            border-radius: 10px 10px 0 0;
        }
        .card-body {
            padding: 20px;
        }
        .btn-secondary {
            background-color: #6c757d;
            border: none;
        }
        .btn-secondary:hover {
            background-color: #007bff; /* Azul al hacer hover */
        }
        .te-esperamos {
            font-size: 1.25rem;
            font-weight: bold;
            color: #28a745;
            text-align: center;
            margin-top: 20px;
            transition: color 0.3s ease-in-out;
            margin-bottom: 10px; /* Reducir margen inferior */
        }
        .te-esperamos:hover {
            color: #007bff; /* Cambio de color a azul al hacer hover */
        }
        .solicitud-header {
            background-color: #000;
            color: white;
            padding: 10px;
            border-radius: 10px 10px 0 0;
        }
        .card-body {
            display: flex;
            flex-direction: column;
            justify-content: space-between; /* Asegura que el contenido se distribuya */
            min-height: 250px; /* Establecer un mínimo alto para que se vea equilibrado */
        }
    </style>
</head>

<div class="container py-5">
    <h2 class="header-title text-center">Recolecciones Aprobadas</h2>

    @if (session('success'))
        <div class="alert alert-success">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
        </div>
    @endif
    
    @if ($asignaciones->isEmpty())
        <div class="alert alert-info text-center">
            <i class="bi bi-exclamation-circle"></i> No tienes solicitudes aprobadas en este momento.
        </div>
    @else
        <div class="row">
            @foreach ($asignaciones as $asignacion)
                <div class="col-md-6">
                    <div class="card p-4">
                        <h4><strong>Solicitud #{{ $asignacion->id }}</strong></h4>
                        <div class="card-body">
                            <p><span class="info-label">Dirección:</span> {{ $asignacion->hogar->address ?? 'Ninguna' }}</p>
                            <p><span class="info-label">Estado:</span> Aprobada</p>
                            <p><span class="info-label">Solicitante (Hogar):</span> {{ $asignacion->hogar->first_name ?? 'N/A' }} {{ $asignacion->hogar->last_name ?? '' }}</p>
                            <h6><span class="info-label">Materiales a Recolectar:</span></h6>
                            <ul>
                                @foreach ($asignacion->materials as $material)
                                    <li>{{ $material->name }} - Cantidad: {{ $material->pivot->quantity }}</li>
                                @endforeach
                            </ul>

                            <p><span class="info-label">Fecha de Recolección:</span> {{ Carbon::parse($asignacion->assignment_date)->translatedFormat('d \d\e F \d\e Y \- h:i A') }} </p>
                            
                            <p class="te-esperamos">¡Te esperamos!</p>
                            @php
                                $horasRestantes = Carbon::parse($asignacion->assignment_date)->diffInHours(now(), false);
                            @endphp
                            @if ($horasRestantes < -3) 
                                <form action="{{ route('recolecciones.cancelarFinalR', $asignacion->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de cancelar esta recolección? Esta acción no se puede deshacer.');">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-lg w-100 mt-2">
                                        <i class="bi bi-x-circle"></i> Cancelar Recolección
                                    </button>
                                </form>
                            @endif
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
@endsection 