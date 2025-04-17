@extends('layouts.app')
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel del Hogar</title>
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
            <h2 class="mb-4">Bienvenido a tu Panel</h2>

            <div class="d-grid gap-3 col-8 mx-auto">
                <a href="{{ route('hogar.educacion') }}" class="btn btn-secondary btn-lg">Educación Ambiental</a>
                <a href="{{ route('solicitudes.create') }}" class="btn btn-primary btn-lg">Solicitar Recolección</a>
                <a href="{{ route('hogar.solicitudesPendientes') }}" class="btn btn-primary btn-lg">Solicitudes Pendientes</a>

                <a href="{{ route('hogar.solicitudes') }}" class="btn btn-info btn-lg text-white">Recolecciones Aceptadas</a>
                <a href="{{ route('hogar.recoleccionesAprobadas') }}" class="btn btn-warning btn-lg text-white">Recolecciones Aprobadas</a>
                <a href="{{ route('hogar.recoleccionesFinalizadas') }}" class="btn btn-dark btn-lg text-white">Recolecciones Finalizadas</a>
                <a href="{{ route('hogar.bonificacion') }}" class="btn btn-success btn-lg">Bonificaciones</a>
        </div>
    </div>
</body>