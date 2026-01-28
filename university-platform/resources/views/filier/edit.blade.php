@extends('layouts.app')

@section('title', 'Update Filière')
@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full bg-white dark:bg-gray-800 p-8 rounded-xl shadow-lg">
         {{-- @if(Auth::check() && (Auth::user()->role === 'teatcher' || Auth::user()->role === 'teacher')) --}}
        <h2 class="text-2xl font-bold mb-6 text-gray-900 dark:text-gray-100">Update Filière</h2>
        <form action="{{ route('filier.update', $filier) }}" method="post">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 mb-2">Name</label>
                <input type="text" name="name" value="{{ old('name', $filier->name) }}" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-indigo-500 dark:focus:border-indigo-400 transition bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 @error('name') border-red-500 dark:border-red-400 @enderror" required>
                @error('name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 mb-2">Description</label>
                <textarea name="description" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-indigo-500 dark:focus:border-indigo-400 transition bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 resize-none @error('description') border-red-500 dark:border-red-400 @enderror">{{ old('description', $filier->description) }}</textarea>
                @error('description')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="flex space-x-2">
                <button type="submit" class="bg-indigo-600 dark:bg-indigo-700 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 dark:hover:bg-indigo-600 transition">Update</button>
                <a href="{{ route('filier.index') }}" class="bg-gray-500 dark:bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-600 dark:hover:bg-gray-500 transition">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
