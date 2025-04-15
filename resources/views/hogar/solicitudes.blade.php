@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Solicitudes Aceptadas</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Arial', sans-serif;
        }
        .card {
            border-radius: 1rem;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        .btn-lg {
            font-size: 1.2rem;
            padding: 1rem 2rem;
        }
        .header-title {
            color: #343a40;
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 30px;
        }
        .btn-container {
            display: flex;
            justify-content: space-between;
        }
        .btn-container form {
            margin-bottom: 0;
        }
    </style>
</head>
<body>

    <div class="container py-5">
        <h2 class="header-title text-center">Solicitudes Aceptadas</h2>

        <a href="{{ route('hogar.solicitudes') }}" class="btn btn-info btn-lg text-white mb-4">Volver a Mis Solicitudes</a>

        @if($solicitudes->isEmpty())
            <div class="alert alert-info text-center">
                No tienes solicitudes aceptadas en este momento.
            </div>
        @else
            @foreach($solicitudes as $solicitud)
                <div class="card p-4">
                    <div class="row">
                        <div class="col-md-8">
                            <h4><strong>Solicitud #{{ $solicitud->id }}</strong></h4>
                            <p><strong>Dirección:</strong> {{ $solicitud->address }}</p>
                            <p><strong>Estado:</strong> Aceptada</p>

                            <h5>Reciclador Asignado:</h5>
                            <p><strong>Nombre:</strong> {{ $solicitud->reciclador->first_name }} {{ $solicitud->reciclador->last_name }}</p>
                            <p><strong>Calificación:</strong>
                                @for ($i = 1; $i <= 5; $i++)
                                    @if($i <= $solicitud->reciclador->average)
                                        ⭐
                                    @else
                                        ☆
                                    @endif
                                @endfor
                                ({{ $solicitud->reciclador->average }} / 5)
                            </p>

                            <h5>Materiales Recolectados:</h5>
                            <ul>
                                @foreach($solicitud->materials as $material)
                                    <li>{{ $material->name }} - Cantidad: {{ $material->pivot->quantity }}</li>
                                @endforeach
                            </ul>
                            
                            <p><strong>Fecha de Recolección:</strong> {{ $solicitud->assignment_date }}</p>
                        </div>

                        <div class="col-md-4">
                            <div class="btn-container">
                                <form action="{{ route('hogar.solicitudes.aprobar', $solicitud->id) }}" method="POST" style="width: 48%;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-success btn-lg w-100">Aprobar</button>
                                </form>

                                <form action="{{ route('hogar.solicitudes.rechazar', $solicitud->id) }}" method="POST" style="width: 48%;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-danger btn-lg w-100">Rechazar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <!-- Bootstrap JS & Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

</body>
</html>
@endsection
