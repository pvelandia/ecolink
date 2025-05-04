<!-- Tarjeta del cupón -->
<div style="background-color: #f1f8e9; border: 3px dashed #66bb6a; padding: 30px; border-radius: 15px; margin-top: 30px; font-family: Arial, sans-serif; box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);">
    <h2 style="margin-top: 0; color: #2e7d32; font-size: 26px; font-weight: bold; text-align: center;">
        🎉 ¡Cupón Canjeado con Éxito!
    </h2>
    <h3 style="color: #388e3c; font-size: 22px; text-align: center; margin: 10px 0;">
        🎫 Código: {{ str_pad($redemption->id, 6, '0', STR_PAD_LEFT) }}
    </h3>

    <ul style="list-style: none; padding-left: 0; font-size: 16px; line-height: 1.7; color: #555;">
        <li style="margin-bottom: 10px;"><strong style="color: #388e3c;">🏢 Compañía:</strong> {{ $coupon->company }}</li>
        <li style="margin-bottom: 10px;"><strong style="color: #388e3c;">📍 Dirección:</strong> {{ $coupon->address }}</li>
        <li style="margin-bottom: 10px;"><strong style="color: #388e3c;">📞 Teléfono:</strong> {{ $coupon->phone }}</li>
        <li style="margin-bottom: 10px;"><strong style="color: #388e3c;">📝 Descripción:</strong> {{ $coupon->description }}</li>
        <li style="margin-bottom: 10px;"><strong style="color: #388e3c;">💸 Descuento:</strong> {{ $coupon->discount }}%</li>
        <li style="margin-bottom: 10px;"><strong style="color: #388e3c;">⭐ Puntos Usados:</strong> {{ $coupon->points }}</li>
    </ul>

    @if($coupon->image)
        <div style="text-align: center; margin-top: 15px;">
            <img src="{{ asset('storage/cupones' . $coupon->image) }}" alt="Imagen del cupón" style="max-width: 100%; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
        </div>
    @endif

    <p style="text-align: center; margin-top: 20px; font-size: 14px; color: #666;">
        ⚠️ <em>Válido solo según lo indicado. No acumulable con otras promociones.</em>
    </p>
</div>
