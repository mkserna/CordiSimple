<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Http\Requests\EventRequest;

class EventController extends Controller
{
    // Método para almacenar un nuevo evento en la base de datos.
    public function store(EventRequest $request)
    {
        $validatedData = $request->validated(); // Valida los datos recibidos usando EventRequest.
        $validatedData['occupied_slots'] = 0; // Inicializa los lugares ocupados en cero.
        Event::create($validatedData); // Crea el evento en la base de datos usando los datos validados.

        // Redirige a la lista de eventos con un mensaje de éxito.
        return redirect()->route('events.index')->with('success', 'Evento creado exitosamente.');
    }
}
