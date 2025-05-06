<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Assignment;
use App\Models\Material;
use App\Models\AssignmentMaterial;
use App\Mail\SolicitudAprobada;
use App\Mail\SolicitudCancelada;


use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Carbon;

class SolicitudController extends Controller
{
    
    public function create()
    {
        $materials = Material::all();
        return view('solicitudes.create', compact('materials'));
    }
    public function showMenu()
    {
        return view('hogar.home');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'materials' => 'required|array',
            'materials.*.material_id' => 'required|exists:materials,id',
            'materials.*.quantity' => 'required|numeric|min:0.01|max:100', // máximo 100kg
            'collection_date' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    $selectedDate = Carbon::parse($value);
                    $minDate = Carbon::now()->addDay(); // mínimo un día después
                    $maxDate = Carbon::now()->addMonths(1); // máximo 6 meses después

                    if ($selectedDate->lt($minDate)) {
                        $fail('La recolección debe solicitarse con al menos un día de anticipación.');
                    }

                    if ($selectedDate->gt($maxDate)) {
                        $fail('La fecha de recolección no puede ser mayor a 1 mes desde hoy.');
                    }
                },
            ],
            'observation' => 'nullable|string|max:255',
            'address_part1' => 'required|string|max:255',
            'address_part2' => 'required|string|max:50',
        ], [
            'materials.*.quantity.max' => 'La cantidad de material no puede ser mayor a 100 kg por solicitud.',
        ]);      

        // Crear la dirección concatenada
        $address = $request->address_part1 . ' #' . $request->address_part2;
        if ($request->filled('address_part3')) {
            $address .= ' - ' . $request->address_part3;
        }

        // Crear la solicitud de recolección (Assignment) y guardar la dirección
        $assignment = Assignment::create([
            'person_id' => auth()->id(),
            'assignment_date' => $request->collection_date,
            'state_id' => 1,  // Estado inicial: pendiente
            'address' => $address,  // Guardar la dirección en el campo address
            'created_at' => Carbon::now(),
        ]);

        // Asociar los materiales con la solicitud de recolección
        foreach ($request->materials as $mat) {
            AssignmentMaterial::create([
                'assignment_id' => $assignment->id,  // Relacionar con el assignment recién creado
                'material_id' => $mat['material_id'],  // ID del material
                'quantity' => $mat['quantity'],  // Cantidad de material
            ]);
        }

        // Redirigir con mensaje de éxito
        return redirect()->route('solicitudes.create')->with('success', '¡Recolección solicitada correctamente!');
    }

    public function index()    // Método para mostrar las solicitudes pendientes reciclador
    {
        $solicitudes = Assignment::where('state_id', 1) 
                                    ->with('materials') 
                                    ->get();
        return view('reciclador.solicitudes', compact('solicitudes'));
    }

    public function show($id)     // Método para ver los detalles de una solicitud
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
        $solicitud->state_id = 3;
        $solicitud->save();

        // Enviar correo al hogar
        Mail::to($solicitud->hogar->email)->send(new SolicitudAprobada($solicitud));

        // Enviar correo al reciclador
        Mail::to($solicitud->reciclador->email)->send(new SolicitudAprobada($solicitud));

        return redirect()->route('hogar.solicitudes')
                        ->with('success', '¡Solicitud aprobada con éxito y correos enviados!');
    }
        
    public function rechazar($id)
    {
        $solicitud = Assignment::find($id);
        $solicitud->state_id = 1; // Estado 'Pendiente'
        $solicitud->recycler_id = null;
        $solicitud->save();
    
        return redirect()->route('hogar.solicitudes')
                         ->with('error', 'Solicitud rechazada y regresada a espera de aprobacion de otro reciclador.');
    }
    public function cancelarFinal($id)
    {
        $asignacion = Assignment::findOrFail($id);
        $reciclador = $asignacion->reciclador; 

        $horasFaltantes = Carbon::now()->diffInHours(Carbon::parse($asignacion->assignment_date), false);
    
        if ($horasFaltantes <= 3) {
            return redirect()->back()->with('error', 'Solo puedes cancelar una recolección con más de 3 horas de anticipación.');
        }
    
        $asignacion->state_id = 1;
        $asignacion->recycler_id = null;
        $asignacion->save();

        Mail::to($asignacion->hogar->email)->send(new SolicitudCancelada($asignacion, $reciclador));
        Mail::to($asignacion->reciclador->email)->send(new SolicitudCancelada($asignacion, $reciclador));
        return redirect()->route('hogar.recoleccionesAprobadas')->with('success', 'La recolección fue cancelada exitosamente.');
    }

    public function cancelarFinalR($id)
    {
        $asignacion = Assignment::findOrFail($id);
        $reciclador = $asignacion->reciclador; 

        $horasFaltantes = Carbon::now()->diffInHours(Carbon::parse($asignacion->assignment_date), false);
    
        if ($horasFaltantes <= 3) {
            return redirect()->back()->with('error', 'Solo puedes cancelar una recolección con más de 3 horas de anticipación.');
        }

        $asignacion->state_id = 1;
        $asignacion->recycler_id = null;
        $asignacion->save();
        Mail::to($asignacion->hogar->email)->send(new SolicitudCancelada($asignacion, $reciclador));
        Mail::to($asignacion->reciclador->email)->send(new SolicitudCancelada($asignacion, $reciclador));
        return redirect()->route('reciclador.recoleccionesAprobadas')->with('success', 'La recolección fue cancelada exitosamente.');
    }
}
