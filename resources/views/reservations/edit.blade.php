@extends('layouts.personal')

@section('content')
<body class="bg-black">
    
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-bold text-center text-yellow-500 mb-6">Editar Reserva</h1>

        <div class="shadow-md rounded-lg overflow-hidden">
            <div class="px-8 py-8">
                <!-- Mostrar detalles del evento -->
                <div class="mb-4">
                    <p class="text-xl font-semibold text-yellow-500 mb-2">Detalles del Evento:</p>
                    <p class="text-gray-500"><strong>Nombre del Evento:</strong><span class="text-gray-300">{{ $reservation->event->name }}</span></p>
                    <p class="text-gray-500"><strong>Descripción:</strong> <span class="text-gray-300">{{ $reservation->event->description }}</span></p>
                    <p class="text-gray-500"><strong>Fecha de inicio:</strong><span class="text-gray-300">{{ $reservation->event->date_start }}</span></p>
                    <p class="text-gray-500"><strong>Fecha de finalización:</strong><span class="text-gray-300">{{ $reservation->event->date_end }}</span></p>
                    <p class="text-gray-500"><strong>Ubicación:</strong> <span class="text-gray-300">{{ $reservation->event->location }}</span></p>
                </div>

                <!-- Mostrar detalles de la reserva (usuario) -->
                <div class="mb-4">
                    <p class="text-xl font-semibold text-yellow-500 mb-2">Detalles de tu Reserva:</p>
                    <p class="text-gray-700"><strong>Usuario:</strong><span class="text-gray-300">{{ $reservation->user->name }}</span></p>
                    <p class="text-gray-700"><strong>Correo:</strong> <span class="text-gray-300">{{ $reservation->user->email }}</span></p>
                </div>

                <!-- Formulario de edición de reserva -->
                <form action="{{ route('reservations.update', $reservation->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="event_id" class="text-gray-500"><strong>Seleccionar Evento:</strong></label>
                        <select name="event_id" id="event_id" class="text-gray-300 bg-gray-700 border-none rounded w-full p-2">
                            @foreach($events as $event)
                                <option value="{{ $event->id }}" {{ $reservation->event_id == $event->id ? 'selected' : '' }}>
                                    {{ $event->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="status" class="text-gray-500"><strong>Estado de la Reserva:</strong></label>
                        <select name="status" id="status" class="text-gray-300 bg-gray-700 border-none rounded w-full p-2">
                            <option value="1" {{ $reservation->status == 1 ? 'selected' : '' }}>Confirmado</option>
                            <option value="0" {{ $reservation->status == 0 ? 'selected' : '' }}>Cancelado</option>
                        </select>
                    </div>

                    <div class="flex justify-end">
                        <a href="{{ route('reservations.index') }}" class="text-white px-4 py-2 rounded hover:bg-gray-600 mr-2">Cancelar</a>
                        <button type="submit" class="text-white px-4 py-2 rounded hover:bg-yellow-500">Actualizar Reserva</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal para mensajes de error de login --}}
    @if ($errors->has('login'))
        <div id="login-error-modal" class="fixed inset-0 flex items-center justify-center z-50" style="background-color: rgba(0, 0, 0, 0.5);">
            <div class="bg-white rounded-lg shadow-lg p-6 max-w-sm w-full">
                <h2 class="text-lg font-bold text-red-700">Error</h2>
                <p class="mt-2 text-gray-700">{{ $errors->first('login') }}</p>
                <div class="mt-4 flex justify-between">
                    <button onclick="document.getElementById('login-error-modal').style.display='none'" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">Permanecer sin loguear</button>
                    <a href="{{ route('login') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Loguearme</a>
                </div>
            </div>
        </div>
    @endif
@endsection
</body>
