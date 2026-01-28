@extends('layouts.app')

@section('title', 'Register')
@section('content')
    <div
        class="min-h-screen flex items-center justify-center bg-gradient-to-br  via-indigo-50 to-purple-50  dark:via-gray-800 dark:to-gray-900 py-12 px-4 sm:px-6 lg:px-8 transition-all duration-500">
        <div class="max-w-md w-full space-y-8  dark:bg-gray-800 p-8 rounded-2xl shadow-2xl dark:shadow-gray-900/50 border border-gray-100 dark:border-gray-700 backdrop-blur-sm">
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900 dark:text-gray-100 bg-gradient-to-r from-blue-600 to-purple-600 dark:from-blue-400 dark:to-purple-400 bg-clip-text text-transparent">
                    Create your account
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600 dark:text-gray-400">
                    Join our learning community
                </p>
            </div>
            <form class="mt-8 space-y-6" action="{{ route('register') }}" method="POST">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <input id="first_name" name="first_name" type="text" required
                            class="appearance-none relative block w-full px-3 py-3 border border-gray-300 dark:border-gray-600 placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-700 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            placeholder="First Name"  value="{{ old('first_name') }}">
                        @error('first_name')
                            <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <input id="last_name" type="text" required
                            class="appearance-none relative block w-full px-3 py-3 border border-gray-300 dark:border-gray-600 placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-700 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            placeholder="Last Name" name='last_name' value="{{ old('last_name') }}">
                        @error('last_name')
                            <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div>
                    <input id="email" name="email" type="email" required
                        class="appearance-none relative block w-full px-3 py-3 border border-gray-300 dark:border-gray-600 placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-700 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        placeholder="Email address" value="{{ old('email') }}">
                    @error('email')
                        <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <input id="password" name="password" type="password" required
                        class="appearance-none relative block w-full px-3 py-3 border border-gray-300 dark:border-gray-600 placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-700 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        placeholder="Password">
                    @error('password')
                        <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <input id="password_confirmation" name="password_confirmation" type="password" required
                        class="appearance-none relative block w-full px-3 py-3 border border-gray-300 dark:border-gray-600 placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-700 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        placeholder="Confirm Password">
                </div>

                <div class="mt-4">
                    <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Choose your role:</label>
                    <select id="role" name="role"
                        class="mt-1 block w-full py-2 px-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        onchange="toggleMatriculeInput(this)">
                        <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Student</option>
                        <option value="teatcher" {{ old('role') == 'teatcher' ? 'selected' : '' }}>Teatcher</option>
                    </select>
                    @error('role')
                        <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <div id="matricule-input" class="mt-2"
                        style="display: {{ old('role') == 'teatcher' ? 'block' : 'none' }};">
                        <input type="text" name="matricule" placeholder="Matricule"
                            class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-md placeholder-gray-500 dark:placeholder-gray-400"
                            value="{{ old('matricule') }}" />
                        @error('matricule')
                            <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <script>
                        function toggleMatriculeInput(selectElement) {
                            const matriculeInput = document.getElementById('matricule-input');
                            if (selectElement.value === 'teatcher') {
                                matriculeInput.style.display = 'block';
                            } else {
                                matriculeInput.style.display = 'none';
                            }
                        }
                    </script>

                </div>

                <div>
                    <button type="submit"
                        class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 dark:bg-green-500 hover:bg-green-700 dark:hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Create Account
                    </button>
                    <div class="text-center mt-4">
                        <span class="text-gray-600 dark:text-gray-400">Already have an account?</span>
                        <a href="{{ route('login.form') }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-medium">
                            Login in
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
