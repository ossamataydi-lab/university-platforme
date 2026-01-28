@extends('layouts.app')

@section('content')
    <style>
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

        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.12);
        }
    </style>

    <div class="container mx-auto px-4 py-8 animate-fadeInUp">
        <h1 class="text-3xl font-bold mb-6 text-gray-800 dark:text-gray-100">{{ __('Exames List') }}</h1>

        <form method="GET" action="{{ route('exames.index') }}" class="mb-6 bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm dark:shadow-lg dark:shadow-gray-900/20">
            <div class="flex flex-col lg:flex-row lg:items-center gap-4">
                <div class="flex-1">
                    <input type="search" name="search" placeholder="Search by module name..."
                        class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400" value="{{ request('search') }}">
                </div>

                <div class="w-full lg:w-64">
                    <select name="filiere_id" class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 appearance-none">
                        <option value="">All Filiers</option>
                        @foreach ($filiers as $filier)
                            <option value="{{ $filier->id }}" {{ request('filiere_id') == $filier->id ? 'selected' : '' }}>
                                {{ $filier->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="px-6 py-3 bg-blue-600 dark:bg-blue-500 text-white rounded-lg hover:bg-blue-700 dark:hover:bg-blue-600 font-medium">
                    {{ __('Filter') }}
                </button>
            </div>
        </form>

        @if (auth()->check() && auth()->user()->role === 'teatcher')
            <div class="mb-6">
                <button onclick="window.location.href='{{ route('exames.create') }}'"
                    class="px-6 py-3 bg-green-600 dark:bg-green-500 text-white rounded-lg hover:bg-green-700 dark:hover:bg-green-600 font-medium">
                    {{ __('Add New Exam') }}
                </button>
            </div>
        @endif

        <div id="exams-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($exames as $index => $exame)
                @php
                    $fileExists = Storage::exists($exame->file_path);
                    $fileSize = $fileExists ? Storage::size($exame->file_path) : 0;
                @endphp

                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 card-hover animate-fadeInUp"
                    style="animation-delay: {{ 0.1 * $index }}s;">
                    <div class="mb-4 relative flex justify-center items-center h-48 bg-gray-100 dark:bg-gray-700 rounded-lg">
                        <span class="text-red-600 dark:text-red-400 text-6xl">
                            <i class="fas fa-file-pdf"></i>
                        </span>
                        @if (auth()->check() && auth()->user()->role === 'teatcher')
                            <form action="{{ route('exames.destroy', $exame) }}" method="POST"
                                class="absolute top-2 right-2 z-10"
                                onsubmit="return confirm('{{ __('Are you sure you want to delete this exam?') }}');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 bg-white dark:bg-gray-700 rounded-full p-1 shadow-md dark:shadow-lg dark:shadow-gray-900/20"
                                    style="font-size: 0.85rem;" title="{{ __('Delete') }}"
                                    aria-label="{{ __('Delete exam :title', ['title' => $exame->title]) }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        @endif
                    </div>

                    <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-2">{{ $exame->title }}</h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-4">{{ $exame->description ?? __('No description available') }}</p>

                    <p class="text-sm text-gray-400 dark:text-gray-500 mb-2">{{ __('Updated') }} {{ $exame->updated_at->diffForHumans() }}
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
                            <a href="{{ route('exames.download', $exame) }}"
                                class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300" title="{{ __('Download') }}"
                                aria-label="{{ __('Download exam :title', ['title' => $exame->title]) }}">
                                <i class="fas fa-download"></i>
                            </a>

                            <a href="{{ Storage::url($exame->file_path) }}"
                                class="text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-300" title="{{ __('View') }}"
                                aria-label="{{ __('View exam :title', ['title' => $exame->title]) }}"
                                target="_blank">
                                <i class="fas fa-eye"></i>
                            </a>


                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const searchInput = document.querySelector('input[name="search"]');
                const examsGrid = document.getElementById('exams-grid');

                function performSearch() {
                    const searchValue = searchInput.value;

                    const url = new URL('{{ route('exames.index') }}');
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
                                examsGrid.innerHTML = newGrid.innerHTML;
                            }
                        })
                        .catch(error => console.error(error));
                }

                // ✅ البحث التلقائي فقط عند الكتابة
                searchInput.addEventListener('input', performSearch);
            });
        </script>
    @endsection
