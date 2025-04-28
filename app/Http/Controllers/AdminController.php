<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Coupon;
use App\Models\Assignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Models\Material;
use App\Models\AssignmentMaterial;
use Illuminate\Support\Str;

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
    
        // Obtener las asignaciones con las relaciones necesarias
        $asignaciones = $query->with('reciclador', 'hogar', 'materials')->get();
    
        // Cargar la vista y establecer el papel en horizontal
        $pdf = PDF::loadView('admin.pdf.recoleccionesFinalizadasAdmin', compact('asignaciones'))
                    ->setPaper('a4', 'landscape'); // Establecer orientación horizontal
    
        return $pdf->download('recolecciones_finalizadas_admin.pdf');
    }
    
    
    public function exportarPdf(Request $request)
    {
        $images = $request->input('images', []);
    
        $pdf = Pdf::loadView('admin.recolecciones.estadisticas_pdf', compact('images'));
        return $pdf->download('estadisticas_recolecciones.pdf');
    }
    
    public function estadisticasRecolecciones()
{
    // Obtener los recicladores (usuarios con role_id 1)
    $recicladores = User::where('role_id', 1)->pluck('first_name', 'id');

    // Obtener todos los materiales
    $materiales = Material::all();

    // Total de recolecciones completadas (estado = 4 -> completado)
$totalRecoleccionesCompletadas = Assignment::where('state_id', 4)
->count();



    // Recolecciones por mes
    $porMes = Assignment::select(
        DB::raw("DATE_FORMAT(assignment_date, '%M') as mes"),
        DB::raw('count(*) as total')
    )
    ->whereYear('assignment_date', now()->year)
    ->groupBy('mes')
    ->orderBy(DB::raw("MONTH(MIN(assignment_date))"))
    ->get();

    // 📊 Material recolectado por semana (kg)
    $porSemanaKg = DB::table('assignment_materials')
    ->join('assignments', 'assignment_materials.assignment_id', '=', 'assignments.id')
    ->where('assignments.state_id', 4)
    ->select(
        DB::raw('YEAR(assignments.assignment_date) as anio'),
        DB::raw('WEEK(assignments.assignment_date, 1) as semana'), // Ojo: ahora WEEK
        DB::raw('SUM(assignment_materials.quantity) as total_kg')
    )
    ->groupBy('anio', 'semana')
    ->orderBy('anio')
    ->orderBy('semana')
    ->get();


    // 📊 Material recolectado por mes (kg)
    $porMesKg = DB::table('assignment_materials')
        ->join('assignments', 'assignment_materials.assignment_id', '=', 'assignments.id')
        ->where('assignments.state_id', 4)
        ->select(
            DB::raw("DATE_FORMAT(assignments.assignment_date, '%M') as mes"),
            DB::raw('SUM(assignment_materials.quantity) as total_kg')
        )
        ->groupBy('mes')
        ->orderBy(DB::raw("MONTH(MIN(assignments.assignment_date))"))
        ->get();

    // 📊 Recolecciones por calificación
    $porCalificacion = Assignment::whereNotNull('rating')
        ->select('rating', DB::raw('count(*) as total'))
        ->groupBy('rating')
        ->orderBy('rating')
        ->get();

    // 📊 Recolecciones por estado
    $porEstado =  Assignment::select('states.name', DB::raw('count(*) as total'))
    ->join('states', 'states.id', '=', 'assignments.state_id')  // Unimos la tabla 'states'
    ->groupBy('states.name')  // Agrupamos por el nombre del estado
    ->get();

    // Devolver la vista con los datos
    return view('admin.recolecciones.estadisticas', [
        'recicladorNames' => $recicladores->values(),
        'totalRecoleccionesCompletadas' => $totalRecoleccionesCompletadas,
      
        'porMes' => $porMes,
        'porSemanaKg' => $porSemanaKg,
        'porMesKg' => $porMesKg,
        'porCalificacion' => $porCalificacion,
        'porEstado' => $porEstado,
    ]);
}

    public function generarEstadisticasPDF(Request $request)
    {
        // Inicializar las variables con valores predeterminados
        $labelsMateriales = [];
        $dataMateriales = [];
        $labelsMeses = [];
        $dataMeses = [];
        $labelsEstados = ['Pendiente', 'Aprobada', 'Rechazada'];
        $dataEstados = [0, 0, 0]; // Inicializar con ceros para cada estado
        $labelsCalificaciones = ['1 estrella', '2 estrellas', '3 estrellas', '4 estrellas', '5 estrellas'];
        $dataCalificaciones = [0, 0, 0, 0, 0]; // Inicializar con ceros para las calificaciones

        // Filtrar las recolecciones según los parámetros
        $query = assignment::where('state_id', 3); // Solo recolecciones aprobadas
        
        // Filtro por fecha
        if ($request->filled('fecha')) {
            $query->whereDate('fecha_recoleccion', Carbon::parse($request->fecha));
        }

        // Filtro por material
        if ($request->filled('material')) {
            $query->whereHas('materiales', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->material . '%');
            });
        }

        // Filtro por calificación
        if ($request->filled('calificacion')) {
            $query->where('calificacion', $request->calificacion);
        }

        // Obtener las recolecciones filtradas
        $recolecciones = $query->with('materiales')->get();

        // Calcular las estadísticas
        foreach ($recolecciones as $recoleccion) {
            // Materiales
            foreach ($recoleccion->materiales as $material) {
                $index = array_search($material->name, $labelsMateriales);
                if ($index === false) {
                    $labelsMateriales[] = $material->name;
                    $dataMateriales[] = $material->pivot->cantidad;
                } else {
                    $dataMateriales[$index] += $material->pivot->cantidad;
                }
            }

            // Meses
            $mes = Carbon::parse($recoleccion->fecha_recoleccion)->format('F');
            $indexMes = array_search($mes, $labelsMeses);
            if ($indexMes === false) {
                $labelsMeses[] = $mes;
                $dataMeses[] = 1; // Inicializamos con 1 recolección en ese mes
            } else {
                $dataMeses[$indexMes]++;
            }

            // Estados
            if ($recoleccion->estado == 1) $dataEstados[0]++;
            if ($recoleccion->estado == 2) $dataEstados[1]++;
            if ($recoleccion->estado == 3) $dataEstados[2]++;

            // Calificaciones
            $dataCalificaciones[$recoleccion->calificacion - 1]++;
        }

        // Generar el PDF
        $pdf = PDF::loadView('recoleccionesFinalizadasAdminGraficos', compact(
            'labelsMateriales', 'dataMateriales', 
            'labelsMeses', 'dataMeses', 
            'labelsEstados', 'dataEstados', 
            'labelsCalificaciones', 'dataCalificaciones'
        ))->setPaper('a4', 'landscape'); // Establecer orientación horizontal

        // Descargar el PDF
        return $pdf->download('estadisticas_recolecciones.pdf');
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

    public function crearCupon()
    {
        return view('admin.crearCupon');
    }

    public function guardarCupon(Request $request)
    {
        $request->validate([
            'company' => 'required|string|max:255',
            'description' => 'required|string',
            'discount' => 'required|numeric|min:0|max:100',
            'stock' => 'required|integer|min:1',
            'points' => 'required|integer|min:1',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'discount.min' => 'El Descuento debe ser mayor o igual a 0.',
            'discount.max' => 'El Descuento debe ser como máximo 100.',
            'stock.min' => 'El Stock debe ser mayor o igual a 1.',
            'points.min' => 'El Puntos debe ser mayor o igual a 1.',
        ]);
        $data = [
            'company' => $request->company,
            'description' => $request->description,
            'discount' => $request->discount,
            'stock' => $request->stock,
            'stock_inicial' => $request->stock,
            'points' => $request->points,
            'address' => $request->address,
            'phone' => $request->phone,
        ];
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('cupones', 'public');
            $data['image'] = $imagePath;
        }
        Coupon::create($data);
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
    

    public function materiales()
    {
        $materials = Material::all();
        return view('admin.materiales', compact('materials'));
    }

    public function crearMaterial()
    {
        return view('admin.crearMaterial');
    }

    public function storeMaterial(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:materials,name',
            'points_kilo' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
        ]);
        if (Material::create([
            'name' => $validated['name'],
            'points_kilo' => $validated['points_kilo'],
            'description' => $validated['description'] ?? null,
        ])) {
            return redirect()->route('admin.materiales')->with('success', 'Material creado con éxito.');
        } else {
            return back()->with('error', 'Hubo un problema al crear el material. Inténtalo de nuevo.');
        }
    }

    public function editarMaterial($id)
    {
        $material = Material::findOrFail($id);
        return view('admin.editarMaterial', compact('material'));
    }

    public function actualizarMaterial(Request $request, $id)
    {
        $material = Material::findOrFail($id);
        $validated = $request->validate([
            'points_kilo' => 'required|numeric|min:0|max:1000',
            'description' => 'nullable|string|max:100',
        ], [
            // Mensajes de error personalizados
            'points_kilo.max' => 'El número de puntos por kilo no puede exceder lo reglamentario.',
            'description.max' => 'La descripción no puede tener más de 100 caracteres.',
        ]);
        $material->points_kilo = $validated['points_kilo'];
        $material->description = $validated['description'] ?? $material->description;
        $material->save();
        return redirect()->route('admin.materiales')->with('success', 'Material actualizado correctamente.');
    }

    public function eliminarMaterial($id)
    {
        $existeAsignacion = AssignmentMaterial::where('material_id', $id)->exists();
        if ($existeAsignacion) {
            return redirect()->route('admin.materiales')->with('error', 'No se puede eliminar porque el material está asignado en 1 o mas recolecciones.');
        }
        Material::findOrFail($id)->delete();

        return redirect()->route('admin.materiales')->with('success', 'Material eliminado correctamente.');
    }
}
