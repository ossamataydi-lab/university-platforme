@extends('layouts.app')

@section('title', 'Filières Management')
@section('content')
    <div class="py-5 bg-gray-50 dark:bg-gray-900 animate-fadeIn transition-colors">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 animate-slideDown">
                <div class="text-center sm:text-left w-full sm:w-auto">
                    <h1 class="text-4xl font-bold text-gray-900 dark:text-gray-100 mb-3">Filières Management</h1>
                    <p class="text-gray-600 dark:text-gray-300">Manage and view all available filières.</p>
                </div>


                @if (Auth::check() && Auth::user()->role === 'teatcher')
                    <div class="mt-4 sm:mt-0">
                        <a href="{{ route('filier.create') }}"
                           class="bg-indigo-600 dark:bg-indigo-500 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 dark:hover:bg-indigo-600 inline-flex items-center transition-transform hover:scale-[1.03]">
                            <i class="fas fa-plus mr-2"></i>Create Filière
                        </a>
                    </div>
                @endif
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($filieres as $index => $filiere)
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md dark:shadow-lg dark:shadow-gray-900/20 overflow-hidden hover:shadow-lg dark:hover:shadow-xl dark:hover:shadow-gray-900/30 transition-all duration-300 h-full animate-fadeUp"
                         style="animation-delay: {{ $index * 0.15 }}s; animation-fill-mode: both;">
                        <div class="p-6 flex flex-col h-full">
                            <div class="mb-3 flex-grow">
                                <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-2">{{ $filiere->name ?? 'Filière Name' }}</h3>
                                <p class="text-gray-600 dark:text-gray-300">
                                    {{ Str::limit($filiere->description ?? 'A beautiful filière for your needs.', 100) }}
                                </p>
                            </div>
                            <div class="mt-auto">
                                <small class="text-green-600 dark:text-green-400 font-medium">Students:
                                    {{ $filiere->students->count() ?? 0 }}</small>
                                <div class="mt-2 flex space-x-2">
                                    <a href="{{ route('filier.show', $filiere->id) }}"
                                        class="bg-indigo-600 dark:bg-indigo-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-indigo-700 dark:hover:bg-indigo-600 flex items-center transition-transform hover:scale-[1.05]">
                                        <i class="fas fa-eye mr-1"></i>View Details
                                    </a>
                                    @if (Auth::check() && Auth::user()->role === 'teatcher')
                                        <a href="{{ route('filier.edit', $filiere->id) }}"
                                            class="bg-blue-500 dark:bg-blue-400 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-600 dark:hover:bg-blue-500 flex items-center transition-transform hover:scale-[1.05]">
                                            <i class="fas fa-edit mr-1"></i>Edit
                                        </a>
                                        <form action="{{ route('filier.destroy', $filiere->id) }}" method="POST"
                                            class="inline-block mt-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-500 dark:bg-red-400 text-white px-4 py-2 rounded-lg text-sm hover:bg-red-600 dark:hover:bg-red-500 flex items-center transition-transform hover:scale-[1.05]"
                                                onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash mr-1"></i>Delete
                                            </button>
                                        </form>
                                    @endif
                                </div>
                                <div class="mt-3">
                                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                        <div class="bg-indigo-600 dark:bg-indigo-500 h-2 rounded-full" style="width: 50%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12 animate-fadeUp">
                        <div class="bg-white rounded-xl p-8 shadow-md inline-block">
                            <i class="fas fa-folder-open text-gray-400 text-6xl mb-4"></i>
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">No Filières Found!</h3>
                            <p class="text-gray-600 mb-4">It looks like there are no filières available yet.</p>
                            @if (Auth::check() && Auth::user()->role === 'teatcher')
                                <a href="{{ route('filier.create') }}"
                                    class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 inline-flex items-center transition-transform hover:scale-[1.05]">
                                    <i class="fas fa-plus mr-2"></i>Create one now?
                                </a>
                            @endif
                        </div>
                    </div>
                @endforelse
            </div>

            @if ($filieres->hasPages())
                <div class="mt-8 flex justify-center animate-fadeIn">
                    {{ $filieres->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- ✅ Animation styles (only added; no other changes) --}}
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes bounceIn {
            0% { transform: scale(0.8); opacity: 0; }
            60% { transform: scale(1.05); opacity: 1; }
            100% { transform: scale(1); }
        }

        .animate-fadeIn { animation: fadeIn 0.6s ease-in-out; }
        .animate-fadeUp { animation: fadeUp 0.8s ease-in-out; }
        .animate-slideDown { animation: slideDown 0.8s ease-in-out; }
        .animate-bounceIn { animation: bounceIn 0.6s ease-out; }
    </style>
@endsection
