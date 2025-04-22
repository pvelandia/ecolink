@extends('layouts.app')

@section('content')
<div class="container py-5">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <h2 class="text-center mb-4">Recolecciones Finalizadas</h2>

    <form method="GET" action="{{ route('admin.recoleccionesFinalizadasAdmin') }}" class="mb-4">
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
                <a href="{{ route('admin.recoleccionesFinalizadasAdmin') }}" class="btn btn-outline-secondary mt-auto">❌ Limpiar</a>
            </div>
        </div>
    </form>

    @if($asignaciones->isEmpty())
        <p class="text-center mt-4">No hay recolecciones finalizadas que coincidan con tu búsqueda.</p>
    @else
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Fecha de Recolección</th>
                    <th>Reciclador</th>
                    <th>Hogar</th>
                    <th>Materiales Recolectados</th>
                    <th>Calificación</th>
                    <th>Puntos</th>
                </tr>
            </thead>
            <tbody>
                @foreach($asignaciones as $recoleccion)
                <tr>
                    <td class="text-center">{{ \Carbon\Carbon::parse($recoleccion->assignment_date)->format('d/m/Y H:i') }}</td>
                    <td class="text-center">{{ $recoleccion->reciclador->first_name }} {{ $recoleccion->reciclador->last_name }}</td>
                    <td class="text-center">{{ $recoleccion->hogar->first_name }} {{ $recoleccion->hogar->last_name }}</td>
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
                                    ⭐
                                @endif
                            @endfor
                        @else
                            <em>No calificado</em>
                        @endif
                    </td>
                    <td class="text-center">{{ ($recoleccion->points ?? 0) > 0 ? $recoleccion->points : 'No asignados' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div class="text-center">
        <form method="POST" action="{{ route('admin.recoleccionesFinalizadasAdmin.pdf') }}">
            @csrf
            <input type="hidden" name="fecha" value="{{ request('fecha') }}">
            <input type="hidden" name="material" value="{{ request('material') }}">
            <input type="hidden" name="calificacion" value="{{ request('calificacion') }}">
            <button type="submit" class="btn btn-success mt-4">📄 Generar PDF</button>
        </form>
        <div class="text-center mt-3">
            <a href="{{ route('admin.menu') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Volver </a>
        </div>
    </div>
</div>
@endsection