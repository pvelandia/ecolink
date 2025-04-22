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
            'first_name'        => 'required|string|max:255',
            'last_name'         => 'required|string|max:255',
            'email'             => 'required|string|email|max:255|unique:people',
            'password'          => 'required|string|min:6|confirmed',
            'document'          => 'required|numeric|digits:10|unique:people',
            'phone_number'      => 'required|numeric|digits:10',
            'role_id'           => 'required|exists:roles,id',
        ], [
            'first_name.required'       => 'El nombre es obligatorio.',
            'last_name.required'        => 'El apellido es obligatorio.',
            'email.required'            => 'El correo electrónico es obligatorio.',
            'email.email'               => 'El correo electrónico debe ser válido.',
            'email.unique'              => 'Este correo electrónico ya está registrado.',
            'password.required'         => 'La contraseña es obligatoria.',
            'password.min'              => 'La contraseña debe tener al menos 6 caracteres.',
            'password.confirmed'        => 'Las contraseñas no coinciden.',
            'document.required'         => 'El número de documento es obligatorio.',
            'document.numeric'          => 'El número de documento debe ser numérico.',
            'document.digits'           => 'El número de documento debe tener exactamente 10 dígitos.',
            'document.unique'           => 'Este documento ya está registrado.',
            'phone_number.required'     => 'El número de teléfono es obligatorio.',
            'phone_number.numeric'      => 'El número de teléfono debe ser numérico.',
            'phone_number.digits'       => 'El número de teléfono debe tener exactamente 10 dígitos.',
            'role_id.required'          => 'Debe seleccionar un rol.',
        ]);
    
        $person = User::create([
            'first_name'        => $request->first_name,
            'last_name'         => $request->last_name,
            'email'             => $request->email,
            'password'          => Hash::make($request->password),
            'document'          => $request->document,
            'phone_number'      => $request->phone_number,
            'role_id'           => $request->role_id,
        ]);
    
        return redirect()->route('login')->with('success', 'Registro exitoso. Inicia sesión para continuar.');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $user = User::where('email', $credentials['email'])->first();
        if (!$user) {
            return back()->withErrors(['email' => 'El correo electrónico no está registrado.'])->withInput();
        }    
        if (!Auth::attempt($credentials)) {
            return back()->withErrors(['password' => 'La contraseña es incorrecta.'])->withInput();
        }
    
        $role = Auth::user()->role->name;    
        // Redirigir según el rol
        if ($role === 'Reciclador') {
            return redirect()->route('reciclador.menu');
        } elseif ($role === 'Administrador') {
            return redirect()->route('admin.menu');
        } elseif ($role === 'Bloqueado') {
            return redirect()->route('bloqueado');
        } elseif ($role === 'Hogar') {
            return redirect()->route('hogar.home');
        } else {
            return redirect()->route('hogar.home');
        }
    }

    public function logout()
    {
        Auth::logout();
        session()->flush();  // Elimina todos los datos de la sesión
        return redirect()->route('welcome');
    }
    
    public function registerForm()
    {
        $roles = Role::all();
        return view('auth.register', compact('roles'));
    }

    public function bloqueado()
    {
        return view('bloqueado');
    }
}
