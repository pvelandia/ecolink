@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Solicitar Recolección</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('solicitudes.store') }}">
        @csrf

        <div id="materials-container">
            <div class="row mb-3 material-row">
                <div class="col-md-6">
                    <label>Material</label>
                    <select name="materials[0][material_id]" class="form-control" required>
                        <option value="">Selecciona un material</option>
                        @foreach ($materials as $material)
                            <option value="{{ $material->id }}">{{ $material->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label>Cantidad (kg)</label>
                    <input type="number" step="0.1" name="materials[0][quantity]" class="form-control" required>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-danger remove-material">✖</button>
                </div>
            </div>
        </div>

        <button type="button" id="add-material" class="btn btn-secondary mb-3">+ Agregar otro material</button>

        <!-- Campos para la dirección -->
        <div class="mb-3">
            <label>Dirección</label>
            <input type="text" name="address_part1" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Barrio</label>
            <input type="text" name="address_part2" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Indicacion adicional (opcional)</label>
            <input type="text" name="address_part3" class="form-control">
        </div>

        <!-- Campo de fecha y hora -->
        <div class="mb-3">
            <label>Fecha y hora de recolección</label>
            <input type="datetime-local" name="collection_date" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Enviar solicitud</button>
    </form>
    <a href="{{ route('hogar.home') }}" class="btn btn-secondary mt-3">Volver</a>
</div>
<script>
    let materialIndex = 1;

    document.getElementById('add-material').addEventListener('click', () => {
        const container = document.getElementById('materials-container');
        const row = document.querySelector('.material-row').cloneNode(true);

        row.querySelectorAll('select, input').forEach(input => {
            const name = input.getAttribute('name');
            input.setAttribute('name', name.replace(/\[\d+\]/, `[${materialIndex}]`));
            input.value = '';
        });

        container.appendChild(row);
        materialIndex++;
    });

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-material')) {
            const rows = document.querySelectorAll('.material-row');
            if (rows.length > 1) {
                e.target.closest('.material-row').remove();
            }
        }
    });
</script>
@endsection
