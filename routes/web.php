<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SolicitudController;
use App\Models\Role;
use App\Http\Middleware\CheckRole;

// Página de bienvenida
Route::get('/', function () {
    return view('welcome');
})->middleware('guest')->name('welcome');

// Login y Registro
Route::get('/login', fn () => view('auth.login'))->middleware('guest')->name('login');
Route::get('/register', function () {
    $roles = Role::all();
    return view('auth.register', compact('roles'));
})->middleware('guest')->name('register');

Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/register', [AuthController::class, 'register'])->middleware('guest')->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');


// RUTAS PARA ROL: hogar
Route::middleware(['auth', CheckRole::class . ':Hogar'])->group(function () {

    Route::get('/hogar', fn () => view('home'))->name('hogar');

    Route::get('/solicitudes/crear', [SolicitudController::class, 'create'])->name('solicitudes.create');
    Route::post('/solicitudes', [SolicitudController::class, 'store'])->name('solicitudes.store');

    Route::get('/solicitudes', fn () => 'Vista de mis solicitudes')->name('solicitudes.index');

    Route::get('/educacion', fn () => 'Vista de educación ambiental')->name('educacion');
    Route::get('/recolecciones/pendientes', fn () => 'Vista de reciclajes pendientes')->name('recolecciones.pendientes');
    Route::get('/bonificaciones', fn () => 'Vista de bonificaciones')->name('bonificaciones.index');

});


// RUTAS PARA ROL: reciclador
Route::middleware(['auth', CheckRole::class . ':Reciclador'])->prefix('Reciclador')->group(function () {

    Route::get('/menu', fn () => view('reciclador.menu'))->name('reciclador.menu');

    Route::get('/solicitudes', [SolicitudController::class, 'index'])->name('reciclador.solicitudes');
    Route::get('/{id}/solicitudesDetalle', [SolicitudController::class, 'show'])->name('reciclador.solicitudesDetalle');

    Route::put('/solicitudes/{id}/aceptar', [SolicitudController::class, 'aceptar'])->name('reciclador.solicitudes.aceptar');
    Route::put('/solicitudes/{id}/rechazar', [SolicitudController::class, 'rechazar'])->name('reciclador.solicitudes.rechazar');

    Route::get('/recolecciones/pendientes', fn () => 'Vista de recolecciones pendientes')->name('reciclador.recoleccionesPendientes');
    Route::get('/recolecciones/finalizadas', fn () => 'Vista de recolecciones finalizadas')->name('reciclador.recoleccionesFinalizadas');

});
