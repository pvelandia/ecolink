<!-- resources/views/admin/pdf/recoleccionesFinalizadasAdmin.blade.php -->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recolecciones Finalizadas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <h2>Recolecciones Finalizadas</h2>
    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Reciclador</th>
                <th>Hogar</th>
                <th>Materiales Recolectados</th>
                <th>Calificación</th>
                <th>Puntos</th>
            </tr>
        </thead>
        <tbody>
            @foreach($asignaciones as $recoleccion)
            <tr>
                <td>{{ \Carbon\Carbon::parse($recoleccion->assignment_date)->format('d/m/Y H:i') }}</td>
                <td>{{ $recoleccion->reciclador->first_name }} {{ $recoleccion->reciclador->last_name }}</td>
                <td>{{ $recoleccion->hogar->first_name }} {{ $recoleccion->hogar->last_name }} </td>
                <td>
                    <ul class="mb-0">
                        @foreach($recoleccion->materials as $material)
                            <li>{{ $material->name }} - {{ $material->pivot->quantity }} kg</li>
                        @endforeach
                    </ul>
                </td>
                <td>
                    @if($recoleccion->rating)
                        {{ $recoleccion->rating }} / 5
                    @else
                        <em>No calificado</em>
                    @endif
                </td>
                <td>{{ $recoleccion->points ?? 'No asignados' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
