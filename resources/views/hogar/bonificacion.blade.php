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
    <h2 class="text-center mb-4">Bonificaciones Disponibles</h2>

    <div class="mb-4">
        <h2>Puntos Totales: {{ $points }}</h2>
    </div>

    {{-- Mensajes de éxito o error --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    {{-- Cupones Disponibles --}}
    @if($cupones->isEmpty())
        <div class="alert alert-info text-center">
            <i class="bi bi-exclamation-circle"></i> No hay cupones disponibles.
        </div>
    @else
        <div class="row">
            @foreach($cupones as $cupon)
                <div class="col-md-4 mb-4">
                    <div class="card shadow">
                        @if($cupon->image)
                            <img src="{{ asset('storage/cupones/' . $cupon->image) }}" class="card-img-top" alt="Imagen del cupón">
                        @else
                            <img src="https://via.placeholder.com/400x200?text=Sin+Imagen" class="card-img-top" alt="Sin imagen">
                        @endif
                        <div class="card-body text-center">
                            <h5 class="card-title">{{ $cupon->company }}</h5>
                            <p class="card-text">{{ $cupon->description }}</p>
                            <p><strong>Descuento:</strong> {{ number_format($cupon->discount, 0) }}%</p>
                            <p><strong>Puntos Requeridos:</strong> {{ $cupon->points }}</p>
                            <p><strong>Dirección:</strong> {{ $cupon->address }}</p>
                            <p><strong>Teléfono:</strong> {{ $cupon->phone }}</p>
                            <div class="d-flex justify-content-center">
                                @if($points >= $cupon->points && $cupon->stock > 0)
                                    <form action="{{ route('bonificacion.canjear', $cupon->id) }}" method="POST" onsubmit="return confirmCanjear()">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">Canjear</button>
                                    </form>
                                @else
                                    <button class="btn btn-secondary btn-sm" disabled>No disponible</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    {{-- Cupones Canjeados --}}
    @if($canjeados->isNotEmpty())
        <h4 class="mt-5">Cupones Canjeados</h4>
        <table class="table table-bordered table-hover mt-4">
            <thead class="table-light text-center">
                <tr>
                    <th>Compañía</th>
                    <th>Descripción</th>
                    <th>Descuento (%)</th>
                    <th>Puntos Requeridos</th>
                    <th>Fecha de Canje</th>
                    <th>Logo</th>
                    <th>Dirección</th>
                    <th>Teléfono</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody class="align-middle text-center">
                @foreach($canjeados as $canje)
                <tr>
                    <td>{{ $canje->coupon->company }}</td>
                    <td>{{ $canje->coupon->description }}</td>
                    <td>{{ number_format($canje->coupon->discount, 0) }}%</td>
                    <td>{{ $canje->coupon->points }}</td>
                    <td>{{ $canje->redeemed_at }}</td>
                    <td>
                        @if($canje->coupon->image)
                            <img src="{{ asset('storage/cupones/' . $canje->coupon->image) }}" style="width: 100px; height: 60px; object-fit: cover;" alt="Imagen del cupón">
                        @else
                            <span class="text-muted">Sin imagen</span>
                        @endif
                    </td>
                    <td>{{ $canje->coupon->address }}</td>
                    <td>{{ $canje->coupon->phone }}</td>
                    <td>
                        <form action="{{ route('bonificacion.reenviar', $canje->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-sm btn-hover-mail">Enviar por Correo</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div class="text-center mt-3">
        <a href="{{ route('hogar.home') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>
</div>

{{-- Script de confirmación --}}
<script>
    function confirmCanjear() {
        return confirm('¿Estás seguro de que deseas canjear este cupón? Una vez canjeado no podrás cambiarlo.');
    }
</script>

@endsection