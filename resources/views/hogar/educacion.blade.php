@extends('layouts.app')

@section('content')
<div class="container py-5">
<style>
    .video-container {
        position: relative;
        padding-bottom: 56.25%;
        height: 0;
        overflow: hidden;
        max-width: 100%;
        margin: 0 auto;
    }

    .video-container iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 80%;
        height: 80%;
        margin-left: 10%;
    }

    .header-title {
        font-size: 2.5rem;
        font-weight: bold;
        margin-bottom: 1rem;
    }

    .section-title {
        color: #28a745;
        font-weight: bold;
        font-size: 1.8rem;
    }

    .content-section {
        background-color: #f8f9fa;
        border-radius: 15px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        margin-bottom: 2rem;
    }

    .card img {
        height: 200px;
        object-fit: contain;
        padding: 1rem;
    }
</style>

<h2 class="header-title text-center">🌎 Educación Ambiental y Reciclaje: Camino hacia un Futuro Sostenible 🌿</h2>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

<!-- Introducción -->
<div class="card p-4 content-section">
    <h3 class="section-title">¿Qué es la Educación Ambiental?</h3>
    <p>
        La <strong>educación ambiental</strong> busca desarrollar una conciencia crítica sobre los problemas del medioambiente. No solo es informar, sino empoderar para actuar y cuidar los recursos naturales y la calidad de vida de todas las especies.
    </p>
    <p>
        Se promueve el respeto por la biodiversidad, el uso racional de los recursos y la participación ciudadana en iniciativas sostenibles.
    </p>
</div>

<!-- ¿Por qué es importante reciclar? -->
<div class="card p-4 content-section">
    <h3 class="section-title">¿Por qué es importante reciclar?</h3>
    <p>El reciclaje es un pilar fundamental en la lucha contra la contaminación y el cambio climático. Reciclar correctamente no solo ayuda a reducir el volumen de residuos, sino que también permite la reutilización de recursos valiosos, reduce la contaminación y ahorra energía.</p>
    <p>Datos impactantes sobre el reciclaje:</p>
    <ul>
        <li><strong>Más de 8 millones de toneladas de plástico</strong> terminan en los océanos cada año, afectando a miles de especies marinas.</li>
        <li>El reciclaje de 1 tonelada de papel ahorra <strong>17 árboles, 26,000 litros de agua</strong> y <strong>4000 kWh de energía</strong>.</li>
        <li><strong>El reciclaje de una lata de aluminio</strong> ahorra suficiente energía para mantener encendida una bombilla durante 4 horas.</li>
        <li>Si reciclamos el <strong>40% de los residuos sólidos</strong>, podemos reducir hasta un 20% las emisiones de gases de efecto invernadero.</li>
    </ul>
</div>

<!-- Tips para Reciclar -->
<div class="card p-4 content-section">
    <h3 class="section-title">Tips para Reciclar Correctamente</h3>
    <p>Reciclar es más que separar basura: ¡hazlo bien!</p>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <img src="https://cdn-icons-png.flaticon.com/512/2666/2666751.png" alt="Reciclaje de Plástico" />
                <div class="card-body">
                    <h5 class="card-title">Plásticos</h5>
                    <p>Lava y seca envases. No recicles plásticos sucios. Separa tapones y etiquetas.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <img src="https://cloud.educaplay.com/recursos/121/3895043/imagen_1_1533865399.png" alt="Papel y Cartón" />
                <div class="card-body">
                    <h5 class="card-title">Papel y Cartón</h5>
                    <p>Dobla cajas. No recicles papel mojado o sucio. El cartón encerado no es reciclable.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <img src="https://cdn.pixabay.com/photo/2012/04/28/19/14/recycle-44111_1280.png" alt="Vidrio" />
                <div class="card-body">
                    <h5 class="card-title">Vidrio</h5>
                    <p>Quita tapas y enjuaga. No mezcles con espejos o cerámica.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row pt-4">
        <div class="col-md-6">
            <div class="card">
                <img src="https://png.pngtree.com/png-clipart/20240731/original/pngtree-compost-materials-infographic-composition-png-image_15674444.png" alt="Compostaje" />
                <div class="card-body">
                    <h5 class="card-title">Compostaje</h5>
                    <p>Aprovecha cáscaras y restos de frutas para hacer compost. ¡Menos basura, más abono!</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <img src="https://cdni.iconscout.com/illustration/premium/thumb/reciclaje-de-residuos-e-4705611-3918153.png?f=webp" alt="Residuos Electrónicos" />
                <div class="card-body">
                    <h5 class="card-title">Residuos Electrónicos</h5>
                    <p>Lleva baterías, celulares y cables a puntos autorizados. ¡Nunca al bote común!</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bolsas de Colores -->
