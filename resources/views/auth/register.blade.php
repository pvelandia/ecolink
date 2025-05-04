<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - EcoLink ♻️</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #d4f8d4, #e6f5e5);
            min-height: 100vh;
        }
        .card {
            border-radius: 1rem;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }
        .card-body {
            padding: 2rem;
        }
        .form-label {
            font-weight: 600;
        }
        .header-title {
            background-color: #4caf50;
            color: white;
            padding: 1rem;
            border-radius: 1rem 1rem 0 0;
            font-size: 1.5rem;
        }
        .error-list {
            list-style-type: none;
            padding-left: 0;
        }
    </style>
</head>
<body>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card">
                    <div class="header-title text-center">
                        <i class="bi bi-leaf"></i> Registro de usuario - EcoLink ♻️
                    </div>
                    <div class="card-body">

                        {{-- Mensajes de éxito --}}
                        @if(session('success'))
                            <div class="alert alert-success">
                                <i class="bi bi-check-circle"></i> {{ session('success') }}
                            </div>
                        @endif

                        {{-- Mensajes de error --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0 error-list">
                                    @foreach ($errors->all() as $error)
                                        <li><i class="bi bi-x-circle"></i> {{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('register.post') }}" method="POST" class="mt-3">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Nombre</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" name="first_name" class="form-control" required value="{{ old('first_name') }}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Apellido</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" name="last_name" class="form-control" required value="{{ old('last_name') }}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Correo</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Cédula</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-credit-card-2-front"></i></span>
                                    <input type="text" name="document" class="form-control" required value="{{ old('document') }}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Teléfono</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                    <input type="text" name="phone_number" class="form-control" required value="{{ old('phone_number') }}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Rol</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                                    <select name="role_id" class="form-select" required>
                                        <option value="">Seleccione un rol</option>
                                        @foreach($roles as $rol)
                                            <option value="{{ $rol->id }}" {{ old('role_id') == $rol->id ? 'selected' : '' }}>
                                                {{ $rol->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Contraseña</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                    <input type="password" name="password" class="form-control" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Confirmar Contraseña</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                    <input type="password" name="password_confirmation" class="form-control" required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-success w-100 py-2">
                                <i class="bi bi-person-plus"></i> Registrarse
                            </button>

                            <div class="text-center mt-3">
                                <a href="{{ route('login') }}" class="text-decoration-none text-success">
                                    <i class="bi bi-box-arrow-in-right"></i> Ya tengo cuenta
                                </a>
                            </div>

                        </form>
                    </div> <!-- card-body -->
                </div> <!-- card -->
            </div>
        </div>
    </div>

</body>
</html>
