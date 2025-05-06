<nav class="navbar navbar-expand-lg" style="background-color: #025939; padding-top: 1rem; padding-bottom: 1rem;">
    <div class="container">
        {{-- Logo --}}
        <a class="navbar-brand d-flex align-items-center" 
           href="{{ Auth::check() 
                ? (Auth::user()->role->name === 'Reciclador' 
                    ? route('reciclador.menu') 
                    : (Auth::user()->role->name === 'Hogar' 
                        ? route('hogar.home') 
                        : (Auth::user()->role->name=== 'Administrador' 
                            ? route('admin.menu') 
                            : route('login')))) 
                : route('login') }}">
            <img src="https://i.postimg.cc/3JLLydKZ/Imagen-de-Whats-App-2025-04-14-a-las-08-27-25-b82fdc0e.jpg" alt="EcoLink" width="50" height="50" class="me-2" style="max-width: 60px; max-height: 60px;">
            <span class="text-white fw-bold d-none d-md-inline" style="font-size: 1.1em;">EcoLink</span>
        </a>
<style>
    body {
        height: 100%;
        margin: 0;
        background: #e6f5e5;
    }
    .button_slide {
        color: white;
        border: 2px solid #012340;  /* Rojo bonito */
        border-radius: 0px;  /* Bordes rectos */
        padding: 18px 36px;
        display: inline-block;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; /* Fuente elegante */
        font-size: 14px;
        letter-spacing: 1px;
        cursor: pointer;
        box-shadow: inset 0 0 0 0 #012340;
        -webkit-transition: ease-out 0.4s;
        -moz-transition: ease-out 0.4s;
        transition: ease-out 0.4s;
        background: #ca0b0b;
    }
    .slide_down:hover {
        box-shadow: inset 0 100px 0 rgb(134, 13, 0);
    }
    .slide_right:hover {
        box-shadow: inset 400px 0 0 rgb(134, 13, 0);
    }
    .slide_left:hover {
        box-shadow: inset 0 0 0 50px rgb(134, 13, 0);
    }
    .slide_diagonal:hover {
        box-shadow: inset 400px 50px 0 rgb(134, 13, 0);
    }
    .button_slide.small {
        padding: 10px 20px;
        font-size: 12px;
    }
</style>

        {{-- Botón para móviles --}}
        <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Enlaces de navegación --}}
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav align-items-center">
                @auth
                    <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="button_slide slide_left small">Cerrar sesión</button>
                    </form>
                    </li>
                @endauth

                @guest
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('login') }}">Iniciar sesión</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('register') }}">Registrarse</a>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>