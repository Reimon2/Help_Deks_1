<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Ticket;
use App\Http\Controllers\TicketController;


Route::get('/', function () {
    return redirect('/login');
});

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('welcome'); // Tu página de soporte
    })->name('dashboard');
});


// RUTA PARA VER Y CREAR TICKETS (Todo en una sola)
Route::match(['get', 'post'], '/tickets/create', function (Illuminate\Http\Request $request) {
    if ($request->isMethod('post')) {
        return (new App\Http\Controllers\TicketController)->store($request);
    }
    return view('tickets.create');
})->middleware(['auth'])->name('tickets.create');


// RUTA DEL DASHBOARD (Para ver los tickets creados)
Route::get('/dashboard', function () {
    $user = auth()->user();
    
    // 1. LOS TOTALES (Igual para todos: Admin y Usuario ven el volumen total)
    $totals = [
        'all' => \App\Models\Ticket::count(),
        'open' => \App\Models\Ticket::where('status', 'open')->count(),
        'pending' => \App\Models\Ticket::where('status', 'pending')->count(),
        'closed' => \App\Models\Ticket::where('status', 'closed')->count(),
    ];

    // 2. Datos para la Gráfica (Agrupados por mes)
    // Obtenemos conteos mensuales para 'Abiertos' (creados) y 'Cerrados'
    $monthlyData = Ticket::select(
        DB::raw('MONTH(created_at) as month'),
        DB::raw('COUNT(*) as total'),
        DB::raw('SUM(CASE WHEN status = "closed" THEN 1 ELSE 0 END) as closed')
    )
    ->whereYear('created_at', date('Y'))
    ->groupBy('month')
    ->orderBy('month')
    ->get();

    // Preparamos arreglos de 12 posiciones (Ene a Dic) con ceros por defecto
    $chartTotal = array_fill(0, 12, 0);
    $chartClosed = array_fill(0, 12, 0);

    foreach ($monthlyData as $data) {
        $chartTotal[$data->month - 1] = $data->total;
        $chartClosed[$data->month - 1] = (int)$data->closed;
    }

    // 3. Filtro de la tabla inferior
    $tickets = ($user->role === 'admin') 
        ? Ticket::latest()->get() 
        : Ticket::where('user_id', $user->id)->latest()->get();

    return view('welcome', compact('tickets', 'totals', 'chartTotal', 'chartClosed'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/tickets', [App\Http\Controllers\TicketController::class, 'index'])->name('tickets.index');

//Route::middleware('auth')->group(function () {
    //Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    //Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    //Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
//});

Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
Route::patch('/tickets/{ticket}/status', [TicketController::class, 'updateStatus'])->name('tickets.updateStatus');
Route::delete('/tickets/{ticket}', [TicketController::class, 'destroy'])->name('tickets.destroy');
// Ruta para que el técnico envíe el ticket a escalado
Route::post('/tickets/{ticket}/escalar', [TicketController::class, 'escalar'])->name('tickets.escalar');

// Ruta para que el admin/analista procese el cambio de dificultad y reasigne
Route::post('/tickets/{ticket}/resolver-escalado', [TicketController::class, 'resolverEscalado'])->name('tickets.resolver.escalado');

require __DIR__.'/auth.php';
