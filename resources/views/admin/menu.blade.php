@extends('layouts.app')

@section('content')
<style>
    .grid-menu {
        display: grid;
        grid-template-columns: repeat(2, 1fr); /* Cambiado a 2 columnas */
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
        text-transform: uppercase; 
    }
</style>

<div class="container mt-4">
    <div class="banner">
        <h1 style="border: 2px solid red; padding: 10px; border-radius: 5px; display: inline-block;">
            Bienvenid@ {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
        </h1>
        <div style="font-size: 0.8em; margin-top: 5px; color: #555;">
            ¡Eres un@ gran Administrador@!
        </div>
    </div>
    <div class="grid-menu">
        <a href="{{ route('admin.usuarios') }}" class="btn btn-cuadrado">
            <img src="{{ asset('https://cdn.pixabay.com/photo/2016/04/15/18/05/computer-1331579_1280.png') }}" alt="Usuarios">
            Usuarios
        </a>
        <a href="{{ route('admin.bonificaciones') }}" class="btn btn-cuadrado">
            <img src="{{ asset('https://cdn-icons-png.flaticon.com/512/2331/2331729.png') }}" alt="Bonificaciones">
            Bonificaciones
        </a>
        <a href="{{ route('admin.recoleccionesFinalizadasAdmin') }}" class="btn btn-cuadrado">
            <img src="{{ asset('https://cdn-icons-png.flaticon.com/512/8921/8921043.png') }}" alt="Reportes">
            Reportes
        </a>
        <a href="{{ route('admin.recolecciones.estadisticas') }}" class="btn btn-cuadrado">
            <img src="{{ asset('https://cdn-icons-png.freepik.com/256/3097/3097967.png?semt=ais_hybrid') }}" alt="Estadísticas">
            Estadísticas
        </a>
        <a href="{{ route('admin.materiales') }}" class="btn btn-cuadrado">
            <img src="{{ asset('https://cdn-icons-png.flaticon.com/512/8653/8653007.png') }}" alt="Materiales">
            Materiales
        </a>
    </div>
</div>
@endsection