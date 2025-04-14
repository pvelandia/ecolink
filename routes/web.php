<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SolicitudController;

use App\Models\Role;

// Página de bienvenida
Route::get('/', function () {
    return view('welcome'); // Aquí pones la vista bonita de bienvenida
})->middleware('guest')->name('welcome');

// Mostrar formulario de login
Route::get('/login', function () {
    return view('auth.login'); // Vista de inicio de sesión
})->middleware('guest')->name('login');

// Mostrar formulario de registro
Route::get('/register', function () {
    $roles = Role::all(); // Obtener roles desde la base de datos
    return view('auth.register', compact('roles'));
})->middleware('guest')->name('register');

// Procesar formularios
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/register', [AuthController::class, 'register'])->middleware('guest')->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Vista principal del hogar
Route::get('/hogar', function () {
    return view('home');
})->middleware('auth')->name('hogar');

// Rutas para los botones del panel del hogar
//Route::get('/solicitudes/crear', function () {
 //   return 'Vista para crear solicitud';
//})->middleware('auth')->name('solicitudes.create');
Route::get('/solicitudes/crear', [SolicitudController::class, 'create'])->middleware('auth')->name('solicitudes.create');
Route::post('/solicitudes', [SolicitudController::class, 'store'])->middleware('auth')->name('solicitudes.store');

Route::get('/solicitudes', function () {
    return 'Vista de mis solicitudes';
})->middleware('auth')->name('solicitudes.index');

Route::get('/educacion', function () {
    return 'Vista de educación ambiental';
})->middleware('auth')->name('educacion');

Route::get('/recolecciones/pendientes', function () {
    return 'Vista de reciclajes pendientes';
})->middleware('auth')->name('recolecciones.pendientes');

Route::get('/bonificaciones', function () {
    return 'Vista de bonificaciones';
})->middleware('auth')->name('bonificaciones.index');
