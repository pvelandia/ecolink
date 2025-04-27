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
            <h3 class="text-center mb-4 text-success"><i class="bi bi-box"></i> Crear Nuevo Material</h3>

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

            <form method="POST" action="{{ route('admin.storeMaterial') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label"><i class="bi bi-archive"></i> Nombre del Material</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Descripción</label>
                    <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label"><i class="bi bi-calculator"></i> Puntos por Kilo</label>
                    <input type="number" step="0.1" name="points_kilo" class="form-control" value="{{ old('points_kilo') }}" required>
                </div>

                <button type="submit" class="btn btn-success w-100">
                    <i class="bi bi-check-circle"></i> Guardar Material
                </button>
            </form>

            <div class="text-center mt-3">
                <a href="{{ route('admin.materiales') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Volver</a>
            </div>
        </div>
    </div>
</div>
@endsection