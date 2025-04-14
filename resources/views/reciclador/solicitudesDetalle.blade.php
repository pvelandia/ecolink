@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Detalles de la Solicitud #{{ $solicitud->id }}</h2>

    <p><strong>Materiales:</strong></p>
    <ul>
        @foreach($solicitud->materials as $material)
            <li>{{ $material->name }} - Cantidad: {{ $material->pivot->quantity }}</li>
        @endforeach
    </ul>
    <p><strong>Dirección:</strong> {{ $solicitud->address }}</p>
    <p><strong>Fecha de Solicitud:</strong> {{ $solicitud->assignment_date }}</p>

    <a href="{{ route('reciclador.solicitudes') }}" class="btn btn-secondary">Volver</a>
</div>
@endsection
