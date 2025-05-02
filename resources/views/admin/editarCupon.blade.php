@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #e6f5e5; /* Fondo general de la página */
    }
    .card {
        border-radius: 1rem;
        padding: 2rem; /* Ajustar el padding según sea necesario */
        width: 100%; /* Asegurarse de que la tarjeta ocupe el ancho completo */
        max-width: 600px; /* Limitar el ancho máximo para hacerlo más grande */
        margin: auto; /* Centrar la tarjeta horizontalmente */
    }
    .form-control {
        background-color: #ffffff; /* Fondo blanco solo para los campos de entrada */
    }
    .img-preview {
        max-width: 100%;
        max-height: 200px;
        object-fit: cover;
        margin-top: 10px;
    }
    .form-group {
        margin-bottom: 1rem;
    }
    .input-group {
        max-width: 300px;
    }
</style>

<div class="container py-5">
    <div class="card shadow">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
        <h3 class="text-center mb-4 text-success"><i class="bi bi-gift"></i> Editar Cupón</h3>
        <div class="card-body">
            <form action="{{ route('admin.actualizarCupon', $cupon->id) }}" method="POST" class="d-flex flex-column align-items-center" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3 w-100">
                    <label class="form-label"><i class="bi bi-building"></i> Empresa</label>
                    <input type="text" name="company" class="form-control" value="{{ $cupon->company }}" required>
                </div>

                <div class="mb-3 w-100">
                    <label class="form-label"><i class="bi bi-house-door"></i> Dirección</label>
                    <input type="text" name="address" class="form-control" value="{{ $cupon->address }}" required>
                </div>

                <div class="mb-3 w-100">
                    <label class="form-label"><i class="bi bi-telephone"></i> Teléfono</label>
                    <input type="text" name="phone" class="form-control" value="{{ $cupon->phone }}" required>
                </div>

                <div class="mb-3 w-100">
                    <label class="form-label"><i class="bi bi-pencil"></i> Descripción</label>
                    <textarea name="description" class="form-control" required>{{ $cupon->description }}</textarea>
                </div>

                <!-- Contenedor de las columnas para el descuento y puntos -->
                <div class="row mb-3 w-100">
                    <!-- Columna para el descuento -->
                    <div class="col-md-6">
                        <label class="form-label"><i class="bi bi-percent"></i> Descuento (%)</label>
                        <input type="number" name="discount" class="form-control" value="{{ rtrim(rtrim(number_format($cupon->discount, 2, '.', ''), '0'), '.') }}" required>
                    </div>
                    
                    <!-- Columna para los puntos requeridos -->
                    <div class="col-md-6">
                        <label class="form-label"><i class="bi bi-star"></i> Puntos requeridos</label>
                        <input type="number" name="points" class="form-control" value="{{ $cupon->points }}" required>
                    </div>
                </div>

                <div class="mb-3 w-100">
                    <label class="form-label"><i class="bi bi-box"></i> Ajustar stock</label>
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

                <div class="mb-3 w-100">
                    <label class="form-label"><i class="bi bi-image"></i> Imagen del cupón</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                    
                    @if($cupon->image)
                        <img src="{{ asset('storage/cupones/' . $cupon->image) }}" alt="Imagen actual del cupón" class="img-preview mt-2">
                    @else
                        <small class="text-muted">No hay imagen cargada actualmente.</small>
                    @endif
                </div>

                <div class="d-flex justify-content-between w-100">
                    <button type="submit" class="btn btn-success w-100 me-2"><i class="bi bi-check-circle"></i> Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>

    <div class="text-center mt-3">
        <a href="{{ route('admin.bonificaciones') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Cancelar</a>
    </div>
</div>

<script>
    function ajustarStock(cambio) {
        let input = document.getElementById('ajuste_stock');
        let valor = parseInt(input.value) || 0;
        input.value = valor + cambio;
    }
</script>
@endsection