<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recolecciones Finalizadas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #e6f5e5; /* Fondo verde claro */
        }
        h2 {
            color: #025939; /* Color verde para el título */
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #025939; /* Color verde para el encabezado */
            color: white; /* Texto blanco en el encabezado */
        }
        td {
            color: #025939; /* Color verde para el texto de las celdas */
        }
        ul {
            padding-left: 20px; /* Espaciado para la lista de materiales */
            margin: 0; /* Eliminar margen */
        }
    </style>
</head>
<body>
    <div style="text-align: center;">
        <img src="{{ 'https://i.postimg.cc/3JLLydKZ/Imagen-de-Whats-App-2025-04-14-a-las-08-27-25-b82fdc0e.jpg' }}" alt="EcoLink" style="max-width: 200px; margin-bottom: 20px;"> <!-- Asegúrate de que esta URL sea correcta -->
    </div>
    
    <h2>Reporte de Recolecciones Finalizadas</h2>
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