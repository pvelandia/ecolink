@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="header-title text-center">Recolecciones Aprobadas</h2>

    @if($asignaciones->isEmpty())
        <div class="alert alert-info text-center">
            No tienes solicitudes aprobadas en este momento.
        </div>
    @else
        @foreach($asignaciones as $asignacion)
            <div class="card p-4 mb-3">
                <div class="row">
                    <div class="col-md-8">
                        <h4><strong>Solicitud #{{ $asignacion->id }}</strong></h4>
                        <p><strong>Dirección:</strong> {{ $asignacion->hogar->address ?? 'Ninguna' }}</p>
                        <p><strong>Estado:</strong> Aprobada</p>

                        <h5>Solicitante (Hogar):</h5>
                        <p><strong>Nombre:</strong> {{ $asignacion->hogar->first_name ?? 'N/A' }} {{ $asignacion->hogar->last_name ?? '' }}</p>

                        <h5>Materiales a recolectar:</h5>
                        <ul>
                            @foreach($asignacion->materials as $material)
                                <li>{{ $material->name }} - Cantidad: {{ $material->pivot->quantity }}</li>
                            @endforeach
                        </ul>

                        <p><strong>Fecha de Recolección:</strong> {{ $asignacion->assignment_date }}</p>
                    </div>
                    <div class="col-md-4">
                        <p class="text-success mt-5"><strong>¡Te esperamos!</strong></p>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

    <a href="{{ route('reciclador.menu') }}" class="btn btn-secondary mt-3">Volver</a>
</div>
@endsection
