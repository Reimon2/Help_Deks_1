<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HelpDesk</title>
    <!-- Usaremos Tailwind para los estilos rápidos como en la imagen -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-slate-50 font-sans antialiased">

    <div class="flex min-h-screen">
        
        <!-- SIDEBAR IZQUIERDO -->
        <aside class="w-64 bg-white border-r border-gray-200 flex flex-col">
            <!-- Logo -->
            <div class="p-6 flex items-center gap-3">
                <div class="bg-indigo-600 p-2 rounded-lg text-white">
                    <i class="fas fa-layer-group"></i>
                </div>
                <span class="text-xl font-bold text-slate-800 tracking-tight">TicketFlow</span>
            </div>

            <!-- Menú de Navegación -->
            <nav class="flex-1 px-4 space-y-2 mt-4">
                <a href="#" class="bg-[#FF822E] flex items-center gap-3 p-3 text-white rounded-xl font-medium transition">
                    <i class="fas fa-th-large"></i> Inicio  
                </a>
                <a href="{{ route('tickets.index') }}" class="flex items-center gap-3 p-3 text-slate-500 hover:bg-slate-50 hover:text-indigo-600 rounded-xl transition">
                    <i class="fas fa-ticket-alt"></i> Todos los Tickets
                </a>
                <a href="#" class="flex items-center gap-3 p-3 text-slate-500 hover:bg-slate-50 hover:text-indigo-600 rounded-xl transition">
                    <i class="fas fa-users"></i> Miembros del Equipo
                </a>
                <a href="#" class="flex items-center gap-3 p-3 text-slate-500 hover:bg-slate-50 hover:text-indigo-600 rounded-xl transition">
                    <i class="fas fa-cog"></i> Configuración
                </a>
            </nav>

            <!-- Botón Logout al final -->
            <div class="p-4 border-t border-gray-100">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 p-3 text-slate-400 hover:text-red-500 w-full transition">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- CONTENIDO PRINCIPAL (DERECHA) -->
        <main class="flex-1 overflow-y-auto">
            
            <!-- NAVBAR SUPERIOR -->
            <header class="bg-white/80 backdrop-blur-md sticky top-0 z-10 px-8 py-4 flex justify-between items-center border-b border-gray-100">
                <h1 class="text-2xl font-bold text-slate-800">Dashboard</h1>
                
                <div class="flex items-center gap-6">
                    <!-- Buscador -->
                    <div class="relative hidden md:block">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" class="block w-full pl-10 pr-3 py-2 border border-slate-200 rounded-lg bg-slate-50 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" placeholder="Search...">
                    </div>
                    
                    <!-- Menú de Usuario -->
                    <div class="flex items-center gap-3 border-l pl-6 border-slate-200">
                        <div class="flex flex-col text-right mr-3">
                            <span class="text-sm font-bold text-slate-700">
                                {{ Auth::user()->name }}
                            </span>
                            <span class="text-[10px] text-slate-400 font-medium capitalize">
                                {{ Auth::user()->role === 'admin' ? 'Administrador' : 'Usuario' }}
                            </span>
                        </div>
                        <img class="h-10 w-10 rounded-full border-2 border-indigo-100" 
                             src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=6366f1&color=fff" alt="">
                    </div>
                </div>
            </header>

            <!-- CONTENIDO DEL DASHBOARD -->
            <div class="p-8 max-w-7xl mx-auto space-y-8">
                
                <!-- BIENVENIDA Y BOTÓN -->
                <div class="flex justify-between items-end">
                    <div>
                        <h2 class="text-3xl font-bold text-slate-800">Welcome {{ explode(' ', Auth::user()->name)[0] }} 👋</h2>
                        <p class="text-slate-500 mt-1">Aquí tienes un resumen del rendimiento de tu soporte técnico.</p>
                    </div>
                    <button onclick="window.location='{{ route('tickets.create') }}'" class="bg-[#F59827] hover:bg-[#df8926] text-white px-6 py-3 rounded-xl font-bold shadow-lg shadow-indigo-200 transition">
                        <i class="fas fa-plus mr-2"></i> Crear Ticket
                    </button>
                </div>

                <!-- Fila de Estadísticas -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    
                    <!-- Total Tickets -->
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-slate-500 font-medium">Total Tickets</p>
                                <h3 class="text-2xl font-bold text-slate-800">{{ $totals['all'] }}</h3>
                            </div>
                            <div class="w-12 h-12 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600">
                                <i class="fas fa-ticket-alt"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- FILTRO PARA ADMINS: Solo ellos ven los otros 3 cuadros -->
                    @if(auth()->user()->role === 'admin')
                    <!-- Tickets Abiertos -->
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-slate-500 font-medium">Tickets Abiertos</p>
                                <h3 class="text-2xl font-bold text-slate-800">{{ $totals['open'] }}</h3>
                            </div>
                            <div class="w-12 h-12 bg-green-50 rounded-2xl flex items-center justify-center text-green-600">
                                <i class="fas fa-folder-open"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Tickets Pendientes -->
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-slate-500 font-medium">Pendientes</p>
                                <h3 class="text-2xl font-bold text-slate-800">{{ $totals['pending'] }}</h3>
                            </div>
                            <div class="w-12 h-12 bg-yellow-50 rounded-2xl flex items-center justify-center text-yellow-600">
                                <i class="fas fa-clock"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Tickets Cerrados -->
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-slate-500 font-medium">Cerrados</p>
                                <h3 class="text-2xl font-bold text-slate-800">{{ $totals['closed'] }}</h3>
                            </div>
                            <div class="w-12 h-12 bg-red-50 rounded-2xl flex items-center justify-center text-red-600">
                                <i class="fas fa-check-double"></i>
                            </div>
                        </div>
                    </div>

                    @endif
                </div>
                
                <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm mb-8">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h4 class="font-bold text-slate-800 text-lg">Ticket Activity</h4>
                            <p class="text-xs text-slate-400">Estadísticas mensuales del año {{ date('Y') }}</p>
                        </div>
                        <span class="text-xs font-medium text-slate-500 bg-slate-50 px-3 py-1 rounded-lg">Anual</span>
                    </div>
    
                    <!-- El lienzo donde se dibujará la gráfica -->
                    <div class="h-[300px]">
                        <canvas id="ticketActivityChart"></canvas>
                    </div>
                </div>

                <!-- ZONA DE GRÁFICOS Y LISTA (Aquí irán tus tablas y charts) -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Tabla de Tickets (Ocupa 2 columnas) -->
                    <div class="lg:col-span-2 bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
                        <div class="flex justify-between items-center mb-6">
                            <!-- En la parte de la tabla, cambia el título así: -->
                            <h4 class="font-bold text-slate-800 text-lg">
                                {{ auth()->user()->role === 'admin' ? 'Lista General de Tickets' : 'Mis Tickets' }}
                            </h4>
                            <a href="#" class="text-indigo-600 font-medium text-sm hover:underline">Ver todo</a>
                        </div>
                <!-- Aquí pones tu tabla de registros -->
                <div class="mt-4 overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                            <tr class="text-slate-400 text-xs uppercase tracking-wider border-b border-slate-50">
                                <th class="pb-3 font-medium">Asunto</th>
                                <th class="pb-3 font-medium">Departamento</th>
                                <th class="pb-3 font-medium text-center">Prioridad</th>
                                <th class="pb-3 font-medium text-right">Estado</th>
                            </tr>
                            </thead>
                <tbody class="text-sm">
                @forelse($tickets as $ticket)
                    <tr class="border-b border-slate-50 last:border-0 hover:bg-slate-50 transition">
                        <td class="py-4 font-semibold text-slate-700">{{ $ticket->subject }}</td>
                        <td class="py-4 text-slate-500">{{ $ticket->department }}</td>
                        <td class="py-4 text-center">
                            <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase
                                {{ $ticket->priority == 'high' ? 'bg-red-100 text-red-600' : 
                                ($ticket->priority == 'medium' ? 'bg-yellow-100 text-yellow-600' : 'bg-blue-100 text-blue-600') }}">
                                {{ $ticket->priority }}
                            </span>
                        </td>
                        <td class="py-4 text-right">
                            <span class="text-indigo-600 font-bold">Abierto</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-10 text-center text-slate-400 italic">
                            No hay tickets registrados aún.
                        </td>
                    </tr>
                @endforelse
                    </tbody>
                    </table>
                </div>
            </div>
        </main>

    </div>

    <!-- Mostrar mensaje de éxito -->
    @if (session('status'))
        <div id="status-alert" class="fixed bottom-5 right-5 bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-xl shadow-lg z-50 transition-opacity duration-500">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                <span>{{ session('status') }}</span>
            </div>
        </div>
    @endif

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Buscamos el mensaje verde por su ID
        const alert = document.getElementById('status-alert');
        
        if (alert) {
            // Esperar 5000ms (5 segundos)
            setTimeout(function() {
                // Efecto de desvanecimiento
                alert.style.opacity = '0';
                
                // Eliminarlo del HTML después del efecto
                setTimeout(function() {
                    alert.remove();
                }, 500);
            }, 5000);
        }
    });
    </script>

    <script>
    const ctx = document.getElementById('ticketActivityChart').getContext('2d');
    
    new Chart(ctx, {
        type: 'line',
        data: {
            // Nombres de los meses
            labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
            datasets: [{
                label: 'Tickets Abiertos',
                // Pasamos los datos del controlador a JS
                data: @json($chartTotal), 
                borderColor: '#4f46e5',
                backgroundColor: 'rgba(79, 70, 229, 0.1)',
                fill: true,
                tension: 0.4
            }, {
                label: 'Tickets Cerrados',
                data: @json($chartClosed),
                borderColor: '#10b981',
                backgroundColor: 'transparent',
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top', // O 'bottom' según prefieras
                    align: 'center',
                    labels: {
                        // ESTO CREA EL CÍRCULO
                        usePointStyle: true, 
                        pointStyle: 'circle',
                        padding: 20,
                        boxWidth: 10, // Tamaño del círculo
                        boxHeight: 10,
                        font: {
                            size: 12,
                            weight: '500'
                        },
                        color: '#64748b' // Color slate-500 para el texto
                    },
                    // Opcional: Esto hace que al pasar el mouse el cursor cambie a "pointer"
                    onHover: (event, legendItem, legend) => {
                        event.native.target.style.cursor = 'pointer';
                    },
                    onLeave: (event, legendItem, legend) => {
                        event.native.target.style.cursor = 'default';
                    }
                }
            },
            scales: {
                y: { 
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });
    </script>
    
</body>
</html>