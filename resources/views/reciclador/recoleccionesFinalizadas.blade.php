@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="text-center mb-4 fw-bold">Recolecciones Finalizadas</h2>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    
    <form method="GET" action="{{ route('reciclador.recoleccionesFinalizadas') }}" class="mb-4">
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <label for="fecha" class="form-label">Fecha</label>
                <input type="date" name="fecha" id="fecha" class="form-control" value="{{ request('fecha') }}">
            </div>
            <div class="col-md-3">
                <label for="material" class="form-label">Material</label>
                <input type="text" name="material" id="material" class="form-control" placeholder="Ej. Plástico" value="{{ request('material') }}">
            </div>
            <div class="col-md-3">
                <label for="calificacion" class="form-label">Calificación</label>
                <select name="calificacion" id="calificacion" class="form-select">
                    <option value="">Todas</option>
                    @for ($i = 5; $i >= 1; $i--)
                        <option value="{{ $i }}" {{ request('calificacion') == $i ? 'selected' : '' }}>
                            {{ $i }} estrellas
                        </option>
                    @endfor
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary mt-auto">🔍 Filtrar</button>
                <a href="{{ route('reciclador.recoleccionesFinalizadas') }}" class="btn btn-outline-secondary mt-auto">❌ Limpiar</a>
            </div>
        </div>
    </form>

    @if($asignaciones->isEmpty())
        <p class="text-center mt-4">No hay recolecciones finalizadas que coincidan con tu búsqueda.</p>
    @else
        <div class="table-responsive rounded shadow" style="max-height: 600px; overflow-y: auto;">
            <table class="table table-hover table-bordered align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center">Fecha de Recolección</th>
                        <th class="text-center">Reciclador</th>
                        <th class="text-center">Materiales Recolectados</th>
                        <th class="text-center">Calificación</th>
                        <th class="text-center">Puntos</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($asignaciones as $recoleccion)
                    <tr>
                        <td class="text-center">{{ \Carbon\Carbon::parse($recoleccion->assignment_date)->format('d/m/Y H:i') }}</td>
                        <td class="text-center">{{ $recoleccion->reciclador->first_name }} {{ $recoleccion->reciclador->last_name }}</td>
                        <td class="text-center">
                            <ul class="list-unstyled mb-0">
                                @foreach($recoleccion->materials as $material)
                                    <li>{{ $material->name }} - {{ $material->pivot->quantity }} kg</li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="text-center">
                            @if($recoleccion->rating)
                                @for ($i = 1; $i <= 5; $i++)
                                    @if($i <= $recoleccion->rating)
                                        <span style="color: gold; font-size: 1.5rem;">★</span>
                                    @else
                                        <span style="color: lightgray; font-size: 1.5rem;">★</span>
                                    @endif
                                @endfor
                            @else
                                <span class="text-muted">No calificado</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($recoleccion->points)
                                {{ $recoleccion->points }}
                            @else
                                <div class="text-center">
                                    <form method="POST" action="{{ route('reciclador.asignarPuntos', $recoleccion->id ) }}">
                                        @csrf
                                        <input type="number" name="puntos" min="1" max="50" required class="form-control d-inline-block" style="width: auto; display: inline;">
                                        <button type="submit" class="btn btn-success btn-sm">Asignar</button>
                                    </form>
                                </div>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
    <div class="text-center mt-3">
        <a href="{{ route('reciclador.menu') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>
</div>
@endsection