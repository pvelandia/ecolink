@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="text-left">Estadísticas de Recolecciones</h1>
        <div>
            <a href="{{ route('admin.menu') }}" class="btn btn-secondary btn-sm">Volver</a>
            <button id="download-pdf" class="btn btn-success btn-sm">Descargar PDF</button>
        </div>
    </div>
    <div class="container">
        <div class="bg-white p-3 rounded shadow-sm" id="pdf-content" style="max-width: 1100px; margin: 0 auto;">
            <div class="mb-4 text-left">
                <h2>Reporte de Recolecciones</h2>
                <p>Generado el {{ now()->format('d/m/Y') }}</p>
            </div>

            <div class="text-left mb-4">
                <p>
                    En este reporte se presentan los resultados obtenidos de las estadísticas de las recolecciones realizadas durante las últimas semanas y meses. El análisis de los datos nos permite comprender mejor el desempeño del sistema de recolección y el impacto de nuestras acciones en la gestión de residuos reciclables.
                </p>

                <p>
                    En cuanto a la recolección de materiales, se observa que las semanas con mayor volumen de residuos reciclados corresponden a las semanas {{ implode(', ', $porSemanaKg->pluck('semana')->toArray()) }}. Durante estos períodos, el peso de los materiales recolectados alcanzó un total de {{ implode(', ', $porSemanaKg->pluck('total_kg')->toArray()) }} kg por semana. Este comportamiento resalta la importancia de un seguimiento más riguroso durante las semanas de mayor volumen.
                </p>

                <p>
                    En relación con los estados de las recolecciones, se destaca que el porcentaje de recolecciones aprobadas ha sido alto, con un total de {{ $porEstado->where('name', 'aprobado')->sum('total') }} recolecciones aprobadas, lo que demuestra un eficiente proceso de validación de las solicitudes. Además, el estado pendiente se mantiene bajo, con solo {{ $porEstado->where('name', 'pendiente')->sum('total') }} recolecciones pendientes.
                </p>

                <p>
                    En cuanto a las calificaciones, la mayoría de las recolecciones fueron calificadas con {{ $porCalificacion->where('rating', 5)->sum('total') }} estrellas, lo que refleja una excelente satisfacción por parte de los usuarios. El sistema de recolección está funcionando de manera efectiva, y las recomendaciones para mejorar incluyen el fortalecimiento de las áreas con menor puntaje.
                </p>

                <p>
                    A continuación, se presentan los gráficos con los detalles de las recolecciones, el volumen de material recolectado, el estado de las recolecciones y las calificaciones de los usuarios.
                </p>
            </div>
 <br>
            <!-- Gráfico Material (Kg por semana) y Estado de Recolección -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5>Material (Kg por semana)</h5>
                    <div class="chart-container" style="height: 300px;"> <!-- Gráfico más pequeño -->
                        <canvas id="materialSemanaChart"></canvas>
                    </div>
                </div>
                <div class="row mb-4">
                <div class="col-md-6">
                    <h5>Estados de Recolección</h5>
                    <div class="chart-container" style="height: 300px;"> <!-- Gráfico más pequeño -->
                        <canvas id="estadoChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Gráfico Material (Kg por mes) y Calificaciones -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5>Material (Kg por mes)</h5>
                    <div class="chart-container" style="height: 300px;"> <!-- Gráfico más pequeño -->
                        <canvas id="materialMesChart"></canvas>
                    </div>
                </div>
                <div class="row mb-4">
                <div class="col-md-6">
                    <h5>Calificaciones</h5>
                    <div class="chart-container" style="height: 230px;"> <!-- Gráfico más pequeño -->
                        <canvas id="calificacionChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Gráfico Recolecciones por mes -->
            <div class="mb-4">
                <h5>Recolecciones por mes</h5>
                <div class="chart-container" style="height: 300px; width: 500px;">
                <canvas id="recoleccionesMesChart"></canvas>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// Datos para los gráficos, pasando de la base de datos a los gráficos.
const porSemanaKg = @json($porSemanaKg);
const porMesKg = @json($porMesKg);
const porMes = @json($porMes);
const porCalificacion = @json($porCalificacion);
const porEstado = @json($porEstado);

// Función para asegurarse de que los gráficos estén cargados
window.onload = function () {
    // Gráfico Material (Kg por semana)
    new Chart(document.getElementById('materialSemanaChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: porSemanaKg.map(item => `Semana ${item.semana}`),
            datasets: [{
                label: 'Kg/semana',
                data: porSemanaKg.map(item => item.total_kg),
                backgroundColor: '#4CAF50'
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });

    // Gráfico Estados de Recolección
    new Chart(document.getElementById('estadoChart').getContext('2d'), {
        type: 'pie',
        data: {
            labels: porEstado.map(item => item.name),
            datasets: [{
                data: porEstado.map(item => item.total),
                backgroundColor: ['#66BB6A', '#FFCA28', '#EF5350'],
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                datalabels: {
                    formatter: (value, context) => {
                        let total = 0;
                        context.chart.data.datasets[0].data.forEach((data) => {
                            total += data;
                        });
                        let percentage = (value / total * 100).toFixed(1) + '%';
                        return percentage;
                    },
                    color: '#fff',
                    font: {
                        weight: 'bold',
                        size: 16
                    },
                    anchor: 'center',
                    align: 'center'
                }
            }
        }
    });

    // Gráfico Material (Kg por mes)
    new Chart(document.getElementById('materialMesChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: porMesKg.map(item => item.mes),
            datasets: [{
                label: 'Kg/mes',
                data: porMesKg.map(item => item.total_kg),
                backgroundColor: '#2196F3'
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });

    // Gráfico Calificaciones
    new Chart(document.getElementById('calificacionChart').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: porCalificacion.map(item => `${item.rating}`),
            datasets: [{
                data: porCalificacion.map(item => item.total),
                backgroundColor: ['#FFD700', '#C0C0C0', '#CD7F32']
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });

    // Gráfico Recolecciones por mes
    new Chart(document.getElementById('recoleccionesMesChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: porMes.map(item => item.mes),
            datasets: [{
                label: 'Recolecciones',
                data: porMes.map(item => item.total),
                borderColor: '#FFCA28',
                backgroundColor: 'rgba(255, 202, 40, 0.2)',
                fill: true
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });
};

document.getElementById('download-pdf').addEventListener('click', function() {
    const element = document.getElementById('pdf-content');

    // Asegurarse de que los gráficos se hayan cargado antes de generar el PDF
    Promise.all(
        Array.from(document.querySelectorAll('canvas')).map(canvas => {
            return new Promise(resolve => {
                if (canvas) {
                    const chart = Chart.getChart(canvas);
                    if (chart) chart.update();
                }
                resolve();
            });
        })
    ).then(() => {
        const opt = {
            margin: 1,
            filename: 'reporte_recolecciones.pdf',
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'in', format: 'letter', orientation: 'landscape' }
        };
        html2pdf().from(element).set(opt).save();
    });
});
</script>
@endsection
