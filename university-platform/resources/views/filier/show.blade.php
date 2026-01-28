@extends('layouts.app')

@section('title', 'Filière Details')
@section('content')
<div class="py-5 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-gray-100 mb-3">{{ $filier->name }}</h1>
            <p class="text-gray-600 dark:text-gray-300">{{ $filier->description ?? 'No description available.' }}</p>
        </div>

        <div class="mb-6">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Semesters</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($filier->semesters as $semester)
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md dark:shadow-lg overflow-hidden hover:shadow-lg dark:hover:shadow-xl transition-shadow duration-300">
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-2">{{ $semester->semester }}</h3>
                            <p class="text-gray-600 dark:text-gray-300">Semester in {{ $filier->name }}</p>
                            <div class="mt-4">
                                <small class="text-green-600 dark:text-green-400 font-medium">Modules: {{ $semester->modules->count() }}</small>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <div class="bg-white dark:bg-gray-800 rounded-xl p-8 shadow-md dark:shadow-lg inline-block">
                            <i class="fas fa-calendar-alt text-gray-400 dark:text-gray-500 text-6xl mb-4"></i>
                            <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-2">No Semesters Found!</h3>
                            <p class="text-gray-600 dark:text-gray-300 mb-4">Semesters should be created automatically.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="mb-6">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Modules</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($modules as $module)
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md dark:shadow-lg overflow-hidden hover:shadow-lg dark:hover:shadow-xl transition-shadow duration-300">
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-2">{{ $module->name }}</h3>
                            <p class="text-gray-600 dark:text-gray-300">{{ Str::limit($module->description ?? 'No description.', 100) }}</p>
                            <div class="mt-4">
                                <small class="text-blue-600 dark:text-blue-400 font-medium">Teacher: {{ $module->teatcher_name }}</small>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <div class="bg-white dark:bg-gray-800 rounded-xl p-8 shadow-md dark:shadow-lg inline-block">
                            <i class="fas fa-book text-gray-400 dark:text-gray-500 text-6xl mb-4"></i>
                            <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-2">No Modules Found!</h3>
                            <p class="text-gray-600 dark:text-gray-300 mb-4">Start by creating a module for this filière.</p>
                            @if(Auth::check() && Auth::user()->role === 'teatcher')
                                <a href="{{ route('modules.create') }}" class="bg-indigo-600 dark:bg-indigo-700 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 dark:hover:bg-indigo-600 inline-flex items-center transition">
                                    <i class="fas fa-plus mr-2"></i>Create Module
                                </a>
                            @endif
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="mt-8 flex justify-center">
            <a href="{{ route('filier.index') }}" class="bg-gray-600 dark:bg-gray-700 text-white px-6 py-3 rounded-lg hover:bg-gray-700 dark:hover:bg-gray-600 transition">Back to Filières</a>
        </div>
    </div>
</div>
@endsection
