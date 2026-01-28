@extends('layouts.app')

@section('title', 'achivement')
@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-3xl font-bold text-gray-800 dark:text-white">achivement</h2>
        <span class="text-gray-600 dark:text-gray-300">
            Welcome back,
            @auth
                {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}



            @else
                Guest
            @endauth
        </span>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md dark:shadow-lg p-6 card-hover">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-400 mr-4">
                    <i class="fas fa-book text-xl"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-white">12</h3>
                    <p class="text-gray-600 dark:text-gray-300">Active Courses</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md dark:shadow-lg p-6 card-hover">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-400 mr-4">
                    <i class="fas fa-check-circle text-xl"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-white">8</h3>
                    <p class="text-gray-600 dark:text-gray-300">Completed</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md dark:shadow-lg p-6 card-hover">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 dark:bg-yellow-900 text-yellow-600 dark:text-yellow-400 mr-4">
                    <i class="fas fa-clock text-xl"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-white">3</h3>
                    <p class="text-gray-600 dark:text-gray-300">Pending</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md dark:shadow-lg p-6 card-hover">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-red-100 dark:bg-red-900 text-red-600 dark:text-red-400 mr-4">
                    <i class="fas fa-exclamation-circle text-xl"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-white">2</h3>
                    <p class="text-gray-600 dark:text-gray-300">Overdue</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md dark:shadow-lg p-6">
        <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Recent Activity</h3>
        <div class="space-y-3">
            @for($i = 0; $i < 3; $i++)
            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-indigo-500 rounded-full mr-3"></div>
                    <span class="text-gray-800 dark:text-gray-200">New assignment in Mathematics</span>
                </div>
                <span class="text-sm text-gray-500 dark:text-gray-400">2 hours ago</span>
            </div>
            @endfor
        </div>
    </div>

    <!-- Exercises Section -->
    @if(isset($exercises) && $exercises->isNotEmpty())
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md dark:shadow-lg p-6">
        <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Exercises</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($exercises as $exercise)
            <div class="bg-white dark:bg-gray-700 rounded-xl shadow-md dark:shadow-lg p-6 card-hover">
                <h4 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">{{ $exercise->title }}</h4>
                <p class="text-gray-600 dark:text-gray-300 mb-4">{{ Str::limit($exercise->description ?? '', 100) }}</p>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-500 dark:text-gray-400">Due: {{ $exercise->due_date ?? 'No due date' }}</span>
                    <a href="{{ route('exercises.show', $exercise->id) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                        <i class="fas fa-eye"></i> View
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @else
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md dark:shadow-lg p-6">
        <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Exercises</h3>
        <p class="text-gray-600 dark:text-gray-300">No exercises available at the moment.</p>
    </div>
    @endif
</div>
@endsection
