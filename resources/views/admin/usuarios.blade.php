@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2>Gestión de Usuarios</h2>

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
            <button type="submit" class="btn btn-primary">Filtrar</button>
        </div>
    </form>

    <table class="table table-bordered align-middle">
        <thead>
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

                            <form method="POST" action="{{ route('admin.usuarios.bloquear', $usuario->id) }}">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de que deseas bloquear a este usuario?')">Bloquear</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No hay usuarios registrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <a href="{{ route('admin.menu') }}" class="btn btn-secondary mt-3">Volver</a>
</div>
@endsection 