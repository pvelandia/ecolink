@extends('layouts.app')

@section('content')
@php
    use Carbon\Carbon;
@endphp
<style>
    .estadisticas-reciclaje {
        background-color: #f1f1f1;
        padding: 2rem; /* Aumentar el padding */
        border-radius: 1rem;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        text-align: center;
        width: 100%; /* Asegurarse de que ocupe el ancho completo */
        max-width: 400px; /* Limitar el ancho máximo */
        margin: 1rem; /* Espaciado entre tarjetas */
    }

    .grafico-card {
        background: #ffffff;
        border-radius: 1rem;
        padding: 2rem; /* Aumentar el padding */
        box-shadow: 0 10px 20px rgba(0,0,0,0.15);
        text-align: center;
        margin: 1rem; /* Espaciado entre tarjetas */
    }

    .card-estadistica {
        background: #ffffff;
        border-radius: 1rem;
        padding: 2rem; /* Aumentar el padding */
        width: 100%; /* Asegurarse de que ocupe el ancho completo */
        max-width: 400px; /* Limitar el ancho máximo */
        box-shadow: 0 10px 20px rgba(0,0,0,0.15);
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        margin: 1rem; /* Espaciado entre tarjetas */
    }

    .card-estadistica:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.2);
    }

    .card-estadistica h4 {
        font-size: 1.6rem; /* Aumentar el tamaño de fuente */
        color: #03A63C;
        margin-bottom: 0.5rem;
    }

    .card-estadistica p {
        font-size: 1.4rem; /* Aumentar el tamaño de fuente */
        margin: 0;
    }
</style>
<div class="container py-5">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <h2 class="text-center mb-4 fw-bold">Recolecciones Finalizadas</h2>

    @if($recolecciones->isEmpty())
        <div class="alert alert-info text-center shadow rounded-3">
            <i class="bi bi-info-circle"></i> No hay recolecciones finalizadas.
        </div>
    @else
        <div class="table-responsive rounded shadow" style="max-height: 600px; overflow-y: auto;">
            <table class="table table-hover table-bordered align-middle text-center">
                <thead class="table-success sticky-top">
                    <tr>
                        <th>Fecha de Recolección</th>
                        <th>Reciclador</th>
                        <th>Materiales</th>
                        <th>Calificación</th>
                        <th>Puntos</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recolecciones->take(20) as $recoleccion)
                    <tr>
                        <td class="text-nowrap">
                            {{ Carbon::parse($recoleccion->assignment_date)->translatedFormat('d \d\e F \d\e Y - h:i A') }}
                        </td>
                        <td>
                            {{ $recoleccion->reciclador->first_name }} {{ $recoleccion->reciclador->last_name }}
                        </td>
                        <td class="text-center">
                            <ul class="list-unstyled mb-0">
                                @foreach($recoleccion->materials as $material)
                                    <li> {{ $material->name }} {{ $material->pivot->quantity }} kg</li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="text-center">
                            @if($recoleccion->rating)
                                @for ($i = 1; $i <= 5; $i++)
                                    @if($i <= $recoleccion->rating)
                                        <span style="color: gold;">★</span>
                                    @endif
                                @endfor
                            @else
                                <span class="text-muted">No calificado</span>
                            @endif
                        </td>
                        <td class ="text-center">
                            {{ ($recoleccion->points ?? 0) > 0 ? $recoleccion->points : 'No asignados' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <!-- Sección de estadísticas de reciclaje -->
    <hr class="my-5">
    <h2 class="text-center mb-4" style="color: #03A63C; font-weight: bold;">Estadísticas de tu Reciclaje</h2>

    <!-- Tarjetas de estadísticas -->
    <div class="row mb-5 justify-content-center" style="gap: 1rem; display: flex; flex-wrap: wrap;">
        <div class="card-estadistica">
            <h4>¡Este es el peso total que has reciclado!</h4>
            <p><strong>{{ $totalKgReciclados ?? 'No disponible' }} kg</strong></p>
            <img src="{{ asset('https://cdni.iconscout.com/illustration/premium/thumb/contenedor-de-basura-3316363-2784928.png?f=webp') }}" alt="Árbol salvado" style="width: 50px; height: 50px; margin-top: 0.5rem;">
        </div>

        <div class="card-estadistica">
            <h4>¡Gracias a tu participación, has salvado estos árboles!</h4>
            <p><strong>{{ $arbolesSalvados }}</strong></p>
            <img src="{{ asset('https://cdn-icons-png.flaticon.com/128/8608/8608169.png') }}" alt="Árbol salvado" style="width: 50px; height: 50px; margin-top: 0.5rem;">
        </div>
    </div>

    <!-- Gráfico de barras de materiales reciclados -->
    <div class="grafico-card mb-5">
        <canvas id="graficoMateriales"></canvas>
    </div>

    <div class="text-center mt-3">
        <a href="{{ route('hogar.home') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>
</div>

<script>
    const materiales = @json($materialesReciclados->pluck('material'));
    const datosKg = @json($materialesReciclados->pluck('total_kg'));

    // Generar colores más vivos (puedes ajustar los rangos si lo deseas)
    const coloresVivos = materiales.map(() => {
        const r = Math.floor(Math.random() * 156) + 100; // Rango más alto para colores vivos
        const g = Math.floor(Math.random() * 156) + 100;
        const b = Math.floor(Math.random() * 156) + 100;
        return `rgba(${r}, ${g}, ${b}, 0.8)`; // Más saturación y un poco más de opacidad
    });

    const ctx = document.getElementById('graficoMateriales').getContext('2d');
    const graficoMateriales = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: materiales,
            datasets: [{
                label: 'Kilogramos Reciclados', // Modificamos la etiqueta principal
                data: datosKg,
                backgroundColor: coloresVivos,
                borderColor: coloresVivos.map(c => c.replace('0.8', '1')), // Borde opaco
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
                        text: 'Kilogramos (kg)', // Etiqueta para el eje Y
                        align: 'end' // Alineación a la derecha
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Materiales Reciclados', // Etiqueta para el eje X
                        position: 'bottom' // La leyenda de los labels estará abajo por defecto
                    }
                }
            },
            plugins: {
                legend: {
                    display: false, // Ocultamos la leyenda superior predeterminada
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                label += new Intl.NumberFormat('es-CO').format(context.parsed.y) + ' kg'; // Formato con separador de miles
                            }
                            return label;
                        }
                    }
                }
            }
        }
    });
</script>
@endsection