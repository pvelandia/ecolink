@extends('layouts.app')

@section('content')
<style>
    .grid-menu {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
        margin-top: 2rem;
    }

    .btn-cuadrado {
        border-radius: 1rem;
        width: 100%;
        height: 140px;
        font-size: 1rem;
        background-color: #03A63C;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: white;
        text-align: center;
        overflow: hidden;
        text-decoration: none;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        transition: transform 0.2s ease;
    }

    .btn-cuadrado:hover {
        transform: scale(1.05);
    }

    .banner {
        font-size: 1.5rem;
        font-weight: bold;
        color: black;
        text-align: center;
        margin-bottom: 1.5rem;
    }

    .table th, .table td {
        vertical-align: middle;
    }
</style>

<div class="container py-4">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">    
    <div class="banner">
        <h2>Gestión de Usuarios</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="GET" action="{{ route('admin.usuarios') }}" class="row g-3 mb-4 align-items-center">
        <div class="col-auto">
            <label for="rol_id" class="col-form-label">Filtrar por rol:</label>
        </div>
        <div class="col-auto">
            <select name="rol_id" id="rol_id" class="form-select">
                <option value="">Todos</option>
                @foreach($roles as $rol)
                    <option value="{{ $rol->id }}" {{ $filtroRol == $rol->id ? 'selected' : '' }}>
                        {{ $rol->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary"> 🔍Filtrar</button>
        </div>
    </form>
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Documento</th>
                    <th>Teléfono</th>
                    <th>Cambiar rol</th>
                </tr>
            </thead>
            <tbody>
                @forelse($usuarios as $usuario)
                    <tr>
                        <td>{{ $usuario->first_name }} {{ $usuario->last_name }}</td>
                        <td>{{ $usuario->email }}</td>
                        <td>{{ $usuario->document }}</td>
                        <td>{{ $usuario->phone_number }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <form method="POST" action="{{ route('admin.usuarios.actualizarRol', $usuario->id) }}" class="d-flex">
                                    @csrf
                                    <select name="role_id" class="form-select form-select-sm me-2">
                                        @foreach($roles as $rol)
                                            <option value="{{ $rol->id }}" {{ $usuario->role_id == $rol->id ? 'selected' : '' }}>
                                                {{ $rol->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-sm btn-success">Actualizar</button>
                                </form>
                                @if($usuario->role->name !== 'Bloqueado')
                                    <form method="POST" action="{{ route('admin.usuarios.bloquear', $usuario->id) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de que deseas bloquear a este usuario?')">Bloquear</button>
                                    </form>
                                @endif

                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No hay usuarios registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="text-center mt-3">
        <a href="{{ route('admin.menu') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>
 </div>
@endsection