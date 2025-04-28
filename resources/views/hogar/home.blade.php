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

    /* Estilo para el bloque de estadísticas */
    .estadisticas-reciclaje {
        background-color: #f1f1f1;
        padding: 1rem;
        border-radius: 1rem;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        text-align: center;
    }
    .estadisticas-reciclaje h4 {
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
    }
    .estadisticas-reciclaje p {
        font-size: 1.2rem;
    }

    .tabla-materiales {
        margin-top: 2rem;
        width: 100%;
        border-collapse: collapse;
    }
    .tabla-materiales th, .tabla-materiales td {
        padding: 0.8rem;
        text-align: center;
        border: 1px solid #ddd;
    }
    .tabla-materiales th {
        background-color: #03A63C;
        color: white;
    }
</style>

<div class="container mt-4">
    <div class="banner">
        <h1 style="font-size: 2.3em; margin-top: 0; margin-bottom: 0;">Bienvenid@ {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}, este es tu menú🏠</h1>
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
    <!-- Sección de estadísticas de reciclaje -->
    <div class="estadisticas-reciclaje mb-4">
        <h4>Estadísticas de Reciclaje</h4>
        <p>Total reciclado: <strong>{{ $totalKgReciclados }} kg</strong></p>
        <p>Árboles salvados: <strong>{{ $arbolesSalvados }}</strong></p>
    </div>

    <!-- Gráfico de materiales reciclados -->
    <div class="mb-4">
        <canvas id="graficoMateriales"></canvas>
    </div>

    <!-- Tabla de materiales reciclados -->
    <table class="tabla-materiales">
        <thead>
            <tr>
                <th>Material</th>
                <th>Total Reciclado (kg)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($materialesReciclados as $material)
                <tr>
                    <td>{{ $material->material }}</td>
                    <td>{{ $material->total_kg }} kg</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>

<script>
    var ctx = document.getElementById('graficoMateriales').getContext('2d');
    var graficoMateriales = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($materialesReciclados->pluck('material')), // Nombres de los materiales
            datasets: [{
                label: 'Materiales Reciclados (kg)',
                data: @json($materialesReciclados->pluck('total_kg')), // Cantidad reciclada de cada material
                backgroundColor: 'rgba(0, 123, 255, 0.6)',
                borderColor: 'rgba(0, 123, 255, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

@endsection