<div class="card p-4 content-section">
    <h3 class="section-title">¿Cómo usar las bolsas de colores?</h3>
    <p>¡Organiza tus residuos con las bolsas correctas!</p>
    <ul>
        <li><span style="color: green;">Verde</span>: residuos orgánicos (cáscaras, restos de comida, poda).</li>
        <li><span style="color: blue;">Azul</span>: reciclables limpios (papel, cartón, plástico, vidrio, metal).</li>
        <li><span style="color: gray;">Gris</span>: no reciclables (papeles sucios, servilletas usadas, colillas).</li>
        <li><span style="color: red;">Rojo</span>: residuos peligrosos (pilas, medicamentos, electrónicos).</li>
    </ul>
</div>

<!-- Recursos y Lecturas -->
<div class="card p-4 content-section">
    <h3 class="section-title">Recursos y Lecturas para Ampliar tu Conocimiento</h3>
    <p>Estos sitios te brindan información confiable, actualizada y recursos educativos sobre reciclaje, sostenibilidad y cuidado ambiental:</p>
    <ul>
        <li><a href="https://www.unenvironment.org/" target="_blank">Ministerio de Medio Ambiente - Normativas, guías y campañas educativas.</a></li>
        <li><a href="https://www.ecobot.com.co/" target="_blank">ECOBOT - Tecnología y reciclaje inteligente en Colombia.</a></li>
        <li><a href="https://www.fundacionbasuracero.org/" target="_blank">Fundación Basura Cero - Estrategias para reducir la generación de residuos.</a></li>
        <li><a href="https://redrecicladores.org/" target="_blank">Red de Recicladores - Apoyo al reciclaje social e inclusivo.</a></li>
    </ul>
</div>

<!-- Serie Educativa -->
<div class="card p-4 content-section">
    <h3 class="section-title">Serie: Todo sobre los residuos sólidos</h3>
    <p>Te recomendamos ver esta serie de videos que ilustra todo sobre el <strong>RECICLAJE</strong> y la <strong>GESTIÓN DE RESIDUOS</strong> para un mundo más sostenible.</p>
    <ul>
        <li><a href="https://www.youtube.com/playlist?list=PLqeDNXwyKf2o5muF0rYjWDBQlSH_6THTN" target="_blank">Ver en YouTube</a></li>
    </ul>
</div>

<!-- Video Educativo -->
<div class="card p-4 content-section">
    <h3 class="section-title text-center">Video: Contaminación del Mundo</h3>
    <p class="text-center">¡No te pierdas este video sobre la importancia de reciclar!</p>
    <div class="d-flex justify-content-center">
        <div class="ratio ratio-16x9" style="width: 80%;">
            <iframe src="https://www.youtube.com/embed/bR2X6sqsAiY" title="Contaminación del mundo" allowfullscreen></iframe>
        </div>
    </div>
</div>

<div class="card p-4 content-section">
    <div class="row">
        <div class="col-md-6">
            <h3 class="section-title">El Rol del Reciclador Informal</h3>
            <p>
                Los recicladores informales juegan un papel crucial en la gestión de residuos en muchas comunidades. A menudo, son ellos quienes realizan el trabajo más arduo de recolección, clasificación y venta de materiales reciclables. Sin su esfuerzo, gran parte de los materiales reciclables acabarían en vertederos, lo que aumenta la contaminación y desperdicia recursos valiosos.
            </p>
            <p>
                A pesar de su importancia, los recicladores informales enfrentan muchas dificultades, como la falta de reconocimiento, apoyo institucional y condiciones de trabajo precarias. Por lo tanto, es fundamental ofrecerles el respaldo necesario para mejorar su calidad de vida y fortalecer el sistema de reciclaje en general.
            </p>
            <p>
                Integrarlos en un sistema de reciclaje formal puede proporcionarles acceso a recursos, formación y mejores condiciones laborales, mientras que optimiza la gestión de residuos a nivel comunitario.
            </p>

            <!-- Mensaje destacado debajo del reciclador informal -->
            <div class="text-left my-4">
                <h2 class="text-success" style="font-size: 2.5rem; font-weight: bold;">
                    ¡Ayúdalos a Ellos y al Ambiente! <br> <span style="font-size: 3rem;">Ecolink</span>
                </h2>
                <p class="text-success" style="font-size: 1.2rem;">
                    Juntos podemos hacer la diferencia. Recicla, apoya a los recicladores informales y contribuye a un futuro más sostenible.
                </p>
            </div>
        </div>

        <div class="col-md-6">
            <h3 class="section-title text-center">Video en TikTok</h3>
            <div class="d-flex justify-content-center">
                <blockquote class="tiktok-embed" cite="https://www.tiktok.com/@mov_sentido/video/7486663935710612741" data-video-id="7486663935710612741" style="max-width: 605px;min-width: 325px;">
                    <section></section>
                </blockquote>
            </div>
            <script async src="https://www.tiktok.com/embed.js"></script>
        </div>
    </div>
</div>



<!-- Botones -->
<div class="text-center my-5">
    <a href="{{ route('hogar.solicitudes.create') }}" class="btn btn-success btn-lg">
        🌿 ¡Haz tu parte! Solicita una recolección ecológica
    </a>
</div>
<div class="text-center mt-3">
    <a href="{{ route('hogar.home') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Volver
    </a>
</div>
</div>
@endsection
