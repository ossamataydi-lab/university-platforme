@extends('layouts.app')

@section('title', 'Create Filière')
@section('content')
<div class="max-w-md mx-auto bg-white dark:bg-gray-800 p-8 rounded-xl shadow-lg dark:shadow-xl">
     {{-- @if(Auth::check() && (Auth::user()->role === 'teatcher' || Auth::user()->role === 'teacher')) --}}
    <h2 class="text-2xl font-bold mb-6">Create New Filière</h2>
    <form action="{{ route('filier.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300 mb-2">Name</label>
            <input type="text" name="name"  class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300 mb-2">Description</label>
            <textarea name="description" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white"></textarea>
        </div>
        <button type="submit" class="bg-indigo-600 dark:bg-indigo-500 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 dark:hover:bg-indigo-600">Create</button>
    </form>
</div>
@endsection
