@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="text-center">Bonificaciones Disponibles</h2>

    <div class="mb-4">
        <h4>Puntos Totales: {{ $points }}</h4>  <!-- Mostrar puntos totales -->
    </div>

    @if($cupones->isEmpty())
        <p>No hay bonificaciones disponibles en este momento.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Compañía</th>
                    <th>Descripción</th>
                    <th>Descuento (%)</th>
                    <th>Stock</th>
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
                    <td>{{ $cupon->stock }}</td>
                    <td>{{ $cupon->points }}</td>
                    <td>
                        @if($points >= $cupon->points)  <!-- Usamos la variable correcta -->
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
    @endif
</div>
@endsection
