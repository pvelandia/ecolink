<!-- resources/views/hogar/recoleccionesFinalizadas.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="text-center">Recolecciones Finalizadas</h2>

    @if($recolecciones->isEmpty())
        <p>No hay recolecciones finalizadas.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Fecha de Recolección</th>
                    <th>Reciclador</th>
                    <th>Materiales Recolectados</th>
                    <th>Calificación</th>
                    <th>Puntos</th> <!-- Nueva columna para los puntos -->
                </tr>
            </thead>
            <tbody>
                @foreach($recolecciones as $recoleccion)
                <tr>
                    <td>{{ $recoleccion->assignment_date }}</td>
                    <td>{{ $recoleccion->reciclador->first_name }} {{ $recoleccion->reciclador->last_name }}</td>
                    <td>
                        <ul>
                            @foreach($recoleccion->materials as $material)
                                <li>{{ $material->name }} - Cantidad: {{ $material->pivot->quantity }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>{{ $recoleccion->rating ?? 'No Calificado' }}</td>
                    <td>{{ $recoleccion->points ?? 'No Asignados' }}</td> <!-- Mostrar los puntos -->
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    <a href="{{ route('hogar.home') }}" class="btn btn-secondary mt-3">Volver</a>
</div>
@endsection
