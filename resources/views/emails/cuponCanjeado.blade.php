<!-- Tarjeta del cupón -->
<div style="background-color: #f1f8e9; border-left: 8px solid #66bb6a; padding: 30px; border-radius: 15px; margin-top: 30px; font-family: Arial, sans-serif; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
    <h2 style="margin-top: 0; color: #388e3c; font-size: 24px; font-weight: bold;">🎫 Cupón #{{ str_pad($redemption->id, 6, '0', STR_PAD_LEFT) }}</h2>
    
    <ul style="list-style: none; padding-left: 0; font-size: 16px; line-height: 1.7; color: #555;">
        <li style="margin-bottom: 10px; font-weight: bold; color: #388e3c;">🏢 <span style="font-weight: normal; color: #333;">Compañía:</span> {{ $coupon->company }}</li>
        <li style="margin-bottom: 10px; font-weight: bold; color: #388e3c;">📍 <span style="font-weight: normal; color: #333;">Dirección:</span> {{ $coupon->address }}</li>
        <li style="margin-bottom: 10px; font-weight: bold; color: #388e3c;">📞 <span style="font-weight: normal; color: #333;">Teléfono:</span> {{ $coupon->phone }}</li>
        <li style="margin-bottom: 10px; font-weight: bold; color: #388e3c;">📝 <span style="font-weight: normal; color: #333;">Descripción:</span> {{ $coupon->description }}</li>
        <li style="margin-bottom: 10px; font-weight: bold; color: #388e3c;">💸 <span style="font-weight: normal; color: #333;">Descuento:</span> {{ $coupon->discount }}%</li>
        <li style="margin-bottom: 10px; font-weight: bold; color: #388e3c;">⭐ <span style="font-weight: normal; color: #333;">Puntos Usados:</span> {{ $coupon->points }}</li>

        @if($coupon->image)
                <strong style="color: #388e3c;"></strong><br>
                <img src="{{ asset('storage/cupones' . $coupon->image) }}" alt="" style="max-width: 100%; border-radius: 10px; margin-top: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
            </li>
        @endif
    </ul>
</div>
