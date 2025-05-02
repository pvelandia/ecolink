<?php
namespace App\Http\Controllers;

use App\Models\Assignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RecoleccionesController extends Controller
{
    public function showStats()
    {
        $recolectorId = Auth::user()->id;
    
        DB::statement("SET lc_time_names = 'es_ES'"); // Establecer el idioma a español

        $recoleccionesPorMes = DB::table('assignments')
            ->where('recycler_id', $recolectorId)
            ->where('state_id', 4)
            ->select(
                DB::raw('YEAR(assignment_date) as year'),
                DB::raw('MONTH(assignment_date) as mes_num'),
                DB::raw('MONTHNAME(assignment_date) as mes'),
                DB::raw('COUNT(*) as cantidad')
            )
            ->groupBy(
                DB::raw('YEAR(assignment_date), MONTH(assignment_date), MONTHNAME(assignment_date)')
            )
            ->orderBy(
                DB::raw('YEAR(assignment_date), MONTH(assignment_date)')
            )
            ->get();
        
        // Kilogramos de cada material recolectado - Solo para el recolector autenticado con estado 4
        $materialesRecolectados = DB::table('assignment_materials')
            ->join('materials', 'assignment_materials.material_id', '=', 'materials.id')
            ->join('assignments', 'assignment_materials.assignment_id', '=', 'assignments.id')
            ->where('assignments.recycler_id', $recolectorId) // Filtro por recolector
            ->where('assignments.state_id', 4) // Filtro por estado 4 (finalizado)
            ->select('materials.name', DB::raw('SUM(assignment_materials.quantity) as total_kg'))
            ->groupBy('materials.name')
            ->get();
    
        // Calificación promedio de las recolecciones - Solo para el recolector autenticado con estado 4
        $calificacionPromedio = DB::table('assignments')
            ->where('recycler_id', $recolectorId) // Filtro por recolector
            ->where('state_id', 4) // Filtro por estado 4 (finalizado)
            ->select(DB::raw('AVG(rating) as promedio'))
            ->first();
    
        return view('reciclador.menu', compact('recoleccionesPorMes', 'materialesRecolectados', 'calificacionPromedio'));
    }
    
    public function recoleccionesAprobadas()
    {
        // Obtener las recolecciones con estado 3 (Aprobadas), cargando la relación de recicladores
        $recolecciones = Assignment::where('state_id', 3)  // Solo recolecciones aprobadas
            ->with('reciclador')  // Asegúrate de cargar la relación 'reciclador'
            ->orderBy('assignment_date', 'asc')  // Ordenarlas por fecha, de más cercana a más lejana
            ->get();
        return view('hogar.recoleccionesAprobadas', compact('recolecciones'));
    }

    public function finalizar($id, Request $request)
    {
        $request->validate([
            'calificacion' => 'required|integer|min:1|max:5',
        ]);
    
        $recoleccion = Assignment::findOrFail($id);
        $calificacion = $request->input('calificacion');
        $recoleccion->rating = $calificacion;
        $recoleccion->state_id = 4;
        $recoleccion->save();
    
        // Redirigir a la página de recolecciones
        return redirect()->route('hogar.recoleccionesAprobadas')->with('success', 'Recolección finalizada y calificada.');
    }

    public function recoleccionesAceptadas()
    {
        $hogar = auth()->user(); 
        $recolecciones = Assignment::where('person_id', $hogar->id)
                                            ->where('state_id', 2)
                                            ->with('reciclador', 'materials')
                                            ->get();
        return view('reciclador.recoleccionesAceptadas', compact('recolecciones'));
    }
    
    public function recoleccionesAprobadasR()
    {
        $reciclador = auth()->user();
        $asignaciones = Assignment::where('recycler_id', $reciclador->id)
                                  ->where('state_id', 3) // Estado 'aprobado'
                                  ->with('hogar', 'materials')
                                  ->get();
    
        return view('reciclador.recoleccionesAprobadas', compact('asignaciones'));
    }
    
    public function recoleccionesFinalizadas()
    {
        $hogar = auth()->user(); 
    
        $recolecciones = Assignment::where('person_id', $hogar->id)
                                    ->where('state_id', 4)
                                    ->with('reciclador', 'materials')
                                    ->get();
    
        // Estadísticas de reciclaje
        $materialesReciclados = DB::table('assignments')
            ->join('assignment_materials', 'assignments.id', '=', 'assignment_materials.assignment_id')
            ->join('materials', 'assignment_materials.material_id', '=', 'materials.id')
            ->where('assignments.person_id', $hogar->id)
            ->where('assignments.state_id', 4)
            ->select('materials.name as material', DB::raw('SUM(assignment_materials.quantity) as total_kg'))
            ->groupBy('materials.name')
            ->get();
    
        $totalKgReciclados = DB::table('assignments')
            ->join('assignment_materials', 'assignments.id', '=', 'assignment_materials.assignment_id')
            ->where('assignments.person_id', $hogar->id)
            ->where('assignments.state_id', 4)
            ->sum('assignment_materials.quantity');
    
        $kgPorArbol = 1000; // 1 tonelada = 1000 kg
        $arbolesSalvados = round($totalKgReciclados / $kgPorArbol, 2);
    
        return view('hogar.recoleccionesFinalizadas', compact('recolecciones', 'totalKgReciclados', 'arbolesSalvados', 'materialesReciclados'));
    }

    public function finalizadas()
    {
        // Obtener las recolecciones con estado 4 (Finalizadas)
        $recolecciones = Assignment::where('state_id', 4)  // Solo recolecciones finalizadas
            ->orderBy('assignment_date', 'asc')  // Ordenarlas por fecha
            ->get();

        // Obtener los puntos del usuario autenticado
        $puntos = auth()->user()->bonuses;  // Obtiene todos los bonus del usuario actual

        // Pasar las recolecciones y los puntos a la vista
        return view('hogar.recoleccionesFinalizadas', compact('recolecciones', 'puntos'));
    }
    
    public function asignarPuntos(Request $request, $id)
    {
        $recoleccion = Assignment::findOrFail($id);
        $puntos = 0;
        $cumplio = $request->input('cumplio');
    
        // Calcular los puntos basados en los materiales de la recolección
        foreach ($recoleccion->materials as $material) {
            $puntosMaterial = $material->pivot->quantity * $material->points_kilo;
            $puntos += $puntosMaterial;
        }
    
        // Si no cumplió, aplicar un descuento de puntos
        if ($cumplio == 0) {
            $descuento = round($puntos * 0.20); // Calcula el 20% 
            $puntos = max(0, $puntos - $descuento);
        }
    
        // Asignar los puntos calculados a la recolección
        $recoleccion->points = $puntos;
        $recoleccion->save();
    
        $hogar = $recoleccion->hogar;
        if ($hogar) {
            $hogar->points += $puntos;  // Sumar los puntos
            $hogar->save();
        } else {
            return redirect()->route('reciclador.recoleccionesFinalizadas')
                             ->with('error', 'No se encontró un hogar asociado a esta recolección.');
        }
        return redirect()->route('reciclador.recoleccionesFinalizadas')->with('success', 'Puntos asignados correctamente.');
    }       
}
