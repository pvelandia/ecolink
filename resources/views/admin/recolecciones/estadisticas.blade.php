@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #e6f5e5;
    }
    h2, h4 {
        color: #025939;
    }
    .charts-wrapper {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 2rem;
        margin-top: 2rem;
    }
    .chart-container {
        background: white;
        padding: 1rem;
        border-radius: 1rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .table-card {
        background: white;
        border-radius: 1rem;
        padding: 2rem;
        box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        margin: 3rem auto 2rem;
        width: 100%;
        max-width: 800px;
    }
    th {
        background-color: #025939;
        color: white;
    }
</style>

<div class="container">
    <h2 class="text-center my-4">Estadísticas de Recolecciones</h2>
    <form method="GET" action="{{ route('admin.recolecciones.estadisticas') }}" class="mb-4 p-4 bg-gray-100 rounded-xl">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            {{-- Campos del formulario... --}}
        </div>

        <div class="mt-4 text-right">
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Filtrar</button>
            <a href="{{ route('admin.recolecciones.estadisticas') }}" class="ml-2 text-gray-600 underline">Restablecer</a>
        </div>
    </form>
    <div class="charts-wrapper">
        <div class="chart-container">
            <h4 class="text-center">Total de Recolecciones por Reciclador</h4>
            <canvas id="totalChart"></canvas>
        </div>

        <div class="chart-container">
            <h4 class="text-center">Comparativa por Estado</h4>
            <canvas id="estadoChart"></canvas>
        </div>

        <div class="chart-container">
            <h4 class="text-center">Kg Recolectados por Semana</h4>
            <canvas id="semanaKgChart"></canvas>
        </div>

        <div class="chart-container">
            <h4 class="text-center">Kg Recolectados por Mes</h4>
            <canvas id="mesKgChart"></canvas>
        </div>

        <div class="chart-container">
            <h4 class="text-center">Recolecciones por Calificación</h4>
            <canvas id="calificacionChart"></canvas>
        </div>
    </div>

    <div class="table-card">
        <h4 class="text-center mb-4">Resumen de Recolecciones por Mes</h4>
        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th>Mes</th>
                    <th>Total Recolecciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($porMes as $mes)
                    <tr>
                        <td>{{ $mes->mes }}</td>
                        <td>{{ $mes->total }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // 📊 Total de Recolecciones por Reciclador
    const labels = {!! json_encode($recicladorNames) !!};
    const totalData = {!! json_encode($totalRecolecciones) !!};

    new Chart(document.getElementById('totalChart'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Total de Recolecciones',
                data: totalData,
                backgroundColor: 'rgba(2, 89, 57, 0.4)',
                borderColor: 'rgba(2, 89, 57, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    precision: 0
                }
            }
        }
    });

    // 📊 Comparativa por Estado
    const estadoData = {
        Pendientes: [],
        Aprobadas: [],
        Finalizadas: []
    };

    @foreach($estados as $e)
        @if($e->state_id == 1)
            estadoData.Pendientes.push({{ $e->total }});
        @elseif($e->state_id == 3)
            estadoData.Aprobadas.push({{ $e->total }});
        @elseif($e->state_id == 4)
            estadoData.Finalizadas.push({{ $e->total }});
        @endif
    @endforeach

    new Chart(document.getElementById('estadoChart'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Pendientes',
                    data: estadoData.Pendientes,
                    backgroundColor: 'rgba(255, 206, 86, 0.5)',
                    borderColor: 'rgba(255, 206, 86, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Aprobadas',
                    data: estadoData.Aprobadas,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Finalizadas',
                    data: estadoData.Finalizadas,
                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    precision: 0
                }
            }
        }
    });

    // 📈 Kg recolectados por Semana
    const semanaLabels = {!! json_encode($porSemanaKg->pluck('semana')) !!};
    const semanaData = {!! json_encode($porSemanaKg->pluck('total_kg')) !!};

    new Chart(document.getElementById('semanaKgChart'), {
        type: 'line',
        data: {
            labels: semanaLabels,
            datasets: [{
                label: 'Kg Recolectados',
                data: semanaData,
                fill: false,
                borderColor: '#025939',
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Kg'
                    }
                }
            }
        }
    });

    // 📊 Kg recolectados por Mes
    const mesKgLabels = {!! json_encode($porMesKg->pluck('mes')) !!};
    const mesKgData = {!! json_encode($porMesKg->pluck('total_kg')) !!};

    new Chart(document.getElementById('mesKgChart'), {
        type: 'bar',
        data: {
            labels: mesKgLabels,
            datasets: [{
                label: 'Kg Recolectados',
                data: mesKgData,
                backgroundColor: 'rgba(2, 89, 57, 0.4)',
                borderColor: 'rgba(2, 89, 57, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Kg'
                    }
                }
            }
        }
    });

    // 🍩 Recolecciones por Calificación
    const calificacionLabels = {!! json_encode($porCalificacion->pluck('rating')) !!};
    const calificacionData = {!! json_encode($porCalificacion->pluck('total')) !!};

    new Chart(document.getElementById('calificacionChart'), {
        type: 'doughnut',
        data: {
            labels: calificacionLabels,
            datasets: [{
                label: 'Cantidad',
                data: calificacionData,
                backgroundColor: ['#FFD700', '#C0C0C0', '#CD7F32', '#87CEFA', '#90EE90'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true
        }
    });
</script>
@endsection