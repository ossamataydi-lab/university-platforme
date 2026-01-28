@extends('layouts.app')

@section('content')
    <style>
        /* ====== Animations ====== */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeInUp {
            opacity: 0;
            animation: fadeInUp 0.6s ease forwards;
        }

        /* ====== Hover effect ====== */
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.12);
        }

        /* ====== Dropdown styles ====== */
        .dropdown {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 10;
            max-height: 200px;
            overflow-y: auto;
        }

        .dark .dropdown {
            background: #374151;
            border-color: #4b5563;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
        }

        .group:hover .dropdown {
            display: block;
        }

        .dropdown-item {
            padding: 0.5rem 1rem;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .dropdown-item:hover {
            background-color: #f3f4f6;
        }

        .dark .dropdown-item:hover {
            background-color: #4b5563;
        }
    </style>

    <div class="container mx-auto px-4 py-8 animate-fadeInUp">
        <h1 class="text-3xl font-bold mb-6 text-gray-800 dark:text-gray-100">{{ __('Exercise List') }}</h1>
       <form method="GET" action="{{ route('exercises.index') }}" class="mb-6 flex flex-col sm:flex-row gap-4">
            <input
                type="search"
                name="search"
                placeholder="Search by module name..."
                class="p-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-lg flex-1"
                value="{{ request('search') }}"
            >

            <select name="filiere_id" class="p-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-lg">
                <option value="">All Filiers</option>
                @foreach($filiers as $filier)
                    <option value="{{ $filier->id }}" {{ request('filiere_id') == $filier->id ? 'selected' : '' }}>
                        {{ $filier->name }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="px-4 py-2 bg-blue-600 dark:bg-blue-500 text-white rounded-lg hover:bg-blue-700 dark:hover:bg-blue-600">
                {{ __('Filter') }}
            </button>
        </form>
        @if (auth()->check() && auth()->user()->role === 'teatcher')
            <button onclick="window.location.href='{{ route('exercises.create') }}'"
                class="mb-6 px-4 py-2 bg-green-600 dark:bg-green-500 text-white rounded-lg hover:bg-green-700 dark:hover:bg-green-600">
                {{ __('Add New Exercise') }}
            </button>
        @endif




        <div id="exams-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            @foreach ($exercises as $index => $exercise)
                @php
                    $fileExists = Storage::exists($exercise->file_path);
                    $fileSize = $fileExists ? Storage::size($exercise->file_path) : 0;
                @endphp

                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md dark:shadow-lg dark:shadow-gray-900/20 p-6 card-hover animate-fadeInUp"
                    style="animation-delay: {{ 0.1 * $index }}s;">
                    <div class="mb-4 relative flex justify-center items-center h-48 bg-gray-100 dark:bg-gray-700 rounded-lg">
                        <span class="text-red-600 dark:text-red-400 text-6xl">
                            <i class="fas fa-file-pdf"></i>
                        </span>
                        @if (auth()->check() && auth()->user()->role === 'teatcher')
                            <form action="{{ route('exercises.destroy', $exercise) }}" method="POST"
                                class="absolute top-2 right-2 z-10"
                                onsubmit="return confirm('{{ __('Are you sure you want to delete this exercise?') }}');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 bg-white dark:bg-gray-700 rounded-full p-1 shadow-md dark:shadow-lg dark:shadow-gray-900/20"
                                    style="font-size: 0.85rem;" title="{{ __('Delete') }}"
                                    aria-label="{{ __('Delete exercise :title', ['title' => $exercise->title]) }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        @endif
                    </div>

                    <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-2">{{ $exercise->title }}</h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-4">{{ $exercise->description ?? __('No description available') }}</p>

                    <p class="text-sm text-gray-400 dark:text-gray-500 mb-2">{{ __('Updated') }} {{ $exercise->updated_at->diffForHumans() }}
                    </p>

                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500 dark:text-gray-400 flex items-center space-x-1">
                            <i class="fas fa-file-pdf text-red-600 dark:text-red-400"></i>
                            <span>PDF •</span>
                            <span>
                                {{ $fileSize ? number_format($fileSize / 1048576, 2) . 'MB' : __('Size unknown') }}
                            </span>
                        </span>

                        <div class="flex space-x-2">
                            <a href="{{ route('exercises.download', $exercise) }}"
                                class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300" title="{{ __('Download') }}"
                                aria-label="{{ __('Download exercise :title', ['title' => $exercise->title]) }}">
                                <i class="fas fa-download"></i>
                            </a>


                            {{-- <a href="{{ Storage::url($course->file_path) }}"
                                class="text-green-600 hover:text-green-800 transition-colors duration-200"
                                title="{{ __('View') }}"
                                aria-label="{{ __('View course :title', ['title' => $course->title]) }}"
                                target="_blank">
                                <i class="fas fa-eye"></i>
                            </a> --}}

                            <a href="{{ Storage::url($exercise->file_path) }}"
                                class="text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-300" title="{{ __('View') }}"
                                aria-label="{{ __('View exercise :title', ['title' => $exercise->title]) }}">
                                <i class="fas fa-eye"></i>
                            </a>


                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.querySelector('input[name="search"]');
        const exercisesGrid = document.getElementById('exams-grid');

        function performSearch() {
            const searchValue = searchInput.value;

            const url = new URL('{{ route("exercises.index") }}');
            if (searchValue) {
                url.searchParams.set('search', searchValue);
            }

            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newGrid = doc.getElementById('exams-grid');

                if (newGrid) {
                    exercisesGrid.innerHTML = newGrid.innerHTML;
                }
            })
            .catch(error => console.error(error));
        }

        // ✅ البحث التلقائي فقط عند الكتابة
        searchInput.addEventListener('input', performSearch);
    });
</script>

@endsection
