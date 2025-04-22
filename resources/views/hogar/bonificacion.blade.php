@extends('layouts.app')

@section('content')
<div class="container py-5">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <h2 class="text-center">Bonificaciones Disponibles</h2>
    <div class="mb-4">
        <h4>Puntos Totales: {{ $points }}</h4>
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
        <p>No hay bonificaciones disponibles en este momento.</p>
    @else
        <h4>Cupones Disponibles</h4>
        <table class="table table-bordered table-hover">
            <thead class="table-light text-center">
                <tr>
                    <th>Compañía</th>
                    <th>Descripción</th>
                    <th>Descuento (%)</th>
                    <th>Puntos Requeridos</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody class="align-middle text-center">
                @foreach($cupones as $cupon)
                <tr>
                    <td>{{ $cupon->company }}</td>
                    <td>{{ $cupon->description }}</td>
                    <td>{{ number_format($cupon->discount, 0) }}%</td>
                    <td>{{ $cupon->points }}</td>
                    <td>
                        @if($points >= $cupon->points && $cupon->stock > 0)
                            <form action="{{ route('bonificacion.canjear', $cupon->id) }}" method="POST" onsubmit="return confirmCanjear()">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Canjear</button>
                            </form>
                        @else
                            <button class="btn btn-secondary btn-sm" disabled>No disponible</button>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    {{-- Cupones Canjeados --}}
    @if($canjeados->isNotEmpty())
        <h4>Cupones Canjeados</h4>
        <table class="table table-bordered table-hover mt-4">
            <thead class="table-light text-center">
                <tr>
                    <th>Compañía</th>
                    <th>Descripción</th>
                    <th>Descuento (%)</th>
                    <th>Puntos Requeridos</th>
                    <th>Fecha de Canje</th>
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
<style>
    .btn-hover-mail {
        transition: background-color 0.3s, color 0.3s;
    }

    .btn-hover-mail:hover {
        background-color: #004085 !important;
        color: #ffffff !important;
    }
</style>
@endsection