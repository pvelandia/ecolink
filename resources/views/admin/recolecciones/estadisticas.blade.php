@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center my-4" style="color: white;">📈 Estadísticas de Recolecciones</h2>

    <div class="charts-wrapper">
        <div class="chart-container">
            <h4>Total de Recolecciones por Reciclador</h4>
            <canvas id="totalChart"></canvas>
        </div>

        <div class="chart-container">
            <h4>Comparativa por Estado</h4>
            <canvas id="estadoChart"></canvas>
        </div>
    </div>

    <div class="container mt-4">
        <h4 class="text-center" style="color: white;">Resumen de Recolecciones por Mes</h4>
        <table class="table table-bordered">
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
                label: 'Total',
                data: totalData,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: { responsive: true }
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
                    backgroundColor: 'rgba(255, 206, 86, 0.2)',
                    borderColor: 'rgba(255, 206, 86, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Aprobadas',
                    data: estadoData.Aprobadas,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Finalizadas',
                    data: estadoData.Finalizadas,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: { responsive: true }
    });
</script>
@endsection
