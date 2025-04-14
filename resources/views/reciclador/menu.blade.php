@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="text-center mb-4 text-success">MENÚ RECICLADOR</h2>

    {{-- Menú con Bootstrap --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm rounded">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="bi bi-recycle"></i> Menú Reciclador
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarReciclador">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarReciclador">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <!-- Botón de Solicitudes -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('reciclador.solicitudes') }}">
                            <i class="bi bi-clipboard-check"></i> <span class="fw-bold">Solicitudes</span>
                        </a>
                    </li>
                    <!-- Botón de Recolecciones Pendientes -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('reciclador.recoleccionesPendientes') }}">
                            <i class="bi bi-box-arrow-down"></i> <span class="fw-bold">Recolecciones Pendientes</span>
                        </a>
                    </li>
                    <!-- Botón de Recolecciones Finalizadas -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('reciclador.recoleccionesFinalizadas') }}">
                            <i class="bi bi-box-arrow-up"></i> <span class="fw-bold">Recolecciones Finalizadas</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="text-center mt-5">
        <p class="text-muted">Selecciona una opción del menú para continuar con tus actividades como reciclador.</p>
    </div>
</div>
@endsection
