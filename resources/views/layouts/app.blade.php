<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TicketFlow</title>
    <!-- Agrega aquí tus enlaces a Tailwind y FontAwesome -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-slate-50 font-sans antialiased">
    <div class="flex min-h-screen">
        <!-- Sidebar (El código que tienes en welcome.blade.php) -->
        <aside class="w-64 bg-white border-r border-gray-200 flex flex-col">
            <!-- ... todo tu código de navegación y logo ... -->
            <div class="p-6 flex items-center gap-3">
                <div class="bg-indigo-600 p-2 rounded-lg text-white">
                    <i class="fas fa-layer-group"></i>
                </div>
                <span class="text-xl font-bold text-slate-800 tracking-tight">TicketFlow</span>
            </div>
            
            <nav class="flex-1 px-4 space-y-2 mt-4">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 p-3 bg-indigo-50 text-indigo-600 rounded-xl font-medium">
                    <i class="fas fa-th-large"></i> Inicio
                </a>
                <!-- Otros enlaces -->
            </nav>

            <!-- Botón Logout -->
            <div class="p-4 border-t border-gray-100">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 p-3 text-slate-400 hover:bg-slate-50 hover:text-red-500 w-full rounded-xl transition-colors">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Contenido Principal -->
        <main class="flex-1 p-8">
            @yield('content')
        </main>
    </div>
</body>
</html>
