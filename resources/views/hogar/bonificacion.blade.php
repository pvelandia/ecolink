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
                    <td>{{ $cupon->discount }}%</td>
                    <td>{{ $cupon->points }}</td>
                    <td>
                        @if($points >= $cupon->points)  <!-- Verifica si el usuario tiene suficientes puntos -->
                            <form action="{{ route('bonificacion.canjear', $cupon->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success">Canjear</button>
                            </form>
                        @else
                            <button class="btn btn-secondary" disabled>No tienes suficientes puntos</button>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @if(auth()->user()->coupon_id)
        <div class="mt-5 alert alert-success">
            <h5>Cupón Canjeado</h5>
            @php
                $cup = \App\Models\Coupon::find(auth()->user()->coupon_id);
            @endphp
            <p><strong>Número de cupón:</strong> {{ $cup->numero_cupon }}</p>
            <p><strong>Compañía:</strong> {{ $cup->company }}</p>
            <p><strong>Descripción:</strong> {{ $cup->description }}</p>
            <p><strong>Descuento:</strong> {{ $cup->discount }}%</p>
            <h5>¡Tienes que enviarlo a tu correo para poder canjearlo en el establecimiento!</h5>
            <p>Una vez enviado solo tendras acceso a el desde tu correo.</p>
            <form action="{{ route('hogar.home') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary">Enviar por correo</button>
            </form>
        </div>
    @endif
    <p>Para poder canjear otro cupon, debes enviar el anterior a tu correo.</p>
    @endif
</div>
@endsection