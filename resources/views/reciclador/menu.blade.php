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

    .btn-cuadrado img {
        width: 48px;
        height: 48px;
        object-fit: contain;
        margin-bottom: 0.5rem;
    }

    .banner {
        font-size: 1.8rem;
        font-weight: bold;
        color: #333;
        text-align: center;
        margin-bottom: 2rem;
        text-transform: uppercase;
    }

    .chart-container {
        margin-top: 1.5rem;
        padding: 15px;
        background-color: #f9f9f9;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    /* Ajustes del canvas para hacerlo más pequeño */
    .chart-container canvas {
        width: 100% !important;
        height: 300px !important;
        max-height: 300px;
    }

    /* Responsiveness */
    @media (max-width: 768px) {
        .chart-container {
            margin-top: 1rem;
        }
    }
</style>
<div class="container mt-4">
    <div class="banner">
        <h1 style="border: 2px solid green; padding: 10px; border-radius: 5px; display: inline-block;">
            Bienvenid@ {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
        </h1>
        <div style="font-size: 0.8em; margin-top: 5px; color: #555;">
            ¡Eres un@ gran Recolector@!
        </div>
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

    <!-- Calificación promedio -->
    <div class="mt-4 mb-4">
        <h4>Calificación Promedio de Recolecciones: <strong>{{ number_format($calificacionPromedio->promedio, 2) }}</strong></h4>
    </div>

    <!-- Gráficos -->
    <div class="row">
        <!-- Gráfico de recolecciones por mes -->
        <div class="col-md-6">
            <div class="chart-container">
                <h5>Recolecciones por Mes</h5>
                <canvas id="recoleccionesPorMesChart"></canvas>
            </div>
        </div>

        <!-- Gráfico de kilogramos por material -->
        <div class="col-md-6">
            <div class="chart-container">
                <h5>Kilogramos por Material</h5>
                <canvas id="materialesRecolectadosChart"></canvas>
            </div>
        </div>
    </div>
    </br>
</br>
    <div class="mt-10 text-center">
        <h2 class="text-xl font-semibold text-red-700 mb-2">¿Tienes algún inconveniente?</h2>
        <p class="text-gray-700 mb-4">Si deseas reportar un problema con la plataforma o con un usuario, por favor comunícate con el administrador:</p>

        <div class="space-y-2 mt-6 bg-black text-white p-6 rounded-lg shadow-lg">
            <a href="tel:+573222889715" class="inline-block px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-green-700 transition no-underline">
                📞 +57 322 2889715
            </a>
            <br>
            <a href="mailto:ecolink.reciclaje.25@gmail.com" class="inline-block px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition no-underline">
                📧 ecolink.reciclaje.25@gmail.com
            </a>
        </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Gráfico de Recolecciones por Mes
    var ctx1 = document.getElementById('recoleccionesPorMesChart').getContext('2d');
    var recoleccionesPorMesChart = new Chart(ctx1, {
        type: 'line',
        data: {
            labels: @json($recoleccionesPorMes->pluck('mes')),
            datasets: [{
                label: 'Cantidad de Recolecciones',
                data: @json($recoleccionesPorMes->pluck('cantidad')),
                borderColor: 'rgba(54, 162, 235, 1)',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                fill: true,
                tension: 0.3
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

    // Gráfico de Kilogramos por Material
    var ctx2 = document.getElementById('materialesRecolectadosChart').getContext('2d');
    var materialesRecolectadosChart = new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: @json($materialesRecolectados->pluck('name')),
            datasets: [{
                label: 'Kilogramos Recolectados',
                data: @json($materialesRecolectados->pluck('total_kg')),
                backgroundColor: 'rgba(75, 192, 192, 0.5)',
                borderColor: 'rgba(75, 192, 192, 1)',
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
