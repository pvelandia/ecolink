@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Detalles de la Solicitud #{{ $solicitud->id }}</h2>

    <div class="card p-4 shadow-sm">
        @if($solicitud->hogar)
            <p><strong>Solicitante:</strong> {{ $solicitud->hogar->first_name }} {{ $solicitud->hogar->last_name }}</p>

            @if($solicitud->hogar->average)
                <p><strong>Calificación:</strong>
                    @for ($i = 1; $i <= 5; $i++)
                        @if($i <= $solicitud->hogar->average)
                            ⭐
                        @else
                            ☆
                        @endif
                    @endfor
                    ({{ $solicitud->hogar->average }} / 5)
                </p>
            @else
                <p><strong>Calificación:</strong> No calificado aún</p>
            @endif
        @else
            <p><strong>Solicitante:</strong> No disponible</p>
            <p><strong>Calificación:</strong> No calificado aún</p>
        @endif

        <p><strong>Dirección:</strong> {{ $solicitud->address }}</p>

        <p><strong>Materiales solicitados:</strong></p>
        <ul>
            @foreach($solicitud->materials as $material)
                <li>{{ $material->name }} - Cantidad: {{ $material->pivot->quantity }}</li>
            @endforeach
        </ul>

        <div class="d-flex gap-2 mt-4">
            <form action="{{ route('reciclador.solicitudes.aceptar', $solicitud->id) }}" method="POST">
                @csrf
                @method('PUT')
                <button type="submit" class="btn btn-success">Aceptar Solicitud</button>
            </form>

           

            <a href="{{ route('reciclador.solicitudes') }}" class="btn btn-secondary">Volver</a>
        </div>
    </div>
</div>
@endsection
