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
        display: flex;
        justify-content: space-around;
        flex-wrap: wrap;
        margin-top: 20px;
    }
    .chart-container {
        width: 100%;
        max-width: 500px;
        margin: 1rem auto;
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
        margin-top: 2rem;
        width: 100%;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }
    th {
        background-color: #025939;
        color: white;
    }
</style>

<div class="container">
    <h2 class="text-center my-4">Estadísticas de Recolecciones</h2>

    <div class="charts-wrapper">
        <div class="chart-container">
            <h4 class="text-center">Total de Recolecciones por Reciclador</h4>
            <canvas id="totalChart"></canvas>
        </div>

        <div class="chart-container">
            <h4 class="text-center">Comparativa por Estado</h4>
            <canvas id="estadoChart"></canvas>
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
</script>
@endsection