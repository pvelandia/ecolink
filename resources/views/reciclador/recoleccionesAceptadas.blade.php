@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="header-title text-center">Solicitudes Aceptadas en espera de Aprobacion</h2>
    @if($asignaciones->isEmpty())
        <div class="alert alert-info text-center">
            No tienes solicitudes aceptadas en este momento.
        </div>
    @else
        @foreach($asignaciones as $asignacion)
            <div class="card p-4">
                <div class="row">
                    <div class="col-md-8">
                        <h4><strong>Solicitud #{{ $asignacion->id }}</strong></h4>
                        <p><strong>Dirección:</strong> {{ $asignacion->hogar->address }}</p>
                        <p><strong>Estado:</strong> Aceptada</p>

                        <h5>Reciclador Asignado:</h5>
                        <p><strong>Nombre:</strong> {{ $asignacion->hogar->first_name }} {{ $asignacion->hogar->last_name }}</p>

                        <h5>Materiales Recolectados:</h5>
                        <ul>
                            @foreach($asignacion->materials as $material)
                                <li>{{ $material->name }} - Cantidad: {{ $material->pivot->quantity }}</li>
                            @endforeach
                        </ul>

                        <p><strong>Fecha de Recolección:</strong> {{ $asignacion->assignment_date }}</p>
                    </div>
                    <div class="col-md-4">
                        <form action="{{ route('reciclador.cancelar.solicitud', $asignacion->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-danger btn-lg">Cancelar Solicitud</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
    <a href="{{ route('reciclador.menu') }}" class="btn btn-secondary mt-3">Volver</a>
</div>
@endsection