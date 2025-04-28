<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Solicitud Aprobada</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f8f5;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .container {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            padding: 40px;
            max-width: 700px;
            margin: auto;
        }
        h1 {
            color: #28a745;
            text-align: center;
            font-size: 28px;
            margin-bottom: 20px;
        }
        .subtitle {
            text-align: center;
            font-size: 18px;
            margin-bottom: 30px;
            color: #555;
        }
        .info-section {
            margin-bottom: 30px;
        }
        .info-box {
            background-color: #e8f5e9;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .info-box h2 {
            font-size: 20px;
            margin-bottom: 10px;
            color: #28a745;
        }
        .info-box p {
            margin: 5px 0;
            font-size: 16px;
        }
        .button {
            display: block;
            width: 220px;
            text-align: center;
            margin: 40px auto 0;
            padding: 14px 0;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 30px;
            font-size: 18px;
            font-weight: bold;
        }
        .footer {
            margin-top: 40px;
            font-size: 14px;
            text-align: center;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>¡Solicitud de Recolección Aprobada!</h1>
        <p class="subtitle">Estamos felices de informarte que tu solicitud ha sido aprobada. Aquí tienes toda la información:</p>

        <div class="info-section">
            <div class="info-box">
                <h2>Información de la Solicitud</h2>
                <p><strong>Solicitud #:</strong> {{ $solicitud->id }}</p>
                <p><strong>Dirección:</strong> {{ $solicitud->address }}</p>
                <p><strong>Fecha y hora de recolección:</strong> {{ \Carbon\Carbon::parse($solicitud->assignment_date)->format('d/m/Y h:i A') }}</p>
            </div>

            <div class="info-box">
                <h2>Datos del Hogar</h2>
                <p><strong>Nombre:</strong> {{ $solicitud->hogar->first_name }} {{ $solicitud->hogar->last_name }}</p>
                <p><strong>Teléfono:</strong> {{ $solicitud->hogar->phone_number }}</p>
            </div>

            <div class="info-box">
                <h2>Reciclador Asignado</h2>
                <p><strong>Nombre:</strong> {{ $solicitud->reciclador->first_name }} {{ $solicitud->reciclador->last_name }}</p>
                <p><strong>Teléfono:</strong> {{ $solicitud->reciclador->phone_number }}</p>
            </div>
        </div>

        <a href="{{ route('hogar.solicitudes') }}" class="button">Ver Detalles</a>

        <p class="footer">¡Gracias por contribuir a un mundo más limpio y sostenible! 🌍💚</p>
    </div>
</body>
</html>
