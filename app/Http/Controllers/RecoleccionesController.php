<?php
namespace App\Http\Controllers;

use App\Models\Assignment;
use Illuminate\Http\Request;

class RecoleccionesController extends Controller
{
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
        return view('reciclador.recoleccionesAceptadas', compact('recolecciones'));
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
