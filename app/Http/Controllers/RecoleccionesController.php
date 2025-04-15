<?php
namespace App\Http\Controllers;

use App\Models\Assignment;
use Illuminate\Http\Request;

class RecoleccionesController extends Controller

{
    public function index()
{
    // Obtener las recolecciones con estado 3 (Aprobadas), cargando la relación de recicladores
    $recolecciones = Assignment::where('state_id', 3)  // Solo recolecciones aprobadas
        ->with('reciclador')  // Asegúrate de cargar la relación 'reciclador'
        ->orderBy('assignment_date', 'asc')  // Ordenarlas por fecha, de más cercana a más lejana
        ->get();

    // Pasar las recolecciones a la vista
    return view('hogar.recoleccionesPendientes', compact('recolecciones'));
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
        return redirect()->route('hogar.recoleccionesPendientes')->with('success', 'Recolección finalizada y calificada.');
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




    public function solicitudes()
    {
        // Obtener todas las solicitudes asociadas al reciclador autenticado
        $solicitudes = Assignment::where('person_id', auth()->id())
            ->where('state_id', 1) // Suponiendo que 1 es el estado de solicitud
            ->get();

        return view('reciclador.solicitudes', compact('solicitudes'));
    }

    public function recoleccionesPendientes()
    {
        // Obtener las recolecciones pendientes
        $recoleccionesPendientes = Assignment::where('person_id', auth()->id())
            ->where('state_id', 2) // Suponiendo que 2 es el estado de pendiente
            ->get();

        return view('reciclador.recoleccionesPendientes', compact('recoleccionesPendientes'));
    }

    public function recoleccionesFinalizadas()
    {
        // Obtener las recolecciones finalizadas
        $recoleccionesFinalizadas = Assignment::where('person_id', auth()->id())
            ->where('state_id', 3) // Suponiendo que 3 es el estado de finalizada
            ->get();

        return view('reciclador.recoleccionesFinalizadas', compact('recoleccionesFinalizadas'));
    }
}
