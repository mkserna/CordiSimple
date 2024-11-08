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
}
