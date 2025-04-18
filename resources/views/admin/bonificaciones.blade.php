@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Gestión de Bonificaciones</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <h4>Crear Cupón</h4>
    <form action="{{ route('admin.cupones.guardar') }}" method="POST" class="mb-5">
        @csrf

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

        <button type="submit" class="btn btn-primary">Guardar Cupón</button>
    </form>

    @if($cupones->count())
        <h4>Cupones Existentes</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Empresa</th>
                    <th>Descripción</th>
                    <th>Descuento</th>
                    <th>Stock</th>
                    <th>Puntos</th>
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
    @endif
    <a href="{{ route('admin.menu') }}" class="btn btn-secondary mt-3">Volver</a>
</div>
@endsection