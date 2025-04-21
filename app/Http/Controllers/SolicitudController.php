<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Assignment;
use App\Models\Material;
use App\Models\AssignmentMaterial;
use Illuminate\Support\Facades\Log;


class SolicitudController extends Controller
{
    public function create()
    {
        $materials = Material::all();
        return view('solicitudes.create', compact('materials'));
    }
    
    public function store(Request $request)
    {
        // Validación de los datos
        $request->validate([
            'materials' => 'required|array',
            'materials.*.material_id' => 'required|exists:materials,id',
            'materials.*.quantity' => 'required|numeric|min:0.1',
            'collection_date' => 'required|date|after_or_equal:today',
            'observation' => 'nullable|string|max:255',
            'address_part1' => 'required|string|max:255',
            'address_part2' => 'required|string|max:50',
        ]);

        // Crear la dirección concatenada
        $address = $request->address_part1 . ' #' . $request->address_part2;
        if ($request->filled('address_part3')) {
            $address .= ' - ' . $request->address_part3;
        }

        // Crear la solicitud de recolección (Assignment) y guardar la dirección
        $assignment = Assignment::create([
            'person_id' => auth()->id(),
            'assignment_date' => now(), // Fecha y hora actual
            'state_id' => 1,  // Estado inicial: pendiente
            'address' => $address,  // Guardar la dirección en el campo address
        ]);

        // Asociar los materiales con la solicitud de recolección
        foreach ($request->materials as $mat) {
            AssignmentMaterial::create([
                'assignment_id' => $assignment->id,  // Relacionar con el assignment recién creado
                'material_id' => $mat['material_id'],  // ID del material
                'quantity' => $mat['quantity'],  // Cantidad de material
            ]);
        }

        // Redirigir a la página de inicio con mensaje de éxito
        return redirect()->route('hogar.home')->with('success', '¡Recolección solicitada correctamente!');
    }
    // Método para mostrar las solicitudes pendientes reciclador
    public function index()
    {
        // Obtener las solicitudes con estado '1' (pendiente) y cargar los materiales asociados
        $solicitudes = Assignment::where('state_id', 1) 
                                    ->with('materials') 
                                    ->get();
        return view('reciclador.solicitudes', compact('solicitudes'));
    }

    // Método para ver los detalles de una solicitud
    public function show($id)
    {
        // Asegúrate de cargar las relaciones 'hogar' y 'materials' cuando traes la solicitud
        $solicitud = Assignment::with(['hogar', 'materials'])->findOrFail($id);

        // Retorna la vista con la solicitud cargada
        return view('reciclador.solicitudesDetalle', compact('solicitud'));
    }

    public function misSolicitudes()
    {
        $hogar = auth()->user(); // El hogar es el usuario logueado
        $solicitudes = Assignment::where('person_id', $hogar->id)
                                ->where('state_id', 2) // Filtramos las solicitudes en estado aceptada
                                ->with(['reciclador', 'materials']) // Cargamos la relación con reciclador y materiales
                                ->get();
        return view('hogar.solicitudes', compact('solicitudes'));
    }

    public function misSolicitudesAceptadas()
    {
        $reciclador = auth()->user(); 
        // Obtener las asignaciones con estado 'aceptada' (suponiendo que 'state_id' = 2 es el estado aceptado)
        $asignaciones = Assignment::where('recycler_id', $reciclador->id)
                                    ->where('state_id', 2) // Solicitudes aceptadas
                                    ->with('hogar', 'materials') // Cargar la relación 'person' y 'materials'
                                    ->get();
    
        return view('reciclador.recoleccionesAceptadas', compact('asignaciones'));
    }
    
    public function recoleccionesFinalizadas(Request $request)
    {
        $reciclador = auth()->user();
    
        // Empezamos la consulta base
        $query = Assignment::where('recycler_id', $reciclador->id)
            ->where('state_id', 4); // Solo las recolecciones finalizadas
    
        // Filtrar por fecha
        if ($request->filled('fecha')) {
            $query->whereDate('assignment_date', '=', $request->fecha);
        }
    
        // Filtrar por material
        if ($request->filled('material')) {
            $query->whereHas('materials', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->material . '%');
            });
        }
    
        // Filtrar por calificación
        if ($request->filled('calificacion')) {
            $query->where('rating', '=', $request->calificacion);
        }
    
        // Obtener las asignaciones con relaciones
        $asignaciones = $query->with('reciclador', 'materials')->get();
    
        return view('reciclador.recoleccionesFinalizadas', compact('asignaciones'));
    }
    
    
    public function cancelarSolicitud($id)
    {
        $asignacion = Assignment::findOrFail($id);
    
        // Verifica que el reciclador actual sea el asignado
        if ($asignacion->recycler_id != auth()->user()->id) {
            return redirect()->route('reciclador.recoleccionesAceptadas')
                             ->with('error', 'No tienes permiso para cancelar esta solicitud.');
        }
    
        // Cambiar estado a pendiente y eliminar reciclador asignado
        $asignacion->state_id = 1;
        $asignacion->recycler_id = null;
        $asignacion->save();
    
        return redirect()->route('reciclador.recoleccionesAceptadas')
                         ->with('success', 'Solicitud cancelada con éxito.');
    }

    public function solicitudesPendientes()
    {
        $hogar = auth()->user();
        $solicitudes = Assignment::where('person_id', $hogar->id)
                        ->where('state_id', 1)
                        ->with('materials')
                        ->get();
        return view('hogar.solicitudesPendientes', compact('solicitudes'));
    }

    public function eliminarSolicitud($id)
    {
        // Buscar la solicitud por ID
        $asignacion = Assignment::findOrFail($id);
        // Eliminar la solicitud
        $asignacion->delete();
        return redirect()->route('hogar.solicitudesPendientes')->with('success', 'Solicitud eliminada correctamente.');
    }

    public function aceptar($id)
    {
        $solicitud = Assignment::findOrFail($id);
        $solicitud->recycler_id = auth()->id(); // ID del reciclador autenticado
        $solicitud->state_id = 2;
        $solicitud->save();

        return redirect()->route('reciclador.solicitudes')->with('success', 'Solicitud aceptada correctamente.');
    }

    public function aprobar($id)
    {
        $solicitud = Assignment::find($id);
        $solicitud->state_id = 3; // 3 es el estado 'Aprobado'
        $solicitud->save();

        return redirect()->route('hogar.solicitudes');
    }

    public function rechazar($id)
    {
        $solicitud = Assignment::find($id);
        $solicitud->state_id = 1; // 1 es el estado 'Pendiente'
        $solicitud->recycler_id = null; // Borra el ID del reciclador
        $solicitud->save();
        return redirect()->route('hogar.solicitudes');
    }
}
