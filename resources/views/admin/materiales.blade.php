@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #e6f5e5;
    }
    .card {
        border-radius: 1rem;
    }
    .table-dark th {
        background-color: #343a40;
        color: white;
    }
</style>

<div class="container py-5">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <h2 class="text-center mb-4">Materiales</h2>

    @if(session('success'))
        <div class="alert alert-success">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">
            <i class="bi bi-x-circle"></i> {{ session('error') }}
        </div>
    @endif

    @if($materials->count())
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                    <th class="text-center">Nombre</th>
                    <th class="text-center">Descripción</th>
                    <th class="text-center">Puntos por Kg</th>
                    <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($materials as $material)
                        <tr>
                            <td class="text-center">{{ $material->name }}</td>
                            <td class="text-center">{{ empty($material->description) ? 'No asignada' : $material->description }}</td>
                            <td class="text-center">
                                @if ($material->points_kilo == 0)
                                    No asignados
                                @else
                                    {{ $material->points_kilo }}
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.editarMaterial', $material->id) }}" class="btn btn-sm btn-primary">Editar</a>
                                
                                <form action="{{ route('admin.eliminarMaterial', $material->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este material?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info text-center">
            <i class="bi bi-exclamation-circle"></i> No hay materiales existentes..
        </div>
    @endif

    <div class="text-center mb-4">
        <a href="{{ route('admin.crearMaterial') }}" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Crear Nuevo Material
        </a>
    </div>

    <div class="text-center mt-3">
        <a href="{{ route('admin.menu') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>
</div>
@endsection