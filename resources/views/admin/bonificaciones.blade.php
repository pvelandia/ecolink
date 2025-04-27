@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #e6f5e5;
    }
    .card {
        border-radius: 1rem;
        overflow: hidden;
        transition: transform 0.3s;
    }
    .card:hover {
        transform: scale(1.03);
    }
    .card-img-top {
        height: 200px;
        object-fit: cover;
    }
    .btn-custom {
        background-color: #28a745;
        color: white;
    }
</style>

<div class="container py-5">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <h2 class="text-center mb-4">Gestión de Bonificaciones</h2>

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

    @if($cupones->count())
        <div class="row">
            @foreach($cupones as $cupon)
                <div class="col-md-4 mb-4">
                    <div class="card shadow">
                    @if($cupon->image)
                        <img src="{{ asset('storage/' . $cupon->image) }}" class="card-img-top" alt="Imagen del cupón">
                    @else
                        <img src="https://via.placeholder.com/400x200?text=Sin+Imagen" class="card-img-top" alt="Sin imagen">
                    @endif
                        <div class="card-body text-center">
                            <h5 class="card-title">{{ $cupon->company }}</h5>
                            <p class="card-text">{{ $cupon->description }}</p>
                            <p><strong>Descuento:</strong> {{ rtrim(rtrim(number_format($cupon->discount, 2, '.', ''), '0'), '.') }}%</p>
                            <p><strong>Stock:</strong> {{ $cupon->stock }}</p>
                            <p><strong>Puntos:</strong> {{ $cupon->points }}</p>
                            <div class="d-flex justify-content-center">
                                <a href="{{ route('admin.editarCupon', $cupon->id) }}" class="btn btn-primary btn-sm me-2">
                                    <i class="bi bi-pencil-square"></i> Editar
                                </a>

                                <form action="{{ route('admin.eliminarCupon', $cupon->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este cupón?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i> Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info text-center">
            <i class="bi bi-exclamation-circle"></i> No hay cupones existentes.
        </div>
    @endif

    <div class="text-center mt-4">
        <a href="{{ route('admin.crearCupon') }}" class="btn btn-custom">
            <i class="bi bi-plus-circle"></i> ¡Crea uno nuevo!
        </a>
    </div>

    <div class="text-center mt-3">
        <a href="{{ route('admin.menu') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>
</div>
@endsection