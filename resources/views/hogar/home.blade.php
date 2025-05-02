@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    .grid-menu {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.5rem;
        margin-top: 2rem;
    }

    .btn-cuadrado {
        border-radius: 1rem;
        width: 100%;
        height: 200px;
        font-size: 1.2rem;
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

    .btn-cuadrado img {
        width: 64px;
        height: 64px;
        object-fit: contain;
        margin-bottom: 0.7rem;
    }

    .banner {
        font-size: 1.5rem;
        font-weight: bold;
        color:black;
        text-align: center;
        margin-bottom: 1.5rem;
        text-transform: uppercase; 
    }

    @media (max-width: 992px) {
        .grid-menu {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 576px) {
        .grid-menu {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="container mt-4">
    <div class="banner">
        <h1 style="border: 2px solid blue; padding: 10px; border-radius: 5px; display: inline-block;">
            Bienvenid@ {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
        </h1>
        <div style="font-size: 0.8em; margin-top: 5px; color: #555;">
            ¡Tienes un gran Hogar!
        </div>
    </div>

    <div class="grid-menu">
        <a href="{{ route('hogar.educacion') }}" class="btn btn-cuadrado">
            <img src="{{ asset('https://cdn-icons-png.flaticon.com/512/12201/12201304.png') }}" alt="Educación">
            Educación Ambiental
        </a>
        <a href="{{ route('solicitudes.create') }}" class="btn btn-cuadrado">
            <img src="{{ asset('https://www.serviciosecologicosintegrados.com/wp-content/uploads/2021/01/Iconos_Servicios_-01.png') }}" alt="Solicitar">
            Solicitar Recolección
        </a>
        <a href="{{ route('hogar.solicitudesPendientes') }}" class="btn btn-cuadrado">
            <img src="{{ asset('https://cdn-icons-png.flaticon.com/512/8921/8921043.png') }}" alt="Pendientes">
            Solicitudes Pendientes
        </a>
        <a href="{{ route('hogar.solicitudes') }}" class="btn btn-cuadrado">
            <img src="{{ asset('https://cdn-icons-png.flaticon.com/512/2726/2726544.png') }}" alt="Espera">
            En espera de aprobación
        </a>
        <a href="{{ route('hogar.recoleccionesAprobadas') }}" class="btn btn-cuadrado">
            <img src="{{ asset('https://cdn-icons-png.flaticon.com/512/13197/13197701.png') }}" alt="Aprobadas">
            Por calificar
        </a>
        <a href="{{ route('hogar.recoleccionesFinalizadas') }}" class="btn btn-cuadrado">
            <img src="{{ asset('https://cdn-icons-png.flaticon.com/512/2371/2371904.png') }}" alt="Finalizadas">
            Finalizadas
        </a>
        <a href="{{ route('hogar.bonificacion') }}" class="btn btn-cuadrado">
            <img src="{{ asset('https://cdn-icons-png.flaticon.com/512/2331/2331729.png') }}" alt="Bonificaciones">
            Bonificaciones
        </a>
    </div>
@endsection