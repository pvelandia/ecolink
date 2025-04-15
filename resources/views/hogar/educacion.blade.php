@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <h2 class="header-title text-center">Educación Ambiental: Conciencia y Acción</h2>

        <!-- Introducción -->
        <div class="card p-4 content-section">
            <h3 class="section-title">¿Qué es la Educación Ambiental?</h3>
            <p>
                La **Educación Ambiental** busca promover la comprensión y conciencia sobre los problemas ambientales y las soluciones que podemos adoptar como individuos y como sociedad. El objetivo principal es incentivar una actitud proactiva hacia el medio ambiente, tomando decisiones responsables y sostenibles que garanticen un futuro más verde para todos.
            </p>
            <p>
                Nos enseña a tomar conciencia de la **importancia de la conservación de recursos naturales**, la biodiversidad, y cómo nuestras acciones cotidianas impactan el planeta.
            </p>
        </div>

        <!-- Importancia de la Educación Ambiental -->
        <div class="card p-4 content-section">
            <h3 class="section-title">¿Por qué es importante la Educación Ambiental?</h3>
            <p>
                La **educación ambiental** juega un papel clave en el desarrollo sostenible. Nos ayuda a:
            </p>
            <ul>
                <li><span class="text-highlight">Promover la sostenibilidad</span> en todos los aspectos de la vida.</li>
                <li><span class="text-highlight">Reducir la huella de carbono</span> mediante prácticas responsables como el reciclaje y la conservación de energía.</li>
                <li><span class="text-highlight">Proteger nuestros ecosistemas</span> naturales y biodiversidad.</li>
                <li><span class="text-highlight">Formar ciudadanos conscientes</span> que tomen decisiones informadas para el bienestar del planeta.</li>
            </ul>
        </div>

        <!-- Consejos Prácticos -->
        <div class="card p-4 content-section">
            <h3 class="section-title">Consejos para una Vida Más Sostenible</h3>
            <p>La sostenibilidad no se logra solo a nivel global, sino también con pequeños cambios a nivel individual. Aquí te dejamos algunos consejos prácticos:</p>
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <img src="https://via.placeholder.com/400x300" alt="Reciclaje" />
                        <div class="card-body">
                            <h5 class="card-title">Recicla</h5>
                            <p class="card-text">Separa los materiales reciclables y asegúrate de depositarlos en los contenedores adecuados.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <img src="https://via.placeholder.com/400x300" alt="Uso eficiente del agua" />
                        <div class="card-body">
                            <h5 class="card-title">Conserva el Agua</h5>
                            <p class="card-text">Reducir el consumo de agua es vital para conservar este recurso natural esencial.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <img src="https://via.placeholder.com/400x300" alt="Energía Renovable" />
                        <div class="card-body">
                            <h5 class="card-title">Usa Energía Renovable</h5>
                            <p class="card-text">Opta por fuentes de energía renovables y reduce el uso de combustibles fósiles.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recursos -->
        <div class="card p-4 content-section">
            <h3 class="section-title">Recursos y Lecturas Recomendadas</h3>
            <p>Para profundizar en el tema de la educación ambiental, aquí te dejamos algunas lecturas y recursos que te serán útiles:</p>
            <ul>
                <li><a href="https://www.unenvironment.org/" target="_blank">UN Environment Programme</a> - Información oficial de la ONU sobre medio ambiente.</li>
                <li><a href="https://www.wwf.org/" target="_blank">World Wildlife Fund</a> - WWF trabaja en la conservación de la naturaleza y la biodiversidad.</li>
                <li><a href="https://www.greenpeace.org/international/" target="_blank">Greenpeace</a> - Información sobre las campañas ambientales globales.</li>
                <li><a href="https://www.nationalgeographic.com/environment/" target="_blank">National Geographic - Medio Ambiente</a> - Artículos y videos educativos sobre medio ambiente y sostenibilidad.</li>
            </ul>
        </div>

        <!-- Video Educativo -->
        <div class="card p-4 content-section">
            <h3 class="section-title">Video Educativo: El Futuro del Planeta</h3>
            <p>Te dejamos un video explicativo sobre la importancia de la educación ambiental en la creación de un futuro más sostenible:</p>
            <div class="embed-responsive embed-responsive-16by9">
                <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/Jc8Y6J7aV4A" allowfullscreen></iframe>
            </div>
        </div>

        <!-- Acciones -->
        <div class="text-center my-5">
            <a href="{{ route('hogar.solicitudes.create') }}" class="btn btn-success btn-lg">¡Haz tu parte! Solicita una recolección ecológica</a>
        </div>

    </div>
@endsection
