<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'required|string|max:255',
            'email'         => 'required|string|email|max:255|unique:people',
            'password'      => 'required|string|min:6|confirmed',
            'document'      => 'required|numeric|digits_between:6,12|unique:people',
            'phone_number'  => 'required|numeric|digits_between:7,15',
            'role_id'       => 'required|exists:roles,id',
        ], [
            'first_name.required'    => 'First name is required.',
            'last_name.required'     => 'Last name is required.',
            'email.required'         => 'Email is required.',
            'email.email'            => 'Email must be valid.',
            'email.unique'           => 'This email is already registered.',
            'password.required'      => 'Password is required.',
            'password.min'           => 'Password must be at least 6 characters.',
            'password.confirmed'     => 'Passwords do not match.',
            'document.required'      => 'Document is required.',
            'document.numeric'       => 'Document must be numeric.',
            'document.digits_between'=> 'Document must be between 6 and 12 digits.',
            'document.unique'        => 'This document is already registered.',
            'phone_number.required'  => 'Phone number is required.',
            'phone_number.numeric'   => 'Phone number must be numeric.',
            'phone_number.digits_between' => 'Phone number must be between 7 and 15 digits.',
            'role_id.required'       => 'You must select a role.',
        ]);

        $person = User::create([
            'first_name'    => $request->first_name,
            'last_name'     => $request->last_name,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'document'      => $request->document,
            'phone_number'  => $request->phone_number,
            'role_id'       => $request->role_id,
        ]);

        return redirect()->route('login')->with('success', 'Registro exitoso. Inicia sesión para continuar.');
    }
    

    public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        return redirect()->route('hogar'); // Asegúrate de que esta ruta existe
    }

    return back()->with('error', 'Correo o contraseña incorrectos');
}


    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function registerForm()
    {
        $roles = Role::all();
        return view('auth.register', compact('roles'));
    }
}
