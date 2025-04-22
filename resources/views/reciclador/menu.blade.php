@extends('layouts.app')

@section('content')
<style>
    .grid-menu {
        display: grid;
        grid-template-columns: repeat(2, 1fr);;
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

    .btn-cuadrado img {
        width: 48px;
        height: 48px;
        object-fit: contain;
        margin-bottom: 0.5rem;
    }

    .banner {
        font-size: 1.5rem;
        font-weight: bold;
        color: black;
        text-align: center;
        margin-bottom: 1.5rem;
    }
</style>

<div class="container mt-4">
    <div class="banner">
        <h1 style="font-size: 2.3em; margin-top: 0; margin-bottom: 0;">Bienvenid@ {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}, este es tu menu</h1>
    </div>
    <div class="grid-menu">
        <a href="{{ route('reciclador.solicitudes') }}" class="btn btn-cuadrado">
            <img src="{{ asset('https://cdn-icons-png.flaticon.com/512/8921/8921043.png') }}" alt="Solicitudes Disponibles">
            Solicitudes Disponibles
        </a>
        <a href="{{ route('reciclador.recoleccionesAceptadas') }}" class="btn btn-cuadrado">
            <img src="{{ asset('https://www.serviciosecologicosintegrados.com/wp-content/uploads/2021/01/Iconos_Servicios_-01.png') }}" alt="Recolecciones Aceptadas">
            Recolecciones Aceptadas
        </a>
        <a href="{{ route('reciclador.recoleccionesAprobadas') }}" class="btn btn-cuadrado">
            <img src="{{ asset('https://cdn-icons-png.flaticon.com/512/2726/2726544.png') }}" alt="Recolecciones Aprobadas">
            Recolecciones Aprobadas
        </a>
        <a href="{{ route('reciclador.recoleccionesFinalizadas') }}" class="btn btn-cuadrado">
            <img src="{{ asset('https://cdn-icons-png.flaticon.com/512/2371/2371904.png') }}" alt="Recolecciones Finalizadas">
            Recolecciones Finalizadas
        </a>
    </div>
</div>
@endsection