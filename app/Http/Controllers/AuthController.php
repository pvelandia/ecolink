<?php

namespace App\Http\Controllers;

    
    use App\Http\Controllers\Controller;
    use App\Models\User;
    use App\Models\Role;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Facades\Validator;
    use Illuminate\Support\Facades\Auth;

    
    class AuthController extends Controller
    {

        
        public function register(Request $request)
        {
            $request->validate([
                'name' => 'required|string|max:255',
                'apellido' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6|confirmed',
                'direccion' => 'required|string|max:255',
                'cedula' => 'required|numeric|digits_between:6,12|unique:users',
                'telefono' => 'required|numeric|digits_between:7,15',
                'rol_id' => 'required|exists:roles,id',
            ], [
                'name.required' => 'El nombre es obligatorio.',
                'apellido.required' => 'El apellido es obligatorio.',
                'email.required' => 'El correo es obligatorio.',
                'email.email' => 'Debe ser un correo válido.',
                'email.unique' => 'Este correo ya está registrado.',
                'password.required' => 'La contraseña es obligatoria.',
                'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
                'password.confirmed' => 'Las contraseñas no coinciden.',
                'direccion.required' => 'La dirección es obligatoria.',
                'cedula.required' => 'La cédula es obligatoria.',
                'cedula.numeric' => 'La cédula debe ser un número.',
                'cedula.digits_between' => 'La cédula debe tener entre 6 y 12 dígitos.',
                'cedula.unique' => 'Esta cédula ya está registrada.',
                'telefono.required' => 'El teléfono es obligatorio.',
                'telefono.numeric' => 'El teléfono debe ser un número.',
                'telefono.digits_between' => 'El teléfono debe tener entre 7 y 15 dígitos.',
                'rol_id.required' => 'Debe seleccionar un rol.',
            ]);
        
            $user = User::create([
                'name' => $request->name,
                'apellido' => $request->apellido,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'direccion' => $request->direccion,
                'cedula' => $request->cedula,
                'telefono' => $request->telefono,
                'rol_id' => $request->rol_id,
            ]);
        
            return redirect()->route('login')->with('success', 'Registro exitoso. Ahora puedes iniciar sesión.');
        }
        
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
    
            // Verifica si el usuario tiene el rol de escritor (rol = 3)
          /*  if ($user->role_id == 3) {
                return redirect()->route('escritor.inicio'); // Redirige a InicioEscritor
            }*/
    
            return redirect()->route('welcome'); // Redirige a la página de libros por defecto
        }
    
        return back()->with('error', 'Credenciales incorrectas');
    }
    // Cerrar sesión
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
    public function registerForm()
{
    $roles = Role::all(); // Obtiene todos los roles de la base de datos
    return view('auth.register', compact('roles')); // Envía los roles a la vista
}
}
