@extends('layouts.app')

@section('title', $moodboard->title . ' - Moodify')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <!-- Header with Colors -->
        <div class="relative">
            @if($moodboard->image_path)
                <img src="{{ asset('storage/' . $moodboard->image_path) }}" alt="{{ $moodboard->title }}" class="w-full h-64 object-cover">
            @else
                <div class="h-48 bg-gradient-to-r from-gray-100 to-gray-200 flex items-center justify-center">
                    <i class="fas fa-image text-gray-300 text-5xl"></i>
                </div>
            @endif
            <div class="absolute bottom-0 left-0 p-8 bg-gradient-to-t from-black/50 to-transparent w-full">
                <div class="flex gap-4">
                    <div class="w-16 h-16 rounded-xl shadow-lg border-4 border-white" 
                         style="background-color: {{ $moodboard->color_key_1 }}"></div>
                    <div class="w-16 h-16 rounded-xl shadow-lg border-4 border-white" 
                         style="background-color: {{ $moodboard->color_key_2 }}"></div>
                    <div class="w-16 h-16 rounded-xl shadow-lg border-4 border-white" 
                         style="background-color: {{ $moodboard->color_key_3 }}"></div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="p-8">
            <div class="flex items-start justify-between mb-6">
                <div>
                    <h1 class="text-4xl font-bold text-gray-800 mb-2">{{ $moodboard->title }}</h1>
                    <span class="inline-block px-4 py-2 bg-purple-100 text-purple-700 text-sm font-semibold rounded-full">
                        {{ ucfirst($moodboard->theme) }}
                    </span>
                </div>
            </div>

            <div class="prose max-w-none mb-8">
                <p class="text-gray-700 text-lg leading-relaxed">{{ $moodboard->description }}</p>
            </div>

            <!-- Meta Information -->
            <div class="grid md:grid-cols-2 gap-6 mb-8 p-6 bg-gray-50 rounded-xl">
                <div class="flex items-center gap-3">
                    <i class="fas fa-user text-purple-600 text-xl"></i>
                    <div>
                        <p class="text-sm text-gray-500">Creator</p>
                        <p class="font-semibold text-gray-800">{{ $moodboard->creator }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <i class="fas fa-calendar text-purple-600 text-xl"></i>
                    <div>
                        <p class="text-sm text-gray-500">Created</p>
                        <p class="font-semibold text-gray-800">{{ $moodboard->created_at->format('d F Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Color Details -->
            <div class="mb-8">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Color Palette</h3>
                <div class="grid md:grid-cols-3 gap-4">
                    @foreach(['color_key_1', 'color_key_2', 'color_key_3'] as $index => $key)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="w-full h-24 rounded-lg mb-3" 
                             style="background-color: {{ $moodboard->$key }}"></div>
                        <p class="text-center font-mono text-sm font-semibold text-gray-800">
                            {{ $moodboard->$key }}
                        </p>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-3">
                <a href="{{ route('moodboards.index') }}" 
                   class="flex-1 px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-semibold text-center">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to List
                </a>
                <a href="{{ route('moodboards.edit', $moodboard) }}" 
                   class="flex-1 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-semibold text-center">
                    <i class="fas fa-edit mr-2"></i>
                    Edit
                </a>
                <form action="{{ route('moodboards.destroy', $moodboard) }}" 
                      method="POST" 
                      onsubmit="return confirm('Are you sure you want to delete this moodboard?')"
                      class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="w-full px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-semibold">
                        <i class="fas fa-trash mr-2"></i>
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Timeline -->
    <div class="mt-8 bg-white rounded-xl shadow-md p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">
            <i class="fas fa-clock text-purple-600 mr-2"></i>
            Timeline
        </h3>
        <div class="space-y-3">
            <div class="flex items-center gap-3 text-sm">
                <i class="fas fa-plus-circle text-green-500"></i>
                <span class="text-gray-600">Created on</span>
                <span class="font-semibold text-gray-800">
                    {{ $moodboard->created_at->format('d F Y, H:i') }}
                </span>
            </div>
            @if($moodboard->updated_at != $moodboard->created_at)
            <div class="flex items-center gap-3 text-sm">
                <i class="fas fa-edit text-blue-500"></i>
                <span class="text-gray-600">Last updated on</span>
                <span class="font-semibold text-gray-800">
                    {{ $moodboard->updated_at->format('d F Y, H:i') }}
                </span>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection