@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Solicitudes Pendientes</h2>
    @if($solicitudes->isEmpty())
        <p>No hay solicitudes pendientes.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Material</th>
                    <th>Cantidad</th>
                    <th>Dirección</th>
                    <th>Fecha de Solicitud</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach($solicitudes as $solicitud)
                <tr>
                    <td>{{ $solicitud->id }}</td>
                    <td>
                        @foreach($solicitud->materials as $material)
                            {{ $material->name }} <br>
                        @endforeach
                    </td>
                    <td>
                        @foreach($solicitud->materials as $material)
                            {{ $material->pivot->quantity }} <br>
                        @endforeach
                    </td>
                    <td>{{ $solicitud->address }}</td>
                    <td>{{ $solicitud->assignment_date }}</td>
                    <td>
                        <a href="{{ route('reciclador.solicitudesDetalle', $solicitud->id) }}" class="btn btn-primary">Ver detalles</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    <a href="{{ route('reciclador.menu') }}" class="btn btn-secondary mt-3">Volver</a>
</div>
@endsection
