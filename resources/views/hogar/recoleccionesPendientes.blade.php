@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="text-center">Recolecciones Pendientes</h2>

    @if($recolecciones->isEmpty())
        <p>No hay recolecciones pendientes para calificar o finalizar.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Fecha de Recolección</th>
                    <th>Reciclador</th>
                    <th>Materiales Recolectados</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recolecciones as $recoleccion)
                <tr>
                    <td>{{ $recoleccion->assignment_date }}</td>
                    <td>
                        {{ $recoleccion->reciclador->first_name }} {{ $recoleccion->reciclador->last_name }} <br>
                        <strong>Teléfono:</strong> {{ $recoleccion->reciclador->phone_number }} <br>
                        <strong>Cédula:</strong> {{ $recoleccion->reciclador->document }}
                    </td>
                    <td>
                        <ul>
                            @foreach($recoleccion->materials as $material)
                                <li>{{ $material->name }} - Cantidad: {{ $material->pivot->quantity }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        <!-- Formulario para finalizar y calificar en el mismo botón -->
                        <form action="{{ route('recolecciones.finalizar', $recoleccion->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="calificacion">Calificación (1-5):</label>
                                <input type="number" name="calificacion" min="1" max="5" class="form-control" required />
                                @if ($errors->has('calificacion'))
                                    <div class="text-danger mt-2">{{ $errors->first('calificacion') }}</div>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-success">Finalizar y Calificar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
