@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Recolecciones Pendientes</h2>
    @if($recoleccionesPendientes->isEmpty())
        <p>No hay recolecciones pendientes.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Material</th>
                    <th>Cantidad</th>
                    <th>Fecha de Recolección</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recoleccionesPendientes as $recoleccion)
                <tr>
                    <td>{{ $recoleccion->id }}</td>
                    <td>{{ $recoleccion->material->name }}</td>
                    <td>{{ $recoleccion->quantity }}</td>
                    <td>{{ $recoleccion->assignment_date }}</td>
                    <td><a href="{{ route('reciclador.recoleccionesFinalizadas') }}" class="btn btn-success">Marcar como finalizada</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
