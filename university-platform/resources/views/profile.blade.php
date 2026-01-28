@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div
            class="max-w-2xl w-full bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8
                transition-all duration-300 hover:shadow-2xl hover:-translate-y-1 fade-in">

            <!-- Title -->
            <h2 class="text-3xl font-extrabold text-gray-900 dark:text-gray-100 mb-10 text-center">
                Profile Management
            </h2>

            <!-- Profile Header -->
            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6 mb-8">

                <!-- Avatar -->
                <div class="relative group flex-shrink-0 mx-auto sm:mx-0">
                    <!-- Animated Ring -->
                    <div
                        class="absolute inset-0 rounded-full border-4 border-indigo-500 dark:border-indigo-400 animate-spin-slow group-hover:animate-none transition">
                    </div>

                    <!-- Image -->
                    <img id="profileImage"
                        class="relative h-32 w-32 rounded-full object-cover bg-white dark:bg-gray-800 border-4 border-transparent cursor-pointer z-10
                           transition-transform duration-300 group-hover:scale-105"
                        src="{{ $user->avatar ? Storage::url($user->avatar) : asset('images/default-avatar.png') }}"
                        onclick="document.getElementById('avatarInput').click();">

                    <!-- Overlay -->
                    <div onclick="document.getElementById('avatarInput').click();"
                        class="absolute inset-0 z-20 rounded-full bg-black/50 flex items-center justify-center
                           text-white text-sm font-semibold opacity-0 group-hover:opacity-100 transition cursor-pointer">
                        Change photo
                    </div>
                </div>

                <!-- User Info -->
                <div class="text-center sm:text-left flex-1">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                        {{ Auth::user()->name }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300 mt-1">
                        {{ Auth::user()->email }}
                    </p>

                    @if ($filiere ?? false)
                        <span
                            class="inline-block mt-2 bg-indigo-100 dark:bg-indigo-900
                                 text-indigo-800 dark:text-indigo-200 text-sm font-medium px-3 py-1 rounded-full">
                            {{ $filiere->name }}
                        </span>
                    @endif
                </div>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Hidden File Input -->
                <input id="avatarInput" type="file" name="avatar" accept="image/*" class="hidden"
                    onchange="previewImage(event)">

                <!-- Name -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="group">
                        <label
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2
                                  transition-colors group-focus-within:text-indigo-600">
                            First Name
                        </label>
                        <input type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600
                                  bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100
                                  transition-all duration-200
                                  hover:border-indigo-400 dark:hover:border-indigo-500
                                  focus:ring-2 focus:ring-indigo-500 focus:outline-none focus:shadow-lg">
                    </div>

                    <div class="group">
                        <label
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2
                                  transition-colors group-focus-within:text-indigo-600">
                            Last Name
                        </label>
                        <input type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600
                                  bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100
                                  transition-all duration-200
                                  hover:border-indigo-400 dark:hover:border-indigo-500
                                  focus:ring-2 focus:ring-indigo-500 focus:outline-none focus:shadow-lg">
                    </div>
                </div>

                <!-- Email -->
                <div class="group">
                    <label
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2
                              transition-colors group-focus-within:text-indigo-600">
                        Email
                    </label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600
                              bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100
                              transition-all duration-200
                              hover:border-indigo-400 dark:hover:border-indigo-500
                              focus:ring-2 focus:ring-indigo-500 focus:outline-none focus:shadow-lg">
                </div>

                <!-- Bio -->
                <div class="group">
                    <label
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2
                              transition-colors group-focus-within:text-indigo-600">
                        Bio <span class="text-red-500">*</span>
                    </label>
                    <textarea name="bio" rows="3"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600
                                 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 resize-none
                                 transition-all duration-200
                                 hover:border-indigo-400 dark:hover:border-indigo-500
                                 focus:ring-2 focus:ring-indigo-500 focus:outline-none focus:shadow-lg"
                        placeholder="Write a few words about yourself...">{{ old('bio', $user->bio) }}</textarea>
                </div>

                <!-- Filiere -->
                <div class="group">
                    <label class="block text-gray-700 dark:text-gray-300 mb-2">Filière</label>
                    <select name="filiere_id" id="filiere-select"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600
                               bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100
                               transition-all duration-200
                               hover:border-indigo-400 dark:hover:border-indigo-500
                               focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        <option value="">Select Filière</option>
                        @foreach ($filieres as $filier)
                            <option value="{{ $filier->id }}"
                                {{ $filiere && $filiere->id == $filier->id ? 'selected' : '' }}>{{ $filier->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 mb-2">Semester</label>
                    <select name="semester_id" id="semester-select" class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 transition-all duration-200 hover:border-indigo-400 dark:hover:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:outline-none" required>
                        <option value="">Select Semester</option>
                        @foreach ($semesters as $semester)
                            <option value="{{ $semester->id }}"
                                {{ optional(auth()->user()->student)->semester_id == $semester->id ? 'selected' : '' }}>
                                {{ $semester->semester }}
                            </option>
                        @endforeach
                    </select>


                    @error('semester_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Submit -->
                <div class="flex justify-end">
                    <button type="submit"
                        class="relative overflow-hidden bg-indigo-600 dark:bg-indigo-700 text-white
                               px-8 py-3 rounded-lg font-semibold
                               transition-all duration-300
                               hover:bg-indigo-700 dark:hover:bg-indigo-600
                               hover:shadow-xl hover:-translate-y-0.5">
                        Update Profile
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- CSS -->
    <style>
        @keyframes spinSlow {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .animate-spin-slow {
            animation: spinSlow 6s linear infinite;
        }

        .fade-in {
            animation: fadeInUp .6s ease-out both;
        }

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
    </style>

    <!-- JS -->
    <script>
        function previewImage(event) {
            document.getElementById('profileImage').src =
                URL.createObjectURL(event.target.files[0]);
        }

        document.addEventListener('DOMContentLoaded', function() {
            const filiereSelect = document.getElementById('filiere-select');
            const semesterSelect = document.getElementById('semester-select');
            const semestersData = @json($groupedSemesters);

            function updateSemesters() {
                const selectedFiliereId = filiereSelect.value;
                semesterSelect.innerHTML = '<option value="">Select Semester</option>';

                if (selectedFiliereId && semestersData[selectedFiliereId]) {
                    semestersData[selectedFiliereId].forEach(semester => {
                        const option = document.createElement('option');
                        option.value = semester.id;
                        option.textContent = semester.semester;
                        @if ($semester)
                            if ({{ $semester->id }} == semester.id) {
                                option.selected = true;
                            }
                        @endif
                        semesterSelect.appendChild(option);
                    });
                }
            }

            filiereSelect.addEventListener('change', updateSemesters);
            updateSemesters(); // Initial load
        });

        const semestersByFiliere = @json($groupedSemesters);

        document.getElementById('filiere-select').addEventListener('change', function() {
            const filiereId = this.value;
            const semesterSelect = document.getElementById('semester-select');

            semesterSelect.innerHTML = '<option value="">Select Semester</option>';

            if (semestersByFiliere[filiereId]) {
                semestersByFiliere[filiereId].forEach(sem => {
                    const option = document.createElement('option');
                    option.value = sem.id;
                    option.textContent = sem.semester;
                    semesterSelect.appendChild(option);
                });
            }
        });
    </script>
@endsection
