@extends('layouts.app')
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Menu administrador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
        }
        .card {
            border-radius: 1rem;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        .btn-lg {
            font-size: 1.2rem;
            padding: 1rem 2rem;
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center vh-100">
    <div class="container text-center">
        <div class="card p-5">
            <h2 class="mb-4 text-success">Bienvenido Administrador</h2>
            <div class="d-grid gap-3 col-8 mx-auto">
            <a href="{{ route('admin.usuarios') }}" class="btn btn-primary btn-lg">
            <i class="bi bi-clipboard-check"></i> Usuarios </a>
            <a href="{{ route('admin.bonificaciones') }}" class="btn btn-primary btn-lg">
            <i class="bi bi-clipboard-check"></i> Bonificaciones </a>
            <a href="{{ route('admin.reportes') }}" class="btn btn-primary btn-lg">
            <i class="bi bi-clipboard-check"></i> Reportes </a>
            </div>
        </div>
    </div>
</body>