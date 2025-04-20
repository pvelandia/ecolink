<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>📅 Recordatorio de Recolección - EcoLink</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f0f8f5;
            margin: 0;
            padding: 20px;
        }
        .card {
            max-width: 600px;
            margin: auto;
            background-color: #ffffff;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
            color: #333333;
        }
        .header {
            background-color: #27ae60;
            padding: 20px;
            border-radius: 12px 12px 0 0;
            text-align: center;
            color: white;
        }
        .header h2 {
            margin: 0;
            font-size: 24px;
        }
        .section-title {
            font-size: 18px;
            color: #27ae60;
            margin-top: 20px;
            margin-bottom: 10px;
        }
        .info-list {
            list-style: none;
            padding-left: 0;
        }
        .info-list li {
            margin-bottom: 8px;
        }
        .info-list li strong {
            color: #2c3e50;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 14px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="header">
            <h2>🌿 ¡Hola {{ $recoleccion->hogar->first_name }}!</h2>
            <p style="margin-top: 5px;">Este es un recordatorio de tu recolección programada en 1 hora</p>
        </div>

        <div>
            <p class="section-title">🕒 Fecha y hora</p>
            <p>{{ \Carbon\Carbon::parse($recoleccion->assignment_date)->format('d/m/Y H:i') }}</p>

            <p class="section-title">🚛 Reciclador asignado</p>
            <p>{{ $recoleccion->reciclador->first_name ?? 'Por confirmar' }}</p>

            <p class="section-title">♻️ Materiales a entregar</p>
            <ul class="info-list">
                @foreach ($recoleccion->materials as $material)
                    <li>{{ $material->name }} - {{ $material->pivot->quantity }} kg</li>
                @endforeach
            </ul>
        </div>

        <div class="footer">
            Te recomendamos estar pendiente para entregar los materiales a tiempo. ♻️<br>
            ¡Gracias por hacer parte del cambio! 💚<br>
            — El equipo de <strong>EcoLink</strong>
        </div>
    </div>
</body>
</html>
