@extends('layouts.app')

@section('title', 'Modules Management')
@section('content')
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-10 px-6 animate-fadeIn transition-colors pb-20">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 animate-slideDown">
            <div class="flex-1">
                @if (Auth::check() && Auth::user()->role === 'teatcher')
                    <h2 class="text-3xl font-extrabold text-gray-800 dark:text-gray-100">Modules Management</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Manage and browse modules by filière and semester.</p>
                @else
                    <h2 class="text-3xl font-extrabold text-gray-800 dark:text-gray-100">Modules We Have</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Explore available modules by filière.</p>
                @endif
            </div>

            @if (Auth::check() && Auth::user()->role === 'teatcher')
                <div class="mt-4 sm:mt-0">
                    <a href="{{ route('modules.create') }}"
                        class="inline-flex items-center bg-indigo-600 dark:bg-indigo-500 hover:bg-indigo-700 dark:hover:bg-indigo-600 text-white px-5 py-2.5 rounded-xl shadow-md dark:shadow-lg dark:shadow-gray-900/20 transition-all duration-300 hover:scale-[1.05]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Create New Module
                    </a>
                </div>
            @endif
        </div>

        {{-- Filter and Search --}}
        <form method="GET" action="{{ route('modules.index') }}"
            class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm dark:shadow-lg dark:shadow-gray-900/20 mb-10 animate-fadeUp">
            <div class="flex flex-col lg:flex-row lg:items-center gap-4">
                {{-- Search by module or filiere name --}}
                <div class="flex-1">
                    <input type="text" name="search" placeholder="Search by module or filière name"
                        value="{{ request('search') }}"
                        class="w-full border border-gray-300 dark:border-gray-600 px-4 py-3 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 dark:focus:ring-indigo-500 dark:focus:border-indigo-500 transition bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400">
                </div>

                {{-- Filter by filière --}}
                <div class="w-full lg:w-64">
                    <select name="filiere_id"
                        class="w-full border border-gray-300 dark:border-gray-600 px-4 py-3 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 dark:focus:ring-indigo-500 dark:focus:border-indigo-500 transition bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 appearance-none">
                        <option value="">All filières</option>
                        @foreach ($allFilieres as $f)
                            <option value="{{ $f->id }}" {{ request('filiere_id') == $f->id ? 'selected' : '' }}>
                                {{ $f->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- <button type="submit"
                    class="bg-indigo-600 dark:bg-indigo-500 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 dark:hover:bg-indigo-600 transition shadow hover:scale-[1.03] font-medium">
                    Filter
                </button> --}}
            </div>
        </form>

        {{-- Modules cards --}}
        <div id="modules-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 lg:gap-8">
            @foreach ($filieres as $index => $filiere)
                <div class="rounded-2xl shadow-lg dark:shadow-xl dark:shadow-gray-900/20 overflow-hidden bg-white dark:bg-gray-800 hover:scale-[1.03] hover:shadow-2xl dark:hover:shadow-2xl dark:hover:shadow-gray-900/30 transition-all duration-300 animate-fadeUp"
                    style="animation-delay: {{ $index * 0.15 }}s; animation-fill-mode: both;">

                    {{-- Filière header --}}
                    <div class="p-6 bg-gradient-to-r from-indigo-600 to-indigo-500 text-white">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xl font-semibold flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path d="M4 3h12a1 1 0 011 1v13H3V4a1 1 0 011-1z" />
                                </svg>
                                {{ $filiere->name }}
                            </h3>
                            <span class="text-sm bg-white/20 dark:bg-black/20 px-3 py-1 rounded-full">{{ $filiere->modules->count() }}
                                modules</span>
                        </div>
                    </div>

                    {{-- Filière modules --}}
                    <div class="p-5 bg-gray-50 dark:bg-gray-700">
                        @if ($filiere->semesters->count() > 0)
                            @foreach ($filiere->semesters as $semester)
                                <div class="mb-4">
                                    <h4 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-2">{{ $semester->semester }}</h4>
                                    @if ($semester->modules->count() > 0)
                                        <ul class="space-y-3">
                                            @foreach ($semester->modules as $module)
                                            <a href="{{$module->Chaine ?? '#'}}" target="_blank" >
                                                <li

                                                    class="p-4 rounded-xl bg-white dark:bg-gray-600 border border-gray-200 dark:border-gray-500 hover:shadow-md dark:hover:shadow-lg dark:hover:shadow-gray-900/20 transition flex justify-between items-center hover:scale-[1.01] duration-200">
                                                    <div>
                                                        <div class="font-semibold text-gray-800 dark:text-gray-100">{{ $module->name }}</div>
                                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                                            {{ $module->teatcher_name ?? 'N/A' }}
                                                        </div>
                                                    </div>


                                                    @if (Auth::check() && Auth::user()->role === 'teatcher')
                                                        <div class="flex items-center gap-4">
                                                            <a href="{{ route('modules.edit', $module->id) }}"
                                                                class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition text-lg p-2 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <form action="{{ route('modules.destroy', $module) }}"
                                                                method="POST" class="inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 transition text-lg p-2 hover:bg-red-50 dark:hover:bg-red-900/20 rounded"
                                                                    onclick="return confirm('Are you sure you want to delete this module?')">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    @endif
                                                </li>
                                                 </a>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p class="text-gray-500 dark:text-gray-400 text-sm italic">No modules available for this semester.</p>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <p class="text-gray-500 dark:text-gray-400 text-sm italic">No semesters available for this filière.</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

    </div>

    {{-- JavaScript for live search --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.querySelector('input[name="search"]');
            const filiereSelect = document.querySelector('select[name="filiere_id"]');
            const modulesGrid = document.getElementById('modules-grid');
            const routeUrl = '{{ route('modules.index') }}';

            function performSearch() {
                const searchValue = searchInput.value;
                const filiereValue = filiereSelect.value;

                fetch(`${routeUrl}?search=${encodeURIComponent(searchValue)}&filiere_id=${encodeURIComponent(filiereValue)}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                    }
                })
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newGrid = doc.getElementById('modules-grid');
                    if (newGrid) {
                        modulesGrid.innerHTML = newGrid.innerHTML;
                    }
                })
                .catch(error => console.error('Error:', error));
            }

            searchInput.addEventListener('input', performSearch);
            filiereSelect.addEventListener('change', performSearch);
        });
    </script>

    {{-- Tailwind custom animations --}}
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
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

        .animate-fadeIn {
            animation: fadeIn 0.6s ease-in-out;
        }

        .animate-fadeUp {
            animation: fadeUp 0.8s ease-in-out;
        }

        .animate-slideDown {
            animation: slideDown 0.8s ease-in-out;
        }

        .animate-bounceIn {
            animation: bounceIn 0.6s ease-out;
        }
    </style>
@endsection
