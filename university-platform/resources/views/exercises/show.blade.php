@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-4">{{ $exercise->title }}</h1>

    <p class="mb-6">{{ $exercise->description ?? __('No description available') }}</p>

    <div class="mb-6">
        <a href="{{ route('exercises.download', $exercise) }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            {{ __('Download exercise') }}
        </a>
    </div>

    <a href="{{ route('exercises.index') }}" class="text-blue-600 hover:underline">
        {{ __('Back to Courses') }}
    </a>
</div>
@endsection


