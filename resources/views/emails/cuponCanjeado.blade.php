<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cupón Canjeado</title>
</head>
<body style="font-family: 'Segoe UI', sans-serif; background-color: #e8f5e9; padding: 30px; color: #2e2e2e;">
    <div style="max-width: 650px; margin: auto; background-color: #ffffff; border-radius: 20px; padding: 40px; box-shadow: 0 6px 20px rgba(0,0,0,0.15);">
        <div style="text-align: center;">
            <h1 style="color: #2e7d32; font-size: 28px;">¡Hola {{ $user->first_name }} {{ $user->last_name }}! 🌿</h1>
            <p style="font-size: 18px;">🎁 ¡Tu cupón fue canjeado con éxito!</p>
            <p style="font-size: 16px; color: #666;">Aquí tienes los detalles de tu canje:</p>
        </div>

        <!-- Tarjeta del cupón -->
        <div style="background-color: #f1f8e9; border-left: 8px solid #66bb6a; padding: 25px; border-radius: 15px; margin-top: 30px;">
            <h2 style="margin-top: 0; color: #388e3c;">🎫 Cupón #{{ str_pad($redemption->id, 6, '0', STR_PAD_LEFT) }}</h2>
            <ul style="list-style: none; padding-left: 0; font-size: 16px; line-height: 1.7;">
                <li><strong>🏢 Compañía:</strong> {{ $cupon->company }}</li>
                <li><strong>📝 Descripción:</strong> {{ $cupon->description }}</li>
                <li><strong>💸 Descuento:</strong> {{ $cupon->discount }}%</li>
                <li><strong>⭐ Puntos Usados:</strong> {{ $cupon->points }}</li>
            </ul>
        </div>

        <!-- Condiciones del cupón -->
        <div style="margin-top: 25px; background-color: #fffde7; padding: 20px; border-radius: 10px; border-left: 6px solid #fbc02d;">
            <h4 style="margin: 0; color: #f57f17;">⚠️ Condiciones del Cupón</h4>
            <ul style="font-size: 15px; color: #5d4037; padding-left: 20px; margin-top: 10px;">
                <li>📅 Válido hasta: <strong>{{ \Carbon\Carbon::parse($redemption->redeemed_at)->addMonth()->format('d/m/Y') }}</strong></li>
                <li>🔁 Solo válido por una única vez.</li>
            </ul>
        </div>

        <!-- Mensaje final -->
        <div style="margin-top: 40px; text-align: center;">
            <p style="font-size: 17px; color: #4caf50;">
                Gracias por seguir reciclando y cuidar el planeta con nosotros. 🌎💚
            </p>
            <p style="font-size: 14px; color: #999;">
                Sigue acumulando puntos y redime más recompensas con <strong>EcoLink</strong>.
            </p>
        </div>

        <!-- Footer -->
        <div style="text-align: center; margin-top: 30px; font-size: 13px; color: #aaa;">
            🌱 Este es un correo automático, por favor no respondas directamente.
        </div>
    </div>
</body>
</html>
