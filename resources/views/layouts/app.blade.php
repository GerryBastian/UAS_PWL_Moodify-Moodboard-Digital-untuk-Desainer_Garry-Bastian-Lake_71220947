<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Moodify')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-purple-50 via-pink-50 to-blue-50 min-h-screen">
    
    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-md min-h-screen">
            <div class="p-8">
                <a href="{{ route('moodboards.index') }}" class="flex items-center gap-3 no-underline">
                    <i class="fas fa-palette text-purple-600 text-3xl"></i>
                    <h1 class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                        Moodify
                    </h1>
                </a>
            </div>
            <nav class="mt-8">
                <a href="{{ route('home') }}" class="flex items-center gap-4 px-8 py-4 text-gray-700 hover:bg-gray-100 no-underline {{ request()->routeIs('home') ? 'bg-purple-50 text-purple-600 border-r-4 border-purple-600' : '' }}">
                    <i class="fas fa-home w-6 text-center text-lg"></i>
                    <span class="font-semibold">Home</span>
                </a>
                <a href="{{ route('moodboards.index') }}" class="flex items-center gap-4 px-8 py-4 text-gray-700 hover:bg-gray-100 no-underline {{ request()->routeIs('moodboards.index') ? 'bg-purple-50 text-purple-600 border-r-4 border-purple-600' : '' }}">
                    <i class="fas fa-th-large w-6 text-center text-lg"></i>
                    <span class="font-semibold">Moodboard</span>
                </a>
                <a href="{{ route('users.index') }}" class="flex items-center gap-4 px-8 py-4 text-gray-700 hover:bg-gray-100 no-underline {{ request()->routeIs('users.index') ? 'bg-purple-50 text-purple-600 border-r-4 border-purple-600' : '' }}">
                    <i class="fas fa-users w-6 text-center text-lg"></i>
                    <span class="font-semibold">Users</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="max-w-7xl mx-auto px-4 py-6">
                    <div class="flex items-center justify-end">
                        <div class="flex items-center gap-4">
                            <!-- Guest Links -->
                            @guest
                                <a href="{{ route('login') }}" class="px-4 py-2 text-gray-700 hover:text-purple-600 font-semibold transition-colors">
                                    Login
                                </a>
                                <a href="{{ route('register') }}" class="px-4 py-2 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg hover:shadow-lg transition-all duration-300 font-semibold">
                                    Daftar
                                </a>
                            @endguest
                            
                            <!-- User Dropdown -->
                            @auth
                            <div x-data="{ open: false }" class="relative">
                                <button @click="open = !open" class="flex items-center focus:outline-none gap-2">
                                    <span class="text-sm font-medium text-gray-700 hidden md:block">Hi, {{ Auth::user()->name }}</span>
                                    @php
                                        $userPhoto = Auth::user()->foto 
                                            ? asset('storage/'.Auth::user()->foto) 
                                            : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=9333ea&color=fff&size=128';
                                    @endphp
                                    <img class="w-10 h-10 rounded-full object-cover border-2 border-purple-200" 
                                         src="{{ $userPhoto }}" 
                                         alt="{{ Auth::user()->name }}"
                                         onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=9333ea&color=fff&size=128';">
                                </button>
            
                                <div x-show="open" @click.away="open = false" 
                                     x-transition:enter="transition ease-out duration-100"
                                     x-transition:enter-start="transform opacity-0 scale-95"
                                     x-transition:enter-end="transform opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-75"
                                     x-transition:leave-start="transform opacity-100 scale-100"
                                     x-transition:leave-end="transform opacity-0 scale-95"
                                     class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50"
                                     style="display: none;">
                                    <div class="px-4 py-2 text-sm text-gray-700">
                                        <p class="font-semibold">{{ Auth::user()->name }}</p>
                                        <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                                    </div>
                                    <div class="border-t border-gray-100"></div>
                                    <a href="{{ route('user.profile') }}" class="flex items-center gap-2 w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-user w-4 text-center"></i>
                                        <span>Profile</span>
                                    </a>
                                    <a href="#" class="flex items-center gap-2 w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-cog w-4 text-center"></i>
                                        <span>Setting</span>
                                    </a>
                                    <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                       class="flex items-center gap-2 w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                       <i class="fas fa-sign-out-alt w-4 text-center"></i>
                                       <span>Logout</span>
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                            @endauth
                        </div>
                    </div>
                </div>
            </header>
            <!-- Flash Messages -->
            @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 mt-4">
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            </div>
            @endif

            @if($errors->any())
            <div class="max-w-7xl mx-auto px-4 mt-4">
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif

            <!-- Main Content -->
            <main class="max-w-7xl mx-auto px-4 py-8">
                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="bg-white border-t border-gray-200 mt-12">
                <div class="max-w-7xl mx-auto px-4 py-6 text-center text-gray-600">
                    <p>&copy; 2025 Moodify - Digital Moodboard for Designers</p>
                </div>
            </footer>
        </div>
    </div>
</body>
</html>