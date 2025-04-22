@extends('layouts.app')

@section('content')
@php
    use Carbon\Carbon;
@endphp

<div class="container py-5">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <h2 class="text-center mb-4 fw-bold">Recolecciones Finalizadas</h2>

    @if($recolecciones->isEmpty())
        <div class="alert alert-info text-center shadow rounded-3">
            <i class="bi bi-info-circle"></i> No hay recolecciones finalizadas.
        </div>
    @else
        <div class="table-responsive rounded shadow" style="max-height: 600px; overflow-y: auto;">
            <table class="table table-hover table-bordered align-middle text-center">
                <thead class="table-success sticky-top">
                    <tr>
                        <th>Fecha de Recolección</th>
                        <th>Reciclador</th>
                        <th>Materiales</th>
                        <th>Calificación</th>
                        <th>Puntos</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recolecciones->take(20) as $recoleccion)
                    <tr>
                        <td class="text-nowrap">
                            {{ Carbon::parse($recoleccion->assignment_date)->translatedFormat('d \d\e F \d\e Y - h:i A') }}
                        </td>
                        <td>
                            {{ $recoleccion->reciclador->first_name }} {{ $recoleccion->reciclador->last_name }}
                        </td>
                        <td class="text-center">
                            <ul class="list-unstyled mb-0">
                                @foreach($recoleccion->materials as $material)
                                    <li> {{ $material->name }} {{ $material->pivot->quantity }} kg</li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="text-center">
                            @if($recoleccion->rating)
                                @for ($i = 1; $i <= 5; $i++)
                                    @if($i <= $recoleccion->rating)
                                        <span style="color: gold;">★</span>
                                    @endif
                                @endfor
                            @else
                                <span class="text-muted">No calificado</span>
                            @endif
                        </td>
                        <td class="text-center">
                            {{ ($recoleccion->points ?? 0) > 0 ? $recoleccion->points : 'No asignados' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <div class="text-center mt-3">
        <a href="{{ route('hogar.home') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>
</div>
@endsection