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
        max-width: 400px; /* Limitar el ancho máximo */
        margin: auto; /* Centrar la tarjeta horizontalmente */
    }
    .form-control {
        background-color: #ffffff; /* Fondo blanco solo para los campos de entrada */
    }
</style>

<div class="container py-5">
    <div class="card shadow">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
        <h3 class="text-center mb-4 text-success"><i class="bi bi-gift"></i> Crear Nuevo Cupón</h3>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="list-unstyled mb-0">
                    @foreach ($errors->all() as $error)
                        <li><i class="bi bi-exclamation-circle"></i> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                <i class="bi bi-x-circle"></i> {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.cupones.guardar') }}" enctype="multipart/form-data" class="d-flex flex-column align-items-center">
            @csrf

            <div class="mb-3 w-100">
                <label class="form-label"><i class="bi bi-building"></i>Empresa</label>
                <input type="text" name="company" class="form-control" required>
            </div>

            <div class="mb-3 w-100">
                <label class="form-label"><i class="bi bi-building"></i>Dirección</label>
                <input type="text" name="address" class="form-control" required>
            </div>

            <div class="mb-3 w-100">
                <label class="form-label"><i class="bi bi-building"></i>Telefono</label>
                <input type="text" name="phone" class="form-control" required>
            </div>

            <div class="mb-3 w-100">
                <label class="form-label"><i class="bi bi-building"></i>Logo / Imagen</label>
                <input type="file" name="image" class="form-control">
            </div>

            <div class="mb-3 w-100">
                <label class="form-label"><i class="bi bi-pencil"></i> Descripción</label>
                <textarea name="description" class="form-control" required></textarea>
            </div>

            <div class="mb-3 w-100">
                <label class="form-label"><i class="bi bi-percent"></i> Descuento (%)</label>
                <input type="number" name="discount" class="form-control" step="0.01" required>
            </div>

            <div class="mb-3 w-100">
                <label class="form-label"><i class="bi bi-box"></i> Stock</label>
                <input type="number" name="stock" class="form-control" required>
            </div>

            <div class="mb-3 w-100">
                <label class="form-label"><i class="bi bi-star"></i> Puntos necesarios</label>
                <input type="number" name="points" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success w-100">
                <i class="bi bi-check-circle"></i> Guardar Cupón
            </button>
        </form>

        <div class="text-center mt-3">
            <a href="{{ route('admin.bonificaciones') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Volver</a>
        </div>
    </div>
</div>
@endsection