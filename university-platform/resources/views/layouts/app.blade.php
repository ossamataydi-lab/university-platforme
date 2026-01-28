<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Educational Platform')</title>

    {{-- Tailwind CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Tailwind Config for Dark Mode --}}
    <script>
        tailwind.config = {
            darkMode: 'class'
        }
    </script>
    <link rel="icon"  href="https://tse3.mm.bing.net/th/id/OIP.8tZ9iwt1pCAJVUarYDZhTQHaHa?pid=Api&P=0&h=180" />

    {{-- FontAwesome --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    {{-- Alpine.js --}}
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>


    <style>
        .card-hover {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        @keyframes bounceIn {
            0% {
                transform: scale(0.8);
                opacity: 0;
            }

            60% {
                transform: scale(1.05);
                opacity: 1;
            }

            100% {
                transform: scale(1);
            }
        }

        .animate-bounceIn {
            animation: bounceIn 0.6s ease-out;
        }

        .avatar-sm {
            width: 2rem;
            height: 2rem;
            object-fit: cover;
        }

        /* Dark Mode Styles */
        .dark body {
            background-color: #111827;
            color: #f9fafb;
        }

        .dark nav {
            background-color: #1f2937;
        }

        .dark .card-hover {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        }

        .dark .card-hover:hover {
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.4);
        }
    </style>
</head>

<body class="bg-gray-50 dark:bg-gray-900 min-h-screen transition-colors">

    <nav class="bg-white dark:bg-gray-800 shadow-lg fixed w-full z-20 top-0 left-0 transition-colors">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <!-- Logo -->
                <div class="flex items-center space-x-4">
                    <h1 class="text-2xl font-bold text-indigo-600">EduPlatform</h1>
                </div>

                <!-- Desktop Links -->
                <div class="hidden md:flex md:items-center md:space-x-6">
                    <!-- Dark Mode Toggle -->
                    <button id="dark-mode-toggle"
                        class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 px-3 py-2 rounded-md text-sm font-medium transition-colors">
                        <i id="dark-mode-icon" class="fas fa-moon"></i>
                    </button>

                    @auth
                        @if (auth()->user()->role == 'student')
                            <a href="{{ route('achivement') }}"
                                class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 px-3 py-2 rounded-md text-sm font-medium">Achievement</a>
                        @endif
                    @endauth

                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                            class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 px-3 py-2 rounded-md text-sm font-medium flex items-center">
                            Courses
                            <i
                                :class="open ? 'fa-solid fa-chevron-up text-gray-600 dark:text-gray-400 text-xs ml-1' :
                                    'fa-solid fa-chevron-down text-gray-500 dark:text-gray-400 text-xs ml-1'"></i>
                        </button>

                        <ul x-show="open" @click.away="open = false" x-transition
                            class="dropdown-menu absolute bg-white dark:bg-gray-800 shadow-lg rounded-md mt-2 min-w-max border border-gray-200 dark:border-gray-600">
                            <li>
                                <a href="{{ route('courses.index') }}"
                                    class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    📘 All Courses
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('exercises.index') }}"
                                    class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    📘 All Exercises
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('exames.index') }}"
                                    class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    📘 All Exams
                                </a>
                            </li>
                        </ul>
                    </div>

                    <a href="{{ route('filier.index') }}"
                        class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 px-3 py-2 rounded-md text-sm font-medium">Filières</a>
                    <a href="{{ route('modules.index') }}"
                        class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 px-3 py-2 rounded-md text-sm font-medium">Modules</a>
                    <a href="{{ route('messages.index') }}"
                        class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 px-3 py-2 rounded-md text-sm font-medium">Chat</a>
                    <!-- Notifications Bell -->
                    @auth
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open"
                                class="relative text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 px-3 py-2 rounded-md text-sm font-medium">
                                <i class="fas fa-bell"></i>
                                @if(Auth::check() && Auth::user()->unreadNotifications->count() > 0)
                                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                        {{ Auth::user()->unreadNotifications->count() > 99 ? '99+' : Auth::user()->unreadNotifications->count() }}
                                    </span>
                                @endif
                            </button>

                            <div x-show="open" @click.away="open = false" x-transition
                                class="absolute right-0 mt-2 w-80 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-lg shadow-lg z-50">
                                <div class="p-4 border-b border-gray-200 dark:border-gray-600">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Notifications</h3>
                                </div>
                                <div class="max-h-64 overflow-y-auto">
                                    @if(Auth::check())
                                        @forelse(Auth::user()->unreadNotifications->take(5) as $notification)
                                            <div class="p-4 border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $notification->data['title'] ?? 'Notification' }}</p>
                                                <p class="text-sm text-gray-600 dark:text-gray-300">{{ $notification->data['message'] ?? '' }}</p>
                                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                            </div>
                                        @empty
                                            <div class="p-4 text-center text-gray-500 dark:text-gray-400">
                                                No new notifications
                                            </div>
                                        @endforelse
                                    @else
                                        <div class="p-4 text-center text-gray-500 dark:text-gray-400">
                                            No new notifications
                                        </div>
                                    @endif
                                </div>
                                <div class="p-4 border-t border-gray-200 dark:border-gray-600">
                                    <a href="{{ route('notifications.index') }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 text-sm font-medium">
                                        View all notifications
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endauth
                </div>

                <!-- User / Auth -->
                <div class="hidden md:flex items-center space-x-4" x-data="{ open: false }">
                    @auth
                        <!-- الزر الذي يفتح القائمة -->
                        <button @click="open = !open"
                            class="flex items-center space-x-2 focus:outline-none hover:bg-gray-100 rounded-lg px-2 py-1 transition">
                            @if (auth()->check())
                                <img src="{{ auth()->user()->avatar ? Storage::url(auth()->user()->avatar) : 'https://cdn-icons-png.flaticon.com/512/3135/3135715.png' }}"
                                    alt="avatar" class="w-8 h-8 rounded-full border border-gray-200" />
                            @endif
                            <span class="text-gray-700 font-medium">{{ Auth::user()->name }}</span>

                            <!-- السهم يتغيّر عند الفتح -->
                            <i
                                :class="open ? 'fa-solid fa-chevron-up text-gray-600 text-xs' :
                                    'fa-solid fa-chevron-down text-gray-500 text-xs'"></i>
                        </button>

                        <!-- القائمة المنسدلة -->
                        <div x-show="open" @click.away="open = false" x-transition
                            class="absolute right-0 mt-12 w-44 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-lg shadow-lg">
                            <form action="{{ route('profile.show') }}" method="GET">
                                <button type="submit"
                                    class="w-full text-left px-4 py-2 text-sm text-blue-600 dark:text-blue-400 hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center">
                                    <i class="fa-solid fa-user mr-2 text-indigo-500 dark:text-indigo-400"></i> Profile
                                </button>
                            </form>

                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center">
                                    <i class="fa-solid fa-right-from-bracket mr-2"></i> Logout
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login.form') }}" class="text-blue-600 hover:text-blue-800">Login</a>
                        <a href="{{ route('register.form') }}" class="text-green-600 hover:text-green-800">Register</a>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-button" aria-label="Open menu"
                        class="text-gray-700 hover:text-indigo-600 focus:outline-none">
                        <i class="fa-solid fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- MOBILE MENU -->
        <div id="mobile-menu"
            class="hidden md:hidden bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4 pt-4 pb-3 space-y-2">
                <!-- Dark Mode Toggle Mobile -->
                <button id="dark-mode-toggle-mobile"
                    class="block text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 px-3 py-2 rounded-md text-sm font-medium w-full text-left">
                    <i id="dark-mode-icon-mobile" class="fas fa-moon mr-2"></i>Dark Mode
                </button>

                @auth
                    @if (auth()->user()->role == 'student')
                        <a href="{{ route('achivement') }}"
                            class="block text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 px-3 py-2 rounded-md text-sm font-medium">Achievement</a>
                    @endif
                @endauth

                <div class="relative group">
                    <button class="text-gray-700 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium">
                        Courses
                    </button>

                    <ul
                        class="dropdown-menu absolute hidden group-hover:block bg-white shadow-lg rounded-md mt-1 min-w-max">
                        <li>
                            <a href="{{ route('courses.index') }}"
                                class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                📘 All Courses
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('exercises.index') }}"
                                class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                📘 All Exercises
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('exames.index') }}"
                                class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                📘 All Exame
                            </a>
                        </li>
                    </ul>
                </div>
                <a href="{{ route('filier.index') }}"
                    class="block text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 px-3 py-2 rounded-md text-sm font-medium">Filières</a>
                <a href="{{ route('modules.index') }}"
                    class="block text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 px-3 py-2 rounded-md text-sm font-medium">Modules</a>
                <a href="{{ route('messages.index') }}"
                    class="block text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 px-3 py-2 rounded-md text-sm font-medium">Chat</a>
                <a href="{{ route('notifications.index') }}"
                    class="flex items-center text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 px-3 py-2 rounded-md text-sm font-medium">
                    <i class="fas fa-bell mr-2"></i>
                    Notifications
                    @if(Auth::check() && Auth::user()->unreadNotifications->count() > 0)
                        <span class="ml-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                            {{ Auth::user()->unreadNotifications->count() > 99 ? '99+' : Auth::user()->unreadNotifications->count() }}
                        </span>
                    @endif
                </a>

                @auth
                    <div class="border-t border-gray-200 mt-3 pt-3">

                        <a href="{{ route('profile.show') }}"
                            class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-gray-100">

                            {{-- Avatar --}}
                            @if (auth()->check())
                                <img src="{{ auth()->user()->avatar
                                    ? Storage::url(auth()->user()->avatar)
                                    : 'https://cdn-icons-png.flaticon.com/512/3135/3135715.png' }}"
                                    alt="avatar" class="w-8 h-8 rounded-full border border-gray-200 mr-2">
                            @endif
                            Profile
                        </a>

                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="w-full flex items-center text-left px-3 py-2 text-sm text-red-600 hover:bg-gray-100">
                                Logout
                            </button>
                        </form>

                    </div>
                @else
                    <a href="{{ route('login.form') }}"
                        class="block text-blue-600 hover:bg-gray-100 px-3 py-2 rounded-md text-sm font-medium">Login</a>
                    <a href="{{ route('register.form') }}"
                        class="block text-green-600 hover:bg-gray-100 px-3 py-2 rounded-md text-sm font-medium">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="pt-16">
        <div class="max-w-7xl mx-auto px-4 mt-6 animate-bounceIn">
            @if (session('success'))
                <div class="bg-green-100 text-green-800 p-3 rounded mb-4 shadow-md">
                    <i class="fa-solid fa-circle-check mr-2"></i> {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 text-red-800 p-3 rounded mb-4 shadow-md">
                    <i class="fa-solid fa-circle-xmark mr-2"></i> {{ session('error') }}
                </div>
            @endif
        </div>

        <main class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
            @yield('content')
        </main>

        <footer
            class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-600 mt-10 py-6 transition-colors">
            <div class="max-w-7xl mx-auto text-center text-gray-500 dark:text-gray-400 text-sm">
                © {{ date('Y') }} EduPlatform. All rights reserved.
            </div>
        </footer>
    </div>

    <script>
        (function() {
            const menuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            if (!menuButton || !mobileMenu) return;
            menuButton.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });
        })();

        // Dark Mode Toggle
        (function() {
            console.log('Dark mode script loaded');

            const darkModeToggle = document.getElementById('dark-mode-toggle');
            const darkModeToggleMobile = document.getElementById('dark-mode-toggle-mobile');
            const darkModeIcon = document.getElementById('dark-mode-icon');
            const darkModeIconMobile = document.getElementById('dark-mode-icon-mobile');
            const html = document.documentElement;

            console.log('Elements found:', {
                darkModeToggle: !!darkModeToggle,
                darkModeToggleMobile: !!darkModeToggleMobile,
                darkModeIcon: !!darkModeIcon,
                darkModeIconMobile: !!darkModeIconMobile
            });

            // Check for saved theme preference or default to light mode
            const currentTheme = localStorage.getItem('theme') || 'light';
            console.log('Current theme:', currentTheme);

            if (currentTheme === 'dark') {
                html.classList.add('dark');
                console.log('Added dark class to html');
                if (darkModeIcon) darkModeIcon.className = 'fas fa-sun';
                if (darkModeIconMobile) darkModeIconMobile.className = 'fas fa-sun mr-2';
            } else {
                if (darkModeIcon) darkModeIcon.className = 'fas fa-moon';
                if (darkModeIconMobile) darkModeIconMobile.className = 'fas fa-moon mr-2';
            }

            function toggleDarkMode() {
                console.log('Toggle clicked');
                if (html.classList.contains('dark')) {
                    html.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                    console.log('Switched to light mode');
                    if (darkModeIcon) darkModeIcon.className = 'fas fa-moon';
                    if (darkModeIconMobile) darkModeIconMobile.className = 'fas fa-moon mr-2';
                } else {
                    html.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                    console.log('Switched to dark mode');
                    if (darkModeIcon) darkModeIcon.className = 'fas fa-sun';
                    if (darkModeIconMobile) darkModeIconMobile.className = 'fas fa-sun mr-2';
                }
            }

            if (darkModeToggle) {
                darkModeToggle.addEventListener('click', toggleDarkMode);
                console.log('Desktop toggle listener added');
            }
            if (darkModeToggleMobile) {
                darkModeToggleMobile.addEventListener('click', toggleDarkMode);
                console.log('Mobile toggle listener added');
            }
        })();
    </script>

    @yield('scripts')
</body>

</html>
