
@extends('layouts.app')
@section('content')
    <div class="min-h-screen bg-gradient-to-br  to-indigo-100  dark:to-gray-800 py-16 px-6 flex justify-center transition-colors">
        <div class="bg-white dark:bg-gray-800 shadow-2xl dark:shadow-gray-900/50 rounded-2xl p-10 w-full max-w-4xl animate-bounceIn border border-gray-200 dark:border-gray-700">

            <!-- Title -->
            <h1 class="text-4xl font-extrabold text-gray-800 dark:text-gray-100 text-center mb-6">
                <i class="fas fa-envelope text-blue-600 dark:text-blue-400 mr-3"></i>Contact Us
            </h1>
            <p class="text-gray-600 dark:text-gray-300 text-center mb-10">
                We'd love to hear from you! Fill in the form below and we will respond shortly.
            </p>

            <!-- Contact Form -->
            <form action="{{ route('contact.send') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- First Name -->
                    <div>
                        <label for="first_name" class="block text-gray-700 dark:text-gray-300 font-medium mb-1">
                            <i class="fas fa-user mr-2 text-blue-600 dark:text-blue-400"></i>First Name
                        </label>
                        <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}"
                            class="w-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-xl p-3 shadow-sm focus:ring-2 focus:ring-blue-400 dark:focus:ring-blue-500 focus:border-transparent transition-all placeholder-gray-500 dark:placeholder-gray-400"
                            required aria-describedby="first_name-error">
                        @error('first_name')
                            <p id="first_name-error" class="text-red-500 dark:text-red-400 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Last Name -->
                    <div>
                        <label for="last_name" class="block text-gray-700 dark:text-gray-300 font-medium mb-1">
                            <i class="fas fa-user mr-2 text-blue-600 dark:text-blue-400"></i>Last Name
                        </label>
                        <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}"
                            class="w-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-xl p-3 shadow-sm focus:ring-2 focus:ring-blue-400 dark:focus:ring-blue-500 focus:border-transparent transition-all placeholder-gray-500 dark:placeholder-gray-400"
                            required aria-describedby="last_name-error">
                        @error('last_name')
                            <p id="last_name-error" class="text-red-500 dark:text-red-400 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-gray-700 dark:text-gray-300 font-medium mb-1">
                        <i class="fas fa-envelope mr-2 text-blue-600 dark:text-blue-400"></i>Email
                    </label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                        class="w-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-xl p-3 shadow-sm focus:ring-2 focus:ring-blue-400 dark:focus:ring-blue-500 focus:border-transparent transition-all placeholder-gray-500 dark:placeholder-gray-400"
                        required aria-describedby="email-error">
                    @error('email')
                        <p id="email-error" class="text-red-500 dark:text-red-400 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-gray-700 dark:text-gray-300 font-medium mb-1">
                        <i class="fas fa-phone mr-2 text-blue-600 dark:text-blue-400"></i>Phone Number
                    </label>
                    <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                        class="w-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-xl p-3 shadow-sm focus:ring-2 focus:ring-blue-400 dark:focus:ring-blue-500 focus:border-transparent transition-all placeholder-gray-500 dark:placeholder-gray-400"
                        aria-describedby="phone-error">
                    @error('phone')
                        <p id="phone-error" class="text-red-500 dark:text-red-400 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Subject -->
                <div>
                    <label for="subject" class="block text-gray-700 dark:text-gray-300 font-medium mb-1">
                        <i class="fas fa-tag mr-2 text-blue-600 dark:text-blue-400"></i>Subject
                    </label>
                    <input type="text" id="subject" name="subject" value="{{ old('subject') }}"
                        class="w-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-xl p-3 shadow-sm focus:ring-2 focus:ring-blue-400 dark:focus:ring-blue-500 focus:border-transparent transition-all placeholder-gray-500 dark:placeholder-gray-400"
                        placeholder="What's this about?" aria-describedby="subject-error">
                    @error('subject')
                        <p id="subject-error" class="text-red-500 dark:text-red-400 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Message -->
                <div>
                    <label for="message" class="block text-gray-700 dark:text-gray-300 font-medium mb-1">
                        <i class="fas fa-comment-dots mr-2 text-blue-600 dark:text-blue-400"></i>Message
                    </label>
                    <textarea id="message" name="message" rows="5"
                        class="w-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-xl p-3 shadow-sm focus:ring-2 focus:ring-blue-400 dark:focus:ring-blue-500 focus:border-transparent transition-all resize-vertical placeholder-gray-500 dark:placeholder-gray-400"
                        placeholder="Tell us how we can help you..." required aria-describedby="message-error">{{ old('message') }}</textarea>
                    @error('message')
                        <p id="message-error" class="text-red-500 dark:text-red-400 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full bg-blue-600 dark:bg-blue-500 hover:bg-blue-700 dark:hover:bg-blue-600 active:bg-blue-800 dark:active:bg-blue-700 text-white font-semibold py-3 rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-500">
                    <i class="fas fa-paper-plane mr-2"></i>Send Message
                </button>
            </form>

            <!-- Contact Information -->
            <div class="mt-12 pt-8 border-t border-gray-200 dark:border-gray-600">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 text-center mb-6">
                    <i class="fas fa-info-circle text-blue-600 dark:text-blue-400 mr-2"></i>Get in Touch
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
                    <div class="bg-blue-50 dark:bg-gray-700 p-4 rounded-lg">
                        <a href="https://www.instagram.com/x_ossama.ta?igsh=ZzJpeXE1dTlhaDYz">
                            <i class="fab fa-instagram fa-2xl text-blue-600 dark:text-blue-400 mb-2"></i>
                            <h3 class="font-semibold text-gray-800 dark:text-gray-100">Instagram</h3>
                            <p class="text-gray-600 dark:text-gray-300">Developer Instagram</p>
                        </a>
                    </div>
                    <div class="bg-blue-50 dark:bg-gray-700 p-4 rounded-lg">
                        <a href="https://wa.me/message/AT7ZMJYXIRBQA1">
                            <i class="fab fa-whatsapp fa-2xl text-blue-600 dark:text-blue-400 mb-2"></i>
                            <h3 class="font-semibold text-gray-800 dark:text-gray-100">WhatsApp</h3>
                            <p class="text-gray-600 dark:text-gray-300">Developer WhatsApp</p>
                        </a>
                    </div>
                    <div class="bg-blue-50 dark:bg-gray-700 p-4 rounded-lg">
                        <a href="https://www.linkedin.com/in/ossama-taydi-453335317?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=android_app">
                            <i class="fab fa-linkedin fa-2xl text-blue-600 dark:text-blue-400 mb-2"></i>
                            <h3 class="font-semibold text-gray-800 dark:text-gray-100">LinkedIn</h3>
                            <p class="text-gray-600 dark:text-gray-300">Developer LinkedIn</p>
                        </a>
                    </div>
                </div>

            <!-- Footer -->
            <p class="text-center text-gray-500 dark:text-gray-400 text-sm mt-8">
                <i class="fas fa-clock mr-1"></i>We usually respond within 24 hours.
            </p>

        </div>
    </div>
@endsection
