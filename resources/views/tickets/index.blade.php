@extends('layouts.app')

@section('content')
<div class="p-8 bg-[#f8fafc] min-h-screen">
    <!-- Encabezado de sección -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Support Request</h2>
            <p class="text-sm text-slate-500">Gestiona y organiza todos los tickets de soporte.</p>
        </div>
        <button class="bg-[#F59827] text-white px-4 py-2 rounded-xl font-semibold shadow-sm hover:bg-[#df8926] transition">
            Create Ticket
        </button>
    </div>

    <!-- Barra de Filtros (Look de la imagen) -->
    <div class="bg-white p-4 rounded-t-2xl border-x border-t border-slate-100 flex flex-wrap gap-4 items-center justify-between">
        <div class="flex gap-4 items-center">
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                    <i class="fas fa-search"></i>
                </span>
                <input type="text" placeholder="Search Ticket" class="pl-10 pr-4 py-2 bg-slate-50 border-none rounded-lg text-sm w-64 focus:ring-2 focus:ring-orange-500">
            </div>
            <select class="bg-slate-50 border-none rounded-lg text-sm py-2 px-4 text-slate-600">
                <option>Last 30 days</option>
            </select>
            <select class="bg-slate-50 border-none rounded-lg text-sm py-2 px-4 text-slate-600">
                <option>Priority</option>
            </select>
        </div>
        <button class="text-slate-600 font-medium text-sm flex items-center gap-2 border border-slate-200 px-4 py-2 rounded-lg">
            <i class="fas fa-filter"></i> Filter
        </button>
    </div>

    <!-- Tabla de Tickets -->
    <div class="bg-white rounded-b-2xl border border-slate-100 overflow-hidden shadow-sm">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 text-slate-500 text-xs uppercase font-semibold">  
                <tr>
                    <th class="px-6 py-4"><input type="checkbox" class="rounded text-orange-500"></th>
                    <th class="px-6 py-4">Ticket ID</th>
                    <th class="px-6 py-4">Sujeto</th>
                    <th class="px-6 py-4">Prioridad</th>
                    <th class="px-6 py-4">Cliente</th>
                    <th class="px-6 py-4">Fecha</th>
                    <th class="px-6 py-4">Estado</th>
                    <th class="px-6 py-4">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50 text-sm">
                @foreach($tickets as $ticket)
                <tr class="hover:bg-slate-50/50 transition">
                    <td class="px-6 py-4"><input type="checkbox" class="rounded text-orange-500"></td>
                    <td class="px-6 py-4 font-medium text-slate-700">#TD-{{ $ticket->id }}</td>
                    <td class="px-6 py-4 text-slate-600">{{ $ticket->subject }}</td>
                    <td class="px-6 py-4">
                        @php
                            $priorityColors = [
                                'low' => 'bg-emerald-50 text-emerald-600',
                                'medium' => 'bg-amber-50 text-amber-600',
                                'high' => 'bg-rose-50 text-rose-600'
                            ];
                        @endphp
                        <span class="px-3 py-1 rounded-full text-[11px] font-bold uppercase {{ $priorityColors[$ticket->priority] ?? 'bg-slate-100' }}">
                            {{ $ticket->priority }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <div class="h-7 w-7 rounded-full bg-slate-200 flex items-center justify-center text-[10px] font-bold">
                                {{ substr($ticket->user?->name ?? 'NA', 0, 2) }}
                            </div>
                            <span class="text-slate-700 font-medium">{{ $ticket->user?->name ?? 'Usuario no asignado' }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-slate-500">{{ $ticket->created_at->format('d M Y') }}</td>
                    <td class="px-6 py-4 uppercase text-[10px] font-bold text-indigo-600">{{ $ticket->status }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <!-- Ver Ticket -->
                            <a href="{{ route('tickets.show', $ticket->id) }}" class="text-slate-400 hover:text-indigo-600 transition" title="Leer Ticket">
                                <i class="fas fa-eye"></i>
                            </a>
                            <!-- Cambiar Estado (Cerrar/Abrir) -->
                            <form action="{{ route('tickets.updateStatus', $ticket->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                @if($ticket->status == 'open')
                                    <button type="submit" name="status" value="closed" class="text-slate-400 hover:text-emerald-600 transition" title="Cerrar Ticket">
                                        <i class="fas fa-check-circle"></i>
                                    </button>
                                @else
                                    <button type="submit" name="status" value="open" class="text-slate-400 hover:text-amber-600 transition" title="Reabrir Ticket">
                                        <i class="fas fa-undo"></i>
                                    </button>
                                @endif
                            </form>

                            <!-- Eliminar Ticket -->
                            <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar este ticket?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-slate-400 hover:text-rose-600 transition" title="Eliminar Ticket">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <!-- Paginación Estilo la imagen -->
        <div class="p-6 border-t border-slate-50 flex justify-between items-center">
            <p class="text-sm text-slate-500">Page {{ $tickets->currentPage() }} of {{ $tickets->lastPage() }}</p>
            <div class="flex gap-2">
                {{ $tickets->links() }}
            </div>
        </div>
    </div>
</div>
@endsection