<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Estadísticas de Recolecciones</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            width: 100%;
            box-sizing: border-box;
        }

        h2 {
            text-align: center;
            color: #025939;
            font-size: 24px;
            margin-top: 20px;
        }

        .chart-container {
            width: 100%;
            max-width: 800px; /* Ajusta el ancho máximo */
            margin: 0 auto; /* Centra el contenedor */
            display: flex;
            flex-direction: column;
            gap: 15px;
            padding: 20px;
            box-sizing: border-box;
        }

        .chart-img {
            width: 100%;
            max-width: 800px; /* Limita el tamaño máximo de las imágenes */
            height: auto;
            page-break-inside: avoid;
            display: block;
            margin: 0 auto;
            page-break-before: always; /* Asegura que cada imagen comience en una nueva página */
        }

    </style>
</head>
<body>
    <h2>Estadísticas de Recolecciones</h2>

    <!-- Contenedor de imágenes -->
    <div class="chart-container">
        @foreach($images as $img)
            <img src="{{ $img }}" class="chart-img">
        @endforeach
    </div>
</body>
</html>
