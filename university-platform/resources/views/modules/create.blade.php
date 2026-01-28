@extends('layouts.app')

@section('title', 'Create Module')
@section('content')
    {{-- styles moved to resources/css/app.css --}}
    <div class="module-form">
        <h2 class="text-2xl font-bold mb-6 text-gray-900 dark:text-gray-100">Create New Module</h2>

        @if ($errors->any())
            <div class="bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-600 text-red-700 dark:text-red-200 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

    <form action="{{ route('modules.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 mb-2">Module Name</label>
                <input type="text" name="name" value="{{ old('name') }}"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-lg @error('name') border-red-500 @enderror" required>
                @error('name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 mb-2">Description</label>
                <textarea name="description" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-lg @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                @error('description')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 mb-2">Professor</label>
                <input type="text" name="teatcher_name" value="{{ old('teatcher_name') }}"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-lg @error('teatcher_name') border-red-500 @enderror" required>
                @error('teatcher_name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-gray-600 dark:text-gray-300 mb-2">Chaine</label>
                <input type="text" name="chaine" value="{{ old('chaine') }}"
                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-lg ">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 mb-2">Filière</label>
                <select name="filiere_id" id="filiere-select"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-lg @error('filiere_id') border-red-500 @enderror" required>
                    <option value="">Select Filière</option>
                    @foreach ($filieres as $filier)
                        <option value="{{ $filier->id }}" {{ old('filiere_id') == $filier->id ? 'selected' : '' }}>
                            {{ $filier->name }}</option>
                    @endforeach
                </select>
                @error('filiere_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 mb-2">Semester</label>
                <select name="semester_id" id="semester-select"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-lg @error('semester_id') border-red-500 @enderror" required>
                    <option value="">Select Semester</option>
                </select>
                @error('semester_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <script>
                document.getElementById('filiere-select').addEventListener('change', function() {
                    var filiereId = this.value;
                    var semesterSelect = document.getElementById('semester-select');
                    semesterSelect.innerHTML = '<option value="">Select Semester</option>';

                    if (filiereId) {
                        @foreach ($filieres as $filier)
                            if (filiereId == {{ $filier->id }}) {
                                @foreach ($filier->semesters as $semester)
                                    var option = document.createElement('option');
                                    option.value = '{{ $semester->id }}';
                                    option.text = '{{ $semester->semester }}';
                                    semesterSelect.appendChild(option);
                                @endforeach
                            }
                        @endforeach
                    }
                });
            </script>
            <button type="submit" class="btn-submit bg-indigo-600 dark:bg-indigo-700 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 dark:hover:bg-indigo-600">Create</button>
        </form>
    </div>


@endsection
