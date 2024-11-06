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

    // Método para actualizar un evento existente en la base de datos.
    public function update(EventRequest $request, string $id)
    {
        $validatedData = $request->validated(); // Valida los datos recibidos usando EventRequest.

        $event = Event::findOrFail($id); // Busca el evento por su id; si no se encuentra, genera un error 404.
        $event->update($validatedData); // Actualiza el evento con los datos validados.

        // Redirige a la lista de eventos con un mensaje de éxito.
        return redirect()->route('events.index')->with('success', 'Evento actualizado exitosamente.');
    }

    // Método para eliminar un evento de la base de datos.
    public function destroy(string $id)
    {
        $event = Event::find($id); // Busca el evento por su id.
        $event->delete(); // Elimina el evento de la base de datos.
        
        // Redirige a la lista de eventos con un mensaje de éxito.
        return redirect()->route("events.index")->with('success', 'Evento eliminado con éxito.');
    }
}
