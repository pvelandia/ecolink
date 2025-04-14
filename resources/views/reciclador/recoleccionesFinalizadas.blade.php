@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Recolecciones Finalizadas</h2>
    @if($recoleccionesFinalizadas->isEmpty())
        <p>No hay recolecciones finalizadas.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Material</th>
                    <th>Cantidad</th>
                    <th>Fecha de Finalización</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recoleccionesFinalizadas as $recoleccion)
                <tr>
                    <td>{{ $recoleccion->id }}</td>
                    <td>{{ $recoleccion->material->name }}</td>
                    <td>{{ $recoleccion->quantity }}</td>
                    <td>{{ $recoleccion->assignment_date }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
