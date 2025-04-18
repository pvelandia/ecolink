@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Editar Cupón</h2>
    <form action="{{ route('admin.actualizarCupon', $cupon->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Empresa</label>
            <input type="text" name="company" class="form-control" value="{{ $cupon->company }}" required>
        </div>

        <div class="mb-3">
            <label>Descripción</label>
            <textarea name="description" class="form-control" required>{{ $cupon->description }}</textarea>
        </div>

        <div class="mb-3">
            <label>Descuento (%)</label>
            <input type="number" name="discount" class="form-control" value="{{ rtrim(rtrim(number_format($cupon->discount, 2, '.', ''), '0'), '.') }}" required>
        </div>

        <div class="mb-3">
            <label>Puntos requeridos</label>
            <input type="number" name="points" class="form-control" value="{{ $cupon->points }}" required>
        </div>

        <div class="mb-3">
            <label>Ajustar stock</label>
            <div class="input-group" style="max-width: 300px;">
                <button type="button" class="btn btn-outline-danger" onclick="ajustarStock(-1)">-</button>
                <input type="number" name="ajuste_stock" id="ajuste_stock" class="form-control text-center" value="0">
                <button type="button" class="btn btn-outline-success" onclick="ajustarStock(1)">+</button>
            </div>
            <small class="form-text text-muted">
                Stock actual: <strong>{{ $cupon->stock }}</strong> |
                Stock inicial: <strong>{{ $cupon->stock_inicial }}</strong>
            </small>
        </div>

        <button type="submit" class="btn btn-success">Guardar cambios</button>
        <a href="{{ route('admin.bonificaciones') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection

<script>
    function ajustarStock(cambio) {
        let input = document.getElementById('ajuste_stock');
        let valor = parseInt(input.value) || 0;
        input.value = valor + cambio;
    }
</script>
