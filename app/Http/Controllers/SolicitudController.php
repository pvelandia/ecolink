<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assignment;
use App\Models\Material;
use App\Models\AssignmentMaterial;

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
        return redirect()->route('hogar')->with('success', '¡Recolección solicitada correctamente!');
    }

    // Método para mostrar las solicitudes pendientes
    public function index()
{
    // Obtener las solicitudes con estado '1' (pendiente) y cargar los materiales asociados
    $solicitudes = Assignment::where('state_id', 1) // Asegúrate de que 'state_id' es el nombre correcto de la columna
                                ->with('materials') // Relacionar los materiales
                                ->get();

    // Pasar la variable $solicitudes a la vista
    return view('reciclador.solicitudes', compact('solicitudes'));
}


    // Método para ver los detalles de una solicitud
    public function show($id)
    {
        // Buscar la solicitud por ID, asegurando que esté cargado el material
        $solicitud = Assignment::with('materials')->findOrFail($id);

        return view('reciclador.solicitudesDetalle', compact('solicitud'));
    }
}
