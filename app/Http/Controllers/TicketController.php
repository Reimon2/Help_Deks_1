<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Ticket;

class TicketController extends Controller
{
    public function store(Request $request)
    {
        // Guardar datos
        Ticket::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'subject' => $request->subject,
            'priority' => $request->priority,
            'department' => $request->department,
            'description' => $request->description,
        ]);

        // Redirigir al dashboard
        return redirect()->route('dashboard')->with('status', 'Ticket creado con éxito');
    }

    public function index(Request $request)
    {
        $query = Ticket::query();

        // Filtro de búsqueda (opcional por ahora)
        if ($request->has('search')) {
            $query->where('subject', 'like', '%' . $request->search . '%');
        }

        // Obtenemos los tickets con paginación (como en la imagen que tiene "Page 1 of 12")
        $tickets = $query->with('user')->latest()->paginate(10);

        return view('tickets.index', compact('tickets'));
    }

    // app/Http/Controllers/TicketController.php

    public function show(Ticket $ticket)
    {
        return view('tickets.show', compact('ticket'));
    }

    public function updateStatus(Request $request, Ticket $ticket)
    {
        // Esto cambia el estado y regresa a la tabla
        $ticket->update(['status' => $request->status]);
        return back()->with('status', 'Ticket actualizado');
    }

    public function destroy(Ticket $ticket)
    {
        // Esto borra el ticket de la base de datos
        $ticket->delete();
        return back()->with('status', 'Ticket eliminado');
    }

    // Función para el Técnico
    public function escalar(Request $request, Ticket $ticket)
    {
        // Cambiamos el estado a escalado y guardamos la razón del problema
        $ticket->update([
            'status' => 'escalado',
            'comentario_escalado' => $request->comentario_escalado
        ]);

        return redirect()->back()->with('success', 'El ticket ha sido escalado al Administrador.');
    }

    // Función para el Admin y Analista
    public function resolverEscalado(Request $request, Ticket $ticket)
    {
        // El admin cambia la dificultad y reasigna el ticket a otro técnico (user_id)
        $ticket->update([
            'status' => 'en_progreso', // Vuelve a estar activo
            'dificultad' => $request->dificultad,
            'user_id' => $request->user_id, // Nuevo técnico asignado
        ]);

        return redirect()->back()->with('success', 'Ticket actualizado y reasignado con éxito.');
    }
    
}