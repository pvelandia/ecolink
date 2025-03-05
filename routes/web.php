<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

use App\Models\Role;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/register', function () {
    $roles = Role::all(); // Obtiene los roles desde la base de datos
    return view('auth.register', compact('roles')); // Envía los roles a la vista
})->name('register');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Procesar formularios
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
