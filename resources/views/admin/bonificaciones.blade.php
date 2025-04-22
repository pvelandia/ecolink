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
        background-color: #343a40; /* Color de fondo negro para la fila de encabezado */
        color: white; /* Color de texto blanco */
    }
</style>

<div class="container py-5">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <h2 class="text-center mb-4">Gestión de Bonificaciones</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($cupones->count())
        <h4>Cupones Existentes</h4>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Empresa</th>
                        <th>Descripción</th>
                        <th>Descuento</th>
                        <th>Stock</th>
                        <th>Puntos</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cupones as $cupon)
                        <tr>
                            <td>{{ $cupon->company }}</td>
                            <td>{{ $cupon->description }}</td>
                            <td>{{ rtrim(rtrim(number_format($cupon->discount, 2, '.', ''), '0'), '.') }}%</td>
                            <td>{{ $cupon->stock }}</td>
                            <td>{{ $cupon->points }}</td>
                            <td>
                                <a href="{{ route('admin.editarCupon', $cupon->id) }}" class="btn btn-sm btn-primary">Editar</a>
                                
                                <form action="{{ route('admin.eliminarCupon', $cupon->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este cupón?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info text-center">No hay cupones existentes.</div>
    @endif

    <div class="card shadow mt-5 p-4 mx-auto" style="max-width: 600px;">
        <h4>Crear Cupón</h4>
        <form action="{{ route('admin.cupones.guardar') }}" method="POST" class="mb-3"> @csrf

            <div class="mb-3">
                <label class="form-label">Empresa</label>
                <input type="text" name="company" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Descripción</label>
                <textarea name="description" class="form-control" required></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Descuento (%)</label>
                <input type="number" name="discount" class="form-control" step="0.01" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Stock</label>
                <input type="number" name="stock" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Puntos necesarios</label>
                <input type="number" name="points" class="form-control" required>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Guardar Cupón</button>
            </div>
        </form>
    </div>
    <div class="text-center mt-3">
        <a href="{{ route('admin.menu') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver </a>
    </div>
</div>
@endsection