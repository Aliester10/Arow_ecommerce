<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - ARO Ecommerce</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .sidebar-link.active {
            background-color: #F7931E;
            color: white;
        }
    </style>
</head>

<body class="bg-gray-50 flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <aside class="w-64 bg-slate-900 text-white flex-shrink-0 flex flex-col h-full shadow-xl z-30">
        <!-- Logo -->
        <div class="p-6 border-b border-slate-800 flex items-center gap-3">
            <div class="w-8 h-8 bg-orange-500 rounded flex items-center justify-center font-bold text-lg">A</div>
            <span class="text-xl font-bold tracking-tight">Admin<span class="text-orange-500">Panel</span></span>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
            <a href="{{ route('admin.dashboard') }}"
                class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg transition-colors hover:bg-slate-800 text-slate-300 {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home w-5"></i>
                <span class="font-medium">Dashboard</span>
            </a>

            <div class="pt-4 pb-2 px-4 uppercase text-[10px] font-bold text-slate-500 tracking-widest">Manajemen Konten
            </div>

            <a href="{{ route('admin.products.index') }}"
                class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg transition-colors hover:bg-slate-800 text-slate-300 {{ Request::routeIs('admin.products.*') ? 'active' : '' }}">
                <i class="fas fa-box w-5"></i>
                <span class="font-medium">Kelola Produk</span>
            </a>

            <a href="{{ route('admin.brands.index') }}"
                class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg transition-colors hover:bg-slate-800 text-slate-300 {{ Request::routeIs('admin.brands.*') ? 'active' : '' }}">
                <i class="fas fa-store w-5"></i>
                <span class="font-medium">Kelola Brand</span>
            </a>

            <a href="{{ route('admin.banners.index') }}"
                class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg transition-colors hover:bg-slate-800 text-slate-300 {{ Request::routeIs('admin.banners.*') ? 'active' : '' }}">
                <i class="fas fa-images w-5"></i>
                <span class="font-medium">Kelola Banner</span>
            </a>

            <div class="pt-8 border-t border-slate-800 mt-8">
                <a href="{{ route('home') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-400 hover:text-white transition-colors">
                    <i class="fas fa-external-link-alt w-5"></i>
                    <span>Kembali ke Toko</span>
                </a>
            </div>
        </nav>

        <!-- User Info -->
        <div class="p-4 border-t border-slate-800 bg-slate-900/50">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-orange-600 flex items-center justify-center text-white font-bold">
                    {{ substr(Auth::user()->nama_user ?? 'A', 0, 1) }}
                </div>
                <div class="overflow-hidden">
                    <p class="text-sm font-bold truncate">{{ Auth::user()->nama_user ?? 'Admin' }}</p>
                    <p class="text-[10px] text-slate-400 truncate">{{ Auth::user()->email ?? 'admin@example.com' }}</p>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST" class="mt-3">
                @csrf
                <button type="submit"
                    class="w-full py-1.5 text-xs bg-slate-800 hover:bg-red-600/20 hover:text-red-400 rounded transition-all text-slate-400 font-medium">
                    <i class="fas fa-sign-out-alt mr-1"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-full overflow-hidden">
        <!-- Header -->
        <header class="h-16 bg-white border-b flex items-center justify-between px-8 shadow-sm z-20">
            <h2 class="text-xl font-semibold text-gray-800">
                @yield('header_title', 'Admin Panel')
            </h2>
            <div class="flex items-center gap-4">
                <span class="text-sm text-gray-500 font-medium">{{ now()->format('l, d M Y') }}</span>
            </div>
        </header>

        <!-- Page Content -->
        <div class="flex-1 overflow-y-auto p-8">
            @yield('content')
        </div>
    </main>

</body>

</html>