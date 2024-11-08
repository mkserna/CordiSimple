<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function create($event_id)
    {
        // Buscar el evento usando el ID pasado
        $event = Event::findOrFail($event_id);

        // Obtener el usuario logueado
        $user = Auth::user();

        // Pasar el evento y el usuario a la vista
        return view('reservations.create', compact('event', 'user'));
    }

    //Crear una nueva reserva 
    public function store(Request $request)
    {
        /*   if (!Auth::check()) {
            return redirect()->back()->withErrors(['login' => 'Debes estar logueado para hacer una reserva.'])->withInput();
            
        }

    
        $validatedData = $request->validated();
    
        
        $event = Event::find($validatedData['event_id']);
    
        if (!$event || $event->status == 0) {
            return redirect()->back()->withErrors(['event_id' => 'El evento no está activo o no existe.'])->withInput();
        }
    
        $validatedData['user_id'] = Auth::id();
        Reservation::create($validatedData);
    
        return redirect()->route('reservations.index')->with('success', 'Reservación creada exitosamente.'); */

        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'user_id' => 'required|exists:users,id',
        ]);

        // Crear una nueva reserva
        Reservation::create([
            'event_id' => $validated['event_id'],
            'user_id' => $validated['user_id'],
            'status' => 1, // o el valor por defecto que necesites
        ]);

        // Redirigir o mostrar un mensaje de éxito
        return redirect()->route('reservations.index')->with('success', 'Reserva confirmada exitosamente.');
    }

    //Vista para editar la reservacion
    public function edit(string $id)
    {
        // Verificar que el usuario esté logueado
        if (!Auth::check()) {
            return redirect()->back()->withErrors(['login' => 'Debes estar logueado para editar una reserva.'])->withInput();
        }

        // Buscar la reserva usando el ID pasado
        $reservation = Reservation::findOrFail($id);

        // Verificar si el usuario es el propietario de la reserva o un administrador
        $user = Auth::user();
        if ($user->rols_id != 1 && $reservation->user_id != $user->id) {
            return redirect()->back()->withErrors(['unauthorized' => 'No tienes permiso para editar esta reserva.']);
        }

        // Obtener todos los eventos activos para mostrarlos en el formulario de edición
        $events = Event::where('status', 1)->get();

        // Pasar la reserva y los eventos a la vista de edición
        return view('reservations.edit', compact('reservation', 'events'));
    }


    //Actualizar reservacion
    public function update(Request $request, string $id)
    {
        // Validar que el usuario esté logueado
        if (!Auth::check()) {
            return redirect()->back()->withErrors(['login' => 'Debes estar logueado para actualizar una reserva.'])->withInput();
        }

        // Buscar la reserva usando el ID pasado
        $reservation = Reservation::findOrFail($id);

        // Verificar si el usuario es el propietario de la reserva o un administrador
        $user = Auth::user();
        if ($user->rols_id != 1 && $reservation->user_id != $user->id) {
            return redirect()->back()->withErrors(['unauthorized' => 'No tienes permiso para actualizar esta reserva.']);
        }

        // Validar los datos recibidos
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'status' => 'required|boolean', // Aseguramos que status sea booleano
        ]);

        // Actualizar los campos de la reserva
        $reservation->update([
            'event_id' => $validated['event_id'],
            'status' => $validated['status'],
        ]);

        // Redirigir a la vista de reservas con un mensaje de éxito
        return redirect()->route('reservations.index')->with('success', 'Reserva actualizada exitosamente.');
    }

    public function destroy($id)
    {
        // Encontrar la reserva por ID
        $reservation = Reservation::find($id);

        // Verificar si la reserva existe
        if (!$reservation) {
            return redirect()->route('reservations.index')->with('error', 'La reserva no existe.');
        }

        // Verificar si el usuario actual tiene permiso para eliminar la reserva
        if (Auth::user()->rols_id != 1 && Auth::user()->id != $reservation->user_id) {
            return redirect()->route('reservations.index')->with('error', 'No tienes permiso para eliminar esta reserva.');
        }

        // Eliminar la reserva
        $reservation->delete();

        // Redirigir con un mensaje de éxito
        return redirect()->route('reservations.index')->with('success', 'Reserva eliminada exitosamente.');
    }
}
