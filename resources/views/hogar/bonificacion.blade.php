@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="text-center">Bonificaciones Disponibles</h2>

    <div class="mb-4">
        <h4>Puntos Totales: {{ $points }}</h4>  <!-- Mostrar puntos totales -->
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if($cupones->isEmpty())
        <p>No hay bonificaciones disponibles en este momento.</p>
    @else
        <h4>Cupones Disponibles</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Compañía</th>
                    <th>Descripción</th>
                    <th>Descuento (%)</th>
                    <th>Puntos Requeridos</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cupones as $cupon)
                <tr>
                    <td>{{ $cupon->company }}</td>
                    <td>{{ $cupon->description }}</td>
                    <td>{{ number_format($cupon->discount, 0) }}%</td> <!-- Muestra el descuento sin decimales -->
                    <td>{{ $cupon->points }}</td>
                    <td>
                        @if($points >= $cupon->points && $cupon->stock > 0)  <!-- Verifica si el usuario tiene suficientes puntos -->
                            <form action="{{ route('bonificacion.canjear', $cupon->id) }}" method="POST" onsubmit="return confirmCanjear()">
                                @csrf
                                <button type="submit" class="btn btn-success">Canjear</button>
                            </form>
                        @else
                            <button class="btn btn-secondary" disabled>No tienes suficientes puntos o el cupón está agotado</button>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    @if($canjeados->isNotEmpty())
        <h4>Cupones Canjeados</h4>
        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>Compañía</th>
                    <th>Descripción</th>
                    <th>Descuento (%)</th>
                    <th>Puntos Requeridos</th>
                    <th>Fecha de Canje</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach($canjeados as $canje)
                <tr>
                    <td>{{ $canje->coupon->company }}</td>
                    <td>{{ $canje->coupon->description }}</td>
                    <td>{{ number_format($canje->coupon->discount, 0) }}%</td> <!-- Muestra el descuento sin decimales -->
                    <td>{{ $canje->coupon->points }}</td>
                    <td>{{ $canje->redeemed_at }}</td>
                    <td>
<!-- Botón para enviar el cupón por correo -->
<form action="{{ route('bonificacion.reenviar', $canje->id) }}" method="POST">
    @csrf
    <button type="submit" class="btn btn-primary">Enviar por Correo</button>
</form>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    <a href="{{ route('hogar.home') }}" class="btn btn-secondary mt-3">Volver</a>
</div>

<script>
    function confirmCanjear() {
        return confirm('¿Estás seguro de que deseas canjear este cupón? Una vez canjeado no podrás cambiarlo.');
    }
</script>
@endsection