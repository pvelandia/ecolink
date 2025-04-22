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
        // Validar que la calificación esté presente y sea un número entre 1 y 5
        $request->validate([
            'calificacion' => 'required|integer|min:1|max:5',
        ]);
    
        // Buscar la recolección por ID
        $recoleccion = Assignment::findOrFail($id);
    
        // Obtener la calificación del formulario
        $calificacion = $request->input('calificacion');
    
        // Guardar la calificación
        $recoleccion->rating = $calificacion;
    
        // Cambiar el estado de la recolección a 4 (finalizada)
        $recoleccion->state_id = 4;
    
        // Guardar los cambios
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
        $request->validate([
            'puntos' => 'required|integer|min:1|max:50',
        ]);

        $recoleccion = Assignment::findOrFail($id);
        
        // Asignar puntos solo si no tiene puntos asignados
        if (!$recoleccion->points) {
            $recoleccion->points = $request->puntos;
            $recoleccion->save();
        }

        return redirect()->route('reciclador.recoleccionesFinalizadas')->with('success', 'Puntos asignados correctamente.');
    }
}
