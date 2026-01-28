@extends('layouts.app')

@section('title', 'login')
@section('content')
    <div
        class="min-h-screen flex items-center justify-center bg-gradient-to-br  via-indigo-50 to-purple-50  dark:via-gray-800 dark:to-gray-900 py-12 px-4 sm:px-6 lg:px-8 transition-all duration-500">
        <div class="max-w-md w-full space-y-8 bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-2xl dark:shadow-gray-900/50 border border-gray-100 dark:border-gray-700 backdrop-blur-sm">
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900 dark:text-gray-100 bg-gradient-to-r from-blue-600 to-purple-600 dark:from-blue-400 dark:to-purple-400 bg-clip-text text-transparent">
                    Sign in to your account
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600 dark:text-gray-400">
                    Welcome back to our learning platform
                </p>
            </div>
            <form class="mt-8 space-y-6" action="{{ route('login') }}" method="POST">
                @csrf
                @if ($errors->any())
                    <div class="bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-600 text-red-700 dark:text-red-300 px-4 py-3 rounded mb-4">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="rounded-md shadow-sm -space-y-px">
                    <div>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required
                            class="appearance-none rounded-none relative block w-full px-3 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-gray-100 rounded-t-md focus:outline-none focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-indigo-500 focus:z-10 sm:text-sm"
                            placeholder="Email address">
                    </div>
                    <div>
                        <input id="password" name="password" type="password" required
                            class="appearance-none rounded-none relative block w-full px-3 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-gray-100 rounded-b-md focus:outline-none focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-indigo-500 focus:z-10 sm:text-sm"
                            placeholder="Password">
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-md transform transition-transform duration-200 hover:scale-105">
                        Login in
                    </button>
                    <p class="mt-4 text-center text-sm text-gray-600">
                        Don't have an account?
                        <a href="{{ route('register.form') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                            Create one
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
@endsection
