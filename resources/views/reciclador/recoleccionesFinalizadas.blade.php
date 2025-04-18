@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="header-title text-center">Recolecciones Finalizadas</h2>

    @if($asignaciones->isEmpty())
        <div class="alert alert-info text-center">
            No tienes solicitudes finalizadas en este momento.
        </div>
    @else
        @foreach($asignaciones as $asignacion)
            <div class="card p-4 mb-4">
                <div class="row">
                    <div class="col-md-8">
                        <h4><strong>Solicitud #{{ $asignacion->id }}</strong></h4>
                        <p><strong>Dirección:</strong> {{ $asignacion->hogar->address ?? 'Ninguna' }}</p>
                        <p><strong>Estado:</strong> Finalizada</p>

                        <h5>Solicitante (Hogar):</h5>
                        <p><strong>Nombre:</strong> {{ $asignacion->hogar->first_name ?? 'N/A' }} {{ $asignacion->hogar->last_name ?? '' }}</p>

                        {{-- Calificación --}}
                        @if($asignacion->rating)
                            <p><strong>Calificación:</strong>
                                @for ($i = 1; $i <= 5; $i++)
                                    @if($i <= $asignacion->rating)
                                        ⭐
                                    @else
                                        ☆
                                    @endif
                                @endfor
                            </p>
                        @else
                            <p><strong>Calificación:</strong> No calificado aún</p>
                        @endif


                        <h5>Materiales Recolectados:</h5>
                        <ul>
                            @foreach($asignacion->materials as $material)
                                <li>{{ $material->name }} - Cantidad: {{ $material->pivot->quantity }}</li>
                            @endforeach
                        </ul>

                        <p><strong>Fecha de Recolección:</strong> {{ $asignacion->assignment_date }}</p>
                    </div>

                    <div class="col-md-4">
                        @if($asignacion->points > 0)
                            <p><strong>Puntos obtenidos:</strong> {{ $asignacion->points }}</p>
                        @else
                            <form action="{{ route('reciclador.asignarPuntos', $asignacion->id) }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="puntos">¿Cuantos puntos quieres dar? (máx. 50):</label>
                                    <input type="number" name="puntos" class="form-control" min="0" max="50" required>
                                </div>
                                <button type="submit" class="btn btn-success mt-2">Guardar</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    @endif

    <a href="{{ route('reciclador.menu') }}" class="btn btn-secondary mt-3">Volver</a>
</div>
@endsection