<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use Illuminate\Http\Request;

class RecoleccionController extends Controller
{
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
