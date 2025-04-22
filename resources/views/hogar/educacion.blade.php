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
</style>
    <h2 class="header-title text-center">Educación Ambiental y Reciclaje: Camino hacia un Futuro Sostenible</h2>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <!-- Introducción -->
    <div class="card p-4 content-section">
        <h3 class="section-title">¿Qué es la Educación Ambiental?</h3>
        <p>
            La <strong>educación ambiental</strong> es un proceso formativo que busca desarrollar una conciencia crítica y activa sobre la problemática ambiental. Su propósito no es solo informar, sino también empoderar a las personas para que actúen de forma responsable, con decisiones que favorezcan la conservación de los recursos naturales y la calidad de vida de todas las especies del planeta.
        </p>
        <p>
            A través de este enfoque educativo, se promueve el respeto por la biodiversidad, el uso racional de los recursos y la participación ciudadana en iniciativas sostenibles. Es una herramienta clave para lograr una sociedad más justa, resiliente y comprometida con su entorno.
        </p>
    </div>

    <p></p>

    <!-- Importancia de la Educación Ambiental -->
    <div class="card p-4 content-section">
        <h3 class="section-title">¿Por qué es importante la Educación Ambiental?</h3>
        <p>
            La <strong>educación ambiental</strong> es esencial en la lucha contra el cambio climático y la degradación ambiental. Nos permite:
        </p>
        <ul>
            <li>Desarrollar una cultura ambiental basada en el respeto, la prevención y la corresponsabilidad.</li>
            <li>Adoptar hábitos de vida sostenibles, tanto en el hogar como en el trabajo.</li>
            <li>Fomentar la participación ciudadana en proyectos de reciclaje, reforestación y ahorro energético.</li>
            <li>Entender la interdependencia entre seres humanos, naturaleza y economía.</li>
        </ul>
    </div>

    <p></p>

    <!-- Consejos Prácticos para Reciclar -->
    <div class="card p-4 content-section">
        <h3 class="section-title">Tips para Reciclar Correctamente</h3>
        <p>Reciclar es más que separar residuos. Aquí te dejamos una guía práctica para que mejores tus hábitos:</p>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <img src="https://cdn-icons-png.flaticon.com/512/2666/2666751.png" alt="Reciclaje de Plástico" />
                    <div class="card-body">
                        <h5 class="card-title">Plásticos</h5>
                        <p class="card-text">
                            Lava y seca los envases antes de desecharlos. Evita reciclar plásticos contaminados con restos de comida. Separa tapones y etiquetas si es posible.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="https://cloud.educaplay.com/recursos/121/3895043/imagen_1_1533865399.png" alt="Reciclaje de Papel y Cartón" />
                    <div class="card-body">
                        <h5 class="card-title">Papel y Cartón</h5>
                        <p class="card-text">
                            Dobla y aplana las cajas para ahorrar espacio. No recicles papel húmedo o sucio (como servilletas usadas). El cartón encerado no es reciclable.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="https://cdn.pixabay.com/photo/2012/04/28/19/14/recycle-44111_1280.png" alt="Reciclaje de Vidrio" />
                    <div class="card-body">
                        <h5 class="card-title">Vidrio</h5>
                        <p class="card-text">
                            El vidrio se recicla infinitamente. Evita mezclarlo con cerámica o espejos. Quita tapas metálicas y enjuaga antes de depositarlo.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <p></p>

        <div class="row pt-4">
            <div class="col-md-6">
                <div class="card">
                    <img src="https://png.pngtree.com/png-clipart/20240731/original/pngtree-compost-materials-infographic-composition-png-image_15674444.png" alt="Residuos Orgánicos" />
                    <div class="card-body">
                        <h5 class="card-title">Compostaje</h5>
                        <p class="card-text">
                            Aprovecha los residuos orgánicos (cáscaras, restos de frutas, hojas) para hacer compost. Esto reduce la cantidad de basura y nutre el suelo.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <img src="https://cdni.iconscout.com/illustration/premium/thumb/reciclaje-de-residuos-e-4705611-3918153.png?f=webp" alt="Residuos Electrónicos" />
                    <div class="card-body">
                        <h5 class="card-title">Residuos Electrónicos</h5>
                        <p class="card-text">
                            Los aparatos electrónicos contienen materiales tóxicos. Lleva tus celulares, baterías y cables a puntos de recolección autorizados.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <p></p>

    <!-- Recursos Recomendados -->
    <div class="card p-4 content-section">
        <h3 class="section-title">Recursos y Lecturas para Ampliar tu Conocimiento</h3>
        <p>Estos sitios te brindan información confiable, actualizada y recursos educativos sobre reciclaje, sostenibilidad y cuidado ambiental:</p>
        <ul>
            <li><a href="https://www.unenvironment.org/" target="_blank">Ministerio de Medio Ambiente</a> - Normativas, guías y campañas educativas.</li>
            <li><a href="https://www.wwf.org/" target="_blank">ECOBOT</a> - Tecnología y reciclaje inteligente en Colombia.</li>
            <li><a href="https://www.greenpeace.org/international/" target="_blank">Fundación Basura Cero</a> - Estrategias para reducir la generación de residuos.</li>
            <li><a href="https://www.nationalgeographic.com/environment/" target="_blank">Red de Recicladores</a> - Apoyo al reciclaje social e inclusivo.</li>
        </ul>
    </div>

    <p></p>

    <!-- Serie Educativa -->
    <div class="card p-4 content-section">
        <h3 class="section-title">Serie: Todo sobre los residuos solidos </h3>
        <p>Te recomendamos ver esta serie de videos que ilustra todo sobre el RECICLAJE y la GESTIÓN DE RESIDUOS para un mundo más sostenible.
        <ul>
            <li><a href="https://www.youtube.com/playlist?list=PLqeDNXwyKf2o5muF0rYjWDBQlSH_6THTN" target="_blank">Todo sobre los residuos solidos</a></li>
        </ul>
    </div>
    
    <!-- Video Educativo -->
    <div class="card p-4 content-section">
        <h3 class="section-title text-center">Video: Contaminación del mundo</h3>
        <p class="text-center">Te recomendamos ver este video para que veas la importancia de reciclar:</p>
        <div class="d-flex justify-content-center">
            <div class="ratio ratio-16x9" style="width: 80%;">
                <iframe src="https://www.youtube.com/embed/bR2X6sqsAiY" title="Video de Contaminación del mundo" allowfullscreen></iframe>
            </div>
        </div>
    </div>
    <!-- Llamado a la acción -->
    <div class="text-center my-5">
        <a href="{{ route('hogar.solicitudes.create') }}" class="btn btn-success btn-lg">
            ¡Haz tu parte! Solicita una recolección ecológica
        </a>
    </div>
    <div class="text-center mt-3">
        <a href="{{ route('hogar.home') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>
</div>
@endsection