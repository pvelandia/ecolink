@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #e6f5e5;
    }
    .card {
        border-radius: 1rem;
    }
</style>

<div class="container py-5 d-flex justify-content-center align-items-center">
    <div class="col-md-10">
        <div class="card shadow p-4">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
            <h3 class="text-center mb-4 text-success"><i class="bi bi-truck"></i> Solicitar Recolección</h3>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="list-unstyled mb-0">
                        @foreach ($errors->all() as $error)
                            <li><i class="bi bi-exclamation-circle"></i> {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    <i class="bi bi-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('solicitudes.store') }}">
                @csrf

                <div id="materials-container">
                    <div class="row mb-3 material-row">
                        <div class="col-md-6">
                            <label class="form-label">Material</label>
                            <select name="materials[0][material_id]" class="form-control" required>
                                <option value="">Selecciona un material</option>
                                @foreach ($materials as $material)
                                    <option value="{{ $material->id }}" {{ old('materials.0.material_id') == $material->id ? 'selected' : '' }}>{{ $material->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
    <label class="form-label">Cantidad (kg)</label>
    <input type="number" step="0.1" name="materials[0][quantity]" class="form-control" value="{{ old('materials.0.quantity') }}" required>
    <div id="error-message" style="color: red; display: none;">Por favor, usa un punto (.) como separador decimal.</div>
</div>

                        <div class="col-md-2 d-flex align-items-end justify-content-center">
                            <button type="button" class="btn btn-outline-danger btn-sm remove-material" title="Eliminar material">
                                <i class="bi bi-x-circle fs-5"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <button type="button" id="add-material" class="btn btn-outline-success mb-4">
                    <i class="bi bi-plus-circle"></i> Agregar otro material
                </button>

                <hr>

                <div class="mb-3">
                    <label class="form-label"><i class="bi bi-house-door"></i> Dirección</label>
                    <input type="text" name="address_part1" class="form-control" value="{{ old('address_part1') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label"><i class="bi bi-geo-alt"></i> Barrio</label>
                    <input type="text" name="address_part2" class="form-control " value="{{ old('address_part2') }}" required>
                </div>

             

                <div class="mb-3">
                    <label class="form-label"><i class="bi bi-calendar-event"></i> Fecha y hora de recolección</label>
                    <input type="datetime-local" name="collection_date" class="form-control" value="{{ old('collection_date') }}" required>
                </div>

                <button type="submit" class="btn btn-success w-100">
                    <i class="bi bi-send-check"></i> Enviar solicitud
                </button>
            </form>

            <div class="text-center mt-3">
                <a href="{{ route('hogar.home') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Volver </a>
            </div>
        </div>
    </div>
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
        if (e.target.closest('.remove-material')) {
            const rows = document.querySelectorAll('.material-row');
            if (rows.length > 1) {
                e.target.closest('.material-row').remove();
            }
        }
    });
</script>
<script>
    document.querySelector('form').addEventListener('submit', function(event) {
        let quantityInput = document.querySelector('input[name="materials[0][quantity]"]');
        let quantityValue = quantityInput.value;

        // Verificar si hay coma en el valor
        if (quantityValue.includes(',')) {
            // Mostrar el mensaje de error
            document.getElementById('error-message').style.display = 'block';

            // Evitar el envío del formulario hasta corregirlo
            event.preventDefault();
        } else {
            // Si no hay coma, lo convierte automáticamente en un punto, si es necesario
            quantityInput.value = quantityValue.replace(',', '.');
        }
    });
</script>

@endsection