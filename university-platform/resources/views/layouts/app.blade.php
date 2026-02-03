<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'EduPlatform')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { darkMode: 'class' }
    </script>
    <link rel="icon" href="https://tse3.mm.bing.net/th/id/OIP.8tZ9iwt1pCAJVUarYDZhTQHaHa?pid=Api&P=0&h=180" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <style>
        [x-cloak] { display: none !important; }
        .user-avatar-navbar {
            width: 40px !important; height: 40px !important;
            min-width: 40px; min-height: 40px;
            border-radius: 50% !important; object-fit: cover !important;
            border: 2px solid #6366f1; background: #f3f4f6;
        }
        #mobile-menu {
            transition: all 0.3s ease-in-out;
            max-height: 0; overflow: hidden; opacity: 0;
        }
        #mobile-menu.show { max-height: 100vh; opacity: 1; padding-bottom: 20px; }
    </style>
</head>

<body class="bg-gray-50 dark:bg-slate-900 transition-colors duration-300 min-h-screen">
    <nav class="bg-white/90 dark:bg-slate-800/90 backdrop-blur-md shadow-md fixed top-0 w-full z-[100] border-b dark:border-slate-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                
                <div class="flex-shrink-0">
                    <span class="text-2xl font-black text-indigo-600 uppercase italic tracking-tighter">
                        EDU<span class="text-slate-800 dark:text-white">PLATFORM</span>
                    </span>
                </div>

                <div class="hidden md:flex items-center space-x-4">
                    <a href="{{ route('filier.index') }}" class="text-slate-600 dark:text-slate-300 hover:text-indigo-600 font-bold transition">Filières</a>
                    <a href="{{ route('modules.index') }}" class="text-slate-600 dark:text-slate-300 hover:text-indigo-600 font-bold transition">Modules</a>

                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false" class="flex items-center text-slate-600 dark:text-slate-300 font-bold hover:text-indigo-600 transition">
                            Courses <i class="fas fa-chevron-down ml-1 text-[10px] transition" :class="open ? 'rotate-180' : ''"></i>
                        </button>
                        <div x-show="open" x-cloak class="absolute left-0 mt-3 w-48 bg-white dark:bg-slate-800 shadow-xl rounded-xl border dark:border-slate-700 py-2">
                            <a href="{{ route('courses.index') }}" class="block px-4 py-2 hover:bg-indigo-50 dark:hover:bg-slate-700 text-sm">📘 All Courses</a>
                            <a href="{{ route('exercises.index') }}" class="block px-4 py-2 hover:bg-indigo-50 dark:hover:bg-slate-700 text-sm">📝 Exercises</a>
                            <a href="{{ route('exames.index') }}" class="block px-4 py-2 hover:bg-indigo-50 dark:hover:bg-slate-700 text-sm">🎓 Exams</a>
                        </div>
                    </div>

                    <a href="{{ route('messages.index') }}" class="text-slate-600 dark:text-slate-300 hover:text-indigo-600 font-bold transition">Chat</a>

                    <div class="flex items-center space-x-3 border-l dark:border-slate-700 pl-4">
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" @click.away="open = false" class="text-slate-500 dark:text-slate-400 hover:text-indigo-600 transition p-2 relative">
                                <i class="fas fa-bell text-xl"></i>
                                @if(Auth::check() && Auth::user()->unreadNotifications->count() > 0)
                                    <span class="absolute top-1 right-1 bg-red-500 text-white text-[10px] rounded-full h-4 w-4 flex items-center justify-center border-2 border-white dark:border-slate-800">
                                        {{ Auth::user()->unreadNotifications->count() }}
                                    </span>
                                @endif
                            </button>
                            <div x-show="open" x-cloak class="absolute right-0 mt-2 w-72 bg-white dark:bg-slate-800 shadow-2xl rounded-xl border dark:border-slate-700 overflow-hidden">
                                <div class="p-3 text-xs font-bold border-b dark:border-slate-700 uppercase flex justify-between items-center">
                                    <span>Latest Notifications</span>
                                    <i class="fas fa-bullhorn text-indigo-500"></i>
                                </div>
                                <div class="max-h-60 overflow-y-auto">
                                    @auth
                                        @forelse(Auth::user()->unreadNotifications->take(5) as $n)
                                            <div class="p-3 text-xs border-b dark:border-slate-700 hover:bg-gray-50 dark:hover:bg-slate-700 transition">
                                                {{ $n->data['message'] ?? 'New update' }}
                                                <div class="text-[10px] text-gray-400 mt-1">{{ $n->created_at->diffForHumans() }}</div>
                                            </div>
                                        @empty
                                            <div class="p-6 text-center text-xs text-gray-400">No new notifications</div>
                                        @endforelse
                                    @endauth
                                </div>
                                <a href="{{ route('notifications.index') }}" class="block p-3 text-center text-xs font-bold text-indigo-600 hover:bg-indigo-50 dark:hover:bg-slate-700 transition">
                                    View All Notifications <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>

                        <button id="dark-mode-toggle" class="p-2 text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-lg transition">
                            <i id="dark-mode-icon" class="fas fa-moon text-xl"></i>
                        </button>
                    </div>

                    @auth
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" @click.away="open = false">
                                @php
                                    $userAvatar = Auth::user()->avatar;
                                    $fullName = Auth::user()->first_name . ' ' . Auth::user()->last_name;
                                    $path = "https://university-platform.infinityfreeapp.com/storage/app/public/";
                                    $finalImg = $userAvatar ? $path . $userAvatar : "https://ui-avatars.com/api/?name=" . urlencode($fullName) . "&background=6366f1&color=fff";
                                @endphp
                                <img src="{{ $finalImg }}" 
                                     onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($fullName) }}&background=6366f1&color=fff'"
                                     class="user-avatar-navbar hover:scale-105 transition">
                            </button>
                            <div x-show="open" x-cloak class="absolute right-0 mt-3 w-48 bg-white dark:bg-slate-800 shadow-xl rounded-xl border dark:border-slate-700 overflow-hidden">
                                <a href="{{ route('profile.show') }}" class="block px-4 py-3 text-sm hover:bg-slate-50 dark:hover:bg-slate-700 border-b dark:border-slate-700 font-bold"><i class="fas fa-user-circle mr-2"></i> Profile</a>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button class="w-full text-left px-4 py-3 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 font-bold"><i class="fas fa-power-off mr-2"></i> Logout</button>
                                </form>
                            </div>
                        </div>
                    @endauth
                </div>

                <div class="md:hidden flex items-center space-x-3">
                    <button id="dark-mode-toggle-mobile" class="text-slate-500 dark:text-slate-400 p-2"><i class="fas fa-moon text-lg"></i></button>
                    <button id="mobile-btn" class="p-2 text-slate-700 dark:text-white"><i class="fas fa-bars text-2xl"></i></button>
                </div>
            </div>
        </div>

        <div id="mobile-menu" class="md:hidden bg-white dark:bg-slate-800 border-t dark:border-slate-700 shadow-inner">
            <div class="px-4 py-6 space-y-4">
                <a href="{{ route('filier.index') }}" class="block text-lg font-bold text-slate-700 dark:text-slate-200">Filières</a>
                <a href="{{ route('modules.index') }}" class="block text-lg font-bold text-slate-700 dark:text-slate-200">Modules</a>
                
                <div x-data="{ open: false }">
                    <button @click="open = !open" class="flex justify-between items-center w-full text-lg font-bold text-slate-700 dark:text-slate-200">
                        Courses <i class="fas fa-chevron-down text-sm transition" :class="open ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="open" x-cloak class="mt-2 ml-4 space-y-3 border-l-2 border-indigo-500 pl-4">
                        <a href="{{ route('courses.index') }}" class="block text-slate-600 dark:text-slate-400 font-medium">📘 All Courses</a>
                        <a href="{{ route('exercises.index') }}" class="block text-slate-600 dark:text-slate-400 font-medium">📝 Exercises</a>
                        <a href="{{ route('exames.index') }}" class="block text-slate-600 dark:text-slate-400 font-medium">🎓 Exams</a>
                    </div>
                </div>

                <a href="{{ route('messages.index') }}" class="block text-lg font-bold text-slate-700 dark:text-slate-200">Chat</a>
                
                <a href="{{ route('notifications.index') }}" class="flex justify-between items-center text-lg font-bold text-slate-700 dark:text-slate-200">
                    Notifications
                    @if(Auth::check() && Auth::user()->unreadNotifications->count() > 0)
                        <span class="bg-red-500 text-white text-xs rounded-full px-2 py-0.5">{{ Auth::user()->unreadNotifications->count() }}</span>
                    @endif
                </a>

                @auth
                    <div class="pt-6 border-t dark:border-slate-700 mt-4">
                        <div class="flex items-center space-x-3 mb-6">
                            <img src="{{ $finalImg }}" 
                                 onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($fullName) }}&background=6366f1&color=fff'"
                                 class="user-avatar-navbar">
                            <span class="font-black dark:text-white uppercase">{{ Auth::user()->first_name }}</span>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <a href="{{ route('profile.show') }}" class="bg-indigo-600 text-white py-3 rounded-xl text-center font-bold">Profile</a>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="w-full border-2 border-red-500 text-red-500 py-3 rounded-xl font-bold">Logout</button>
                            </form>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    <div class="pt-24 min-h-screen">
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @yield('content')
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const btn = document.getElementById('mobile-btn');
            const menu = document.getElementById('mobile-menu');
            if(btn) btn.onclick = () => menu.classList.toggle('show');

            const html = document.documentElement;
            const applyTheme = (dark) => {
                html.classList.toggle('dark', dark);
                const iconClass = dark ? 'fa-sun text-yellow-400' : 'fa-moon';
                document.querySelectorAll('#dark-mode-icon, #dark-mode-toggle-mobile i').forEach(i => i.className = `fas ${iconClass} text-xl`);
                localStorage.setItem('theme', dark ? 'dark' : 'light');
            };

            const saved = localStorage.getItem('theme');
            applyTheme(saved === 'dark' || (!saved && window.matchMedia('(prefers-color-scheme: dark)').matches));
            [document.getElementById('dark-mode-toggle'), document.getElementById('dark-mode-toggle-mobile')].forEach(b => {
                if(b) b.onclick = () => applyTheme(!html.classList.contains('dark'));
            });
        });
    </script>
</body>
</html>
