<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Assignment;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    public function menu()
    {
        return view('admin.menu');
    }

    public function usuarios(Request $request)
    {
        $roles = Role::all();
        $filtroRol = $request->input('rol_id');
    
        $usuarios = User::with('role')
                    ->when($filtroRol, function ($query, $rolId) {
                        return $query->where('role_id', $rolId);
                    })->get();
    
        return view('admin.usuarios', compact('usuarios', 'roles', 'filtroRol'));
    }
    
    public function actualizarRol(Request $request, $id)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id'
        ]);
    
        $usuario = User::findOrFail($id);
        $usuario->role_id = $request->role_id;
        $usuario->save();
    
        return redirect()->route('admin.usuarios')->with('success', 'Rol actualizado correctamente.');
    }
    public function recoleccionesFinalizadasAdmin(Request $request)
    {
   

        // Filtrado por fecha, material y calificación
        $query = Assignment::where('state_id', 4); // Estado 'finalizado'

        // Filtramos por fecha si existe el valor
        if ($request->filled('fecha')) {
            $query->whereDate('assignment_date', Carbon::parse($request->fecha));
        }

        // Filtramos por material si existe el valor
        if ($request->filled('material')) {
            $query->whereHas('materials', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->material . '%');
            });
        }

        // Filtramos por calificación si existe el valor
        if ($request->filled('calificacion')) {
            $query->where('rating', $request->calificacion);
        }

        $asignaciones = $query->with('reciclador', 'hogar', 'materials')->get();

        return view('admin.recoleccionesFinalizadasAdmin', compact('asignaciones'));
    }

    // Función para generar PDF con los resultados filtrados
    public function generarPDF(Request $request)
    {
        $query = Assignment::where('state_id', 4); // Estado 'finalizado'

        if ($request->filled('fecha')) {
            $query->whereDate('assignment_date', Carbon::parse($request->fecha));
        }

        if ($request->filled('material')) {
            $query->whereHas('materials', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->material . '%');
            });
        }

        if ($request->filled('calificacion')) {
            $query->where('rating', $request->calificacion);
        }

        $asignaciones = $query->with('reciclador', 'hogar', 'materials')->get();
        $pdf = Pdf::loadView('admin.pdf.recoleccionesFinalizadasAdmin', compact('asignaciones'));
        
        return $pdf->download('recolecciones_finalizadas_admin.pdf');
    }

    public function bloquearUsuario($id)
    {
        $usuario = User::findOrFail($id);
        $usuario->role_id = 4; // ID del rol "bloqueado"
        $usuario->save();

        return redirect()->route('admin.usuarios')->with('success', 'Usuario bloqueado correctamente.');
    }

    public function bonificaciones()
    {
        $cupones = Coupon::all();
        return view('admin.bonificaciones', compact('cupones'));
    }

    public function guardarCupon(Request $request)
    {
        $request->validate([
            'company' => 'required|string|max:255',
            'description' => 'required|string',
            'discount' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:1',
            'points' => 'required|integer|min:1',
        ]);
    
        Coupon::create([
            'company' => $request->company,
            'description' => $request->description,
            'discount' => $request->discount,
            'stock' => $request->stock,
            'stock_inicial' => $request->stock,
            'points' => $request->points,
        ]);
    
        return redirect()->route('admin.bonificaciones')->with('success', 'Cupón creado correctamente.');
    }
    
    public function editarCupon($id)
    {
        $cupon = Coupon::findOrFail($id);
        return view('admin.editarCupon', compact('cupon'));
    }

    public function actualizarCupon(Request $request, $id)
    {
        $request->validate([
            'company'       => 'required|string|max:255',
            'description'   => 'required|string',
            'discount'      => 'required|numeric|min:0',
            'points'        => 'required|integer|min:0',
            'ajuste_stock'  => 'nullable|integer',
        ]);

        $cupon = Coupon::findOrFail($id);

        $cupon->company = $request->company;
        $cupon->description = $request->description;
        $cupon->discount = $request->discount;
        $cupon->points = $request->points;

        // Ajuste de stock
        if ($request->filled('ajuste_stock')) {
            $ajuste = $request->ajuste_stock;
            $nuevoStock = $cupon->stock + $ajuste;
            $nuevoStockInicial = $cupon->stock_inicial + max(0, $ajuste); // solo sumamos si el ajuste es positivo

            if ($nuevoStock >= 0) {
                $cupon->stock = $nuevoStock;
                $cupon->stock_inicial = $nuevoStockInicial;
            } else {
                return back()->withErrors(['ajuste_stock' => 'No se puede tener stock negativo.']);
            }
        }

        $cupon->save();

        return redirect()->route('admin.bonificaciones')->with('success', 'Cupón actualizado correctamente.');
    }

    public function eliminarCupon($id)
    {
        $cupon = Coupon::findOrFail($id);
        $cupon->delete();
        return redirect()->route('admin.bonificaciones')->with('success', 'Cupón eliminado correctamente.');
    }

    public function reportes()
    {
        return view('admin.reportes');
    }
}
