{{-- resources/views/notifications/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Notifications')

@section('content')
<style>
    /* ===== Animations ===== */
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes popIn {
        0% { transform: scale(0); opacity: 0; }
        80% { transform: scale(1.1); opacity: 1; }
        100% { transform: scale(1); }
    }

    .animate-fadeUp {
        opacity: 0;
        animation: fadeUp 0.7s forwards;
    }

    .animate-popIn {
        animation: popIn 0.6s ease-out;
    }

    /* ===== Hover effects ===== */
    .notification-item {
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .notification-item:hover {
        transform: translateY(-4px);
        box-shadow: 0 6px 14px rgba(0, 0, 0, 0.08);
    }
</style>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 animate-fadeUp">
    <h2 class="text-3xl font-extrabold text-gray-900 mb-8">Notifications</h2>

    <div class="bg-white rounded-2xl shadow-lg overflow-hidden animate-fadeUp" style="animation-delay: 0.2s;">
        <div class="p-6 border-b border-gray-200 bg-indigo-50">
            <h3 class="text-2xl font-semibold text-indigo-700">All Notifications</h3>
        </div>

        <div class="divide-y divide-gray-200">
            @forelse($notifications as $index => $notification)
            <div class="p-6 hover:bg-indigo-50 transition-colors duration-300 cursor-pointer flex items-start space-x-5 notification-item animate-fadeUp"
                 style="animation-delay: {{ 0.1 * $index }}s;">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center shadow-inner animate-popIn">
                        <i class="fas fa-bell text-indigo-600 text-lg"></i>
                    </div>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-base font-semibold text-indigo-900 truncate">
                        {{ $notification->data['title'] ?? 'Notification' }}
                    </p>
                    <p class="mt-1 text-sm text-gray-600">
                        {{ $notification->data['message'] ?? '' }}
                    </p>
                    <p class="mt-2 text-xs text-gray-400">
                        {{ $notification->created_at->diffForHumans() }}
                    </p>
                </div>
                <div class="flex items-center">
                    <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-gray-400 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded-full p-1 transition" aria-label="Dismiss notification">
                            <i class="fas fa-times"></i>
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <p class="p-6 text-center text-gray-500 italic animate-fadeUp" style="animation-delay: 0.2s;">No notifications yet.</p>
            @endforelse
        </div>

        @if($notifications->count())
        <div class="p-6 bg-indigo-50 rounded-b-2xl flex justify-end animate-fadeUp" style="animation-delay: 0.3s;">
            <form action="{{ route('notifications.readAll') }}" method="POST">
                @csrf
                <button type="submit" class="text-indigo-700 font-semibold hover:text-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded-md transition px-4 py-2">
                    Mark all as read
                </button>
            </form>
        </div>
        @endif
    </div>
</div>
@endsection
