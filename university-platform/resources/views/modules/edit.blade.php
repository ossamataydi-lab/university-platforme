@extends('layouts.app')

@section('title', 'Create Module')
@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full bg-white dark:bg-gray-800 p-8 rounded-xl shadow-lg">
        <h2 class="text-2xl font-bold mb-6 text-gray-900 dark:text-gray-100">Update info</h2>
        <form action="{{ route('modules.update', $module->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 mb-2">Module Name</label>
                <input type="text" name="name" value="{{ $module->name }}" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-indigo-500 dark:focus:border-indigo-400 transition bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 mb-2">Description</label>
                <textarea name="description" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-indigo-500 dark:focus:border-indigo-400 transition bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 resize-none">{{ $module->description }}</textarea>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 mb-2">Teacher Name</label>
                <input type="text" name="teatcher_name" value="{{ $module->teatcher_name }}"
                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-indigo-500 dark:focus:border-indigo-400 transition bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 mb-2">Chaine</label>
                <input type="text" name="chaine" value="{{ old('Chaine') }}"
                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-indigo-500 dark:focus:border-indigo-400 transition bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 mb-2">Filière</label>
                <select name="filiere_id" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-indigo-500 dark:focus:border-indigo-400 transition bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100" required>
                    <option value="">Select Filière</option>
                    @foreach ($filieres as $filier)
                        <option value="{{ $filier->id }}" {{ $module->filiere_id == $filier->id ? 'selected' : '' }}>
                            {{ $filier->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 mb-2">Semester</label>
                <select name="semester_id" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-indigo-500 dark:focus:border-indigo-400 transition bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100" required>
                    <option value="">Select Semester</option>
                    @foreach ($filieres->find($module->filiere_id)->semesters as $semester)
                        <option value="{{ $semester->id }}" {{ $module->semester_id == $semester->id ? 'selected' : '' }}>
                            {{ $semester->semester }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="bg-indigo-600 dark:bg-indigo-700 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 dark:hover:bg-indigo-600 transition">Update</button>
        </form>
    </div>
</div>
@endsection
