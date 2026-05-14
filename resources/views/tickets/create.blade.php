<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Ticket - TicketFlow</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-slate-50 font-sans antialiased">

    <div class="flex min-h-screen">
        <!-- SIDEBAR (Mismo que el Home) -->
        <aside class="w-64 bg-white border-r border-gray-200 flex flex-col">
            <div class="p-6 flex items-center gap-3">
                <div class="bg-indigo-600 p-2 rounded-lg text-white"><i class="fas fa-layer-group"></i></div>
                <span class="text-xl font-bold text-slate-800 tracking-tight">TicketFlow</span>
            </div>
            <nav class="flex-1 px-4 space-y-2 mt-4">
                <a href="/dashboard" class="flex items-center gap-3 p-3 text-slate-500 hover:bg-slate-50 hover:text-indigo-600 rounded-xl transition">
                    <i class="fas fa-th-large"></i> Dashboard
                </a>
                <a href="#" class="flex items-center gap-3 p-3 bg-indigo-50 text-indigo-600 rounded-xl font-medium transition">
                    <i class="fas fa-ticket-alt"></i> Create Ticket
                </a>
            </nav>
        </aside>

        <!-- CONTENIDO -->
        <main class="flex-1">
            <!-- Header simple -->
            <header class="px-8 py-4 flex justify-between items-center border-b border-gray-100 bg-white">
                <h1 class="text-xl font-bold text-slate-800">Nuevo Ticket</h1>
                <a href="/dashboard" class="text-slate-400 hover:text-slate-600 transition text-sm font-medium">
                    <i class="fas fa-arrow-left mr-1"></i> Dashboard
                </a>
            </header>

            <div class="p-8 max-w-3xl mx-auto">
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8">
                    <h2 class="text-2xl font-bold text-slate-800 mb-6">Información del Ticket</h2>
                    
                    <!-- CAMBIA ESTO -->
                    <form action="/tickets/create" method="POST" class="space-y-6">
                        @csrf

                        <!-- Fila de Nombre y Apellido -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Nombre</label>
                                <input type="text" name="name" placeholder="Ej. Juan" 
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Apellido</label>
                                <input type="text" name="last_name" placeholder="Ej. Pérez" 
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                            </div>
                        </div>

                        <!-- Asunto -->
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Asunto</label>
                            <input type="text" name="subject" placeholder="¿Cuál es el problema?" 
                                   class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                        </div>

                        <!-- Prioridad y Departamento -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Prioridad</label>
                                <select name="priority" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition text-slate-600">
                                    <option value="low">Baja</option>
                                    <option value="medium">Media</option>
                                    <option value="high">Alta</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Departamento</label>
                                <input type="text" name="department" placeholder="Ej. Contabilidad, Ventas..." 
                                       class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                            </div>
                        </div>

                        <!-- Descripción -->
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Descripción</label>
                            <textarea name="description" rows="5" placeholder="Explica el problema con detalle..." 
                                      class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"></textarea>
                        </div>

                        <!-- Botones -->
                        <div class="flex gap-4 pt-4">
                            <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-xl shadow-lg shadow-indigo-100 transition">
                                Crear
                            </button>
                            <a href="/dashboard" class="flex-1 text-center bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold py-3 rounded-xl transition">
                                Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

</body>
</html>