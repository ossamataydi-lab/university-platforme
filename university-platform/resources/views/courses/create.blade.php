@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Create New Course</h1>

            <form action="{{ route('courses.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Title -->
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">courses Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        required>
                    @error('title')
                        <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
                    <textarea name="description" id="description" rows="4"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Module Selection -->
                <div class="mb-4">
                    <label for="module_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Module</label>
                    <select name="module_id" id="module_id"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        required>
                        <option value="">Select a module</option>
                        @foreach ($modules as $module)
                            <option value="{{ $module->id }}" {{ old('module_id') == $module->id ? 'selected' : '' }}>
                                {{ $module->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('module_id')
                        <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <br>
                <div class="mb-4">
                    <label for="felier_id"
                        class="block text-sm font-medium text-gray-600 text-gray-700 mb-2">filiere</label>
                    <select name="felier_id" id="felier_id"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        required>
                        <option value="">Select a filiere</option>
                        @foreach ($filiere as $felier)
                            <option value="{{ $felier->id }}" {{ old('felier_id') == $felier->id ? 'selected' : '' }}>
                                {{ $felier->name }}
                            </option>
                        @endforeach
                </div>


                <!-- File Upload -->
                <div class="mb-6">
                    <label for="file_path" class="block text-sm font-medium text-gray-700 mb-2">Cours File</label>
                    <input type="file" name="file_path" id="file_path" accept=".pdf,.doc,.docx,.ppt,.pptx"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        required>
                    <p class="text-sm text-gray-500 mt-1">Accepted formats: PDF, DOC, DOCX, PPT, PPTX (Max: 20MB)</p>
                    @error('file_path')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <a href="{{ route('courses.index') }}"
                        class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition-colors mr-2">
                        Cancel
                    </a>
                    <button type="submit"
                        class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition-colors">
                        Create Course
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
