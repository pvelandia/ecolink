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
        .star-rating i {
            font-size: 1.5rem;
            color: #ccc;
            cursor: pointer;
            transition: color 0.3s;
        }
        .star-rating i.hover,
        .star-rating i.selected {
            color: #ffc107;
        }
    </style>
</head>
<body>
<div class="container py-5">
    <h2 class="header-title text-center">Recolecciones Aprobadas</h2>

    @if (session('success'))
        <div class="alert alert-success">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if($recolecciones->isEmpty())
        <div class="alert alert-info text-center">
            <i class="bi bi-exclamation-circle"></i> No hay recolecciones aprobadas para calificar o finalizar.
        </div>
    @else
        @foreach($recolecciones->take(10) as $recoleccion)
            <div class="card p-4">
                <h4><strong>Recolección del {{ Carbon::parse($recoleccion->assignment_date)->translatedFormat('d \d\e F \d\e Y \- h:i A') }}</strong></h4>
                <p><span class="info-label">Reciclador:</span> {{ $recoleccion->reciclador->first_name }} {{ $recoleccion->reciclador->last_name }}</p>
                <p><span class="info-label">Teléfono:</span> {{ $recoleccion->reciclador->phone_number }}</p>
                <p><span class="info-label">Cédula:</span> {{ $recoleccion->reciclador->document }}</p>
                <h6><span class="info-label">Materiales Recolectados:</span></h6>
                <ul>
                    @foreach($recoleccion->materials as $material)
                        <li>{{ $material->name }} - Cantidad: {{ $material->pivot->quantity }}</li>
                    @endforeach
                </ul>

                <form action="{{ route('recolecciones.finalizar', $recoleccion->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="calificacion" class="info-label">Calificación:</label>
                        <div class="star-rating d-flex gap-2">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="bi bi-star" data-value="{{ $i }}"></i>
                            @endfor
                        </div>
                        <input type="hidden" name="calificacion" id="calificacion-input" required>
                        @if ($errors->has('calificacion'))
                            <div class="text-danger mt-2">{{ $errors->first('calificacion') }}</div>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-success btn-lg w-100">Finalizar y Calificar</button>
                </form>
                @php
                    $horasRestantes = Carbon::parse($recoleccion->assignment_date)->diffInHours(now(), false);
                @endphp
                @if ($horasRestantes < -3) 
                    <form action="{{ route('recolecciones.cancelarFinal', $recoleccion->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de cancelar esta recolección? Esta acción no se puede deshacer.');">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-lg w-100 mt-2">
                            <i class="bi bi-x-circle"></i> Cancelar Recolección
                        </button>
                    </form>
                @endif
            </div>
        @endforeach
    @endif

    <div class="text-center mt-3">
        <a href="{{ route('hogar.home') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>
</div>

<script>
    document.querySelectorAll('.star-rating').forEach(container => {
        const stars = container.querySelectorAll('i');
        const input = container.closest('form').querySelector('input[name="calificacion"]');

        stars.forEach(star => {
            star.addEventListener('mouseover', () => {
                const value = parseInt(star.getAttribute('data-value'));
                stars.forEach((s, i) => {
                    s.classList.toggle('hover', i < value);
                });
            });

            star.addEventListener('mouseout', () => {
                stars.forEach(s => s.classList.remove('hover'));
            });

            star.addEventListener('click', () => {
                const value = parseInt(star.getAttribute('data-value'));
                input.value = value;
                stars.forEach((s, i) => {
                    s.classList.toggle('selected', i < value);
                });
            });
        });
    });
</script>
</body>
@endsection