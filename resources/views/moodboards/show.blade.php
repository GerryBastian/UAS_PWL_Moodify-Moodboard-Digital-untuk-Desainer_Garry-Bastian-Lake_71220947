@extends('layouts.app')

@section('title', $moodboard->title . ' - Moodify')

@section('content')
<div>
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <!-- Header with Colors -->
        <div class="relative">
            <div class="flex justify-center">
                @if($moodboard->image_path)
                    <img src="{{ asset('storage/' . $moodboard->image_path) }}" alt="{{ $moodboard->title }}">
                </div>
            @else
                <div class="flex justify-center">
                    <img src="/public/storage/moodboard_images/no-image.jpg" alt="{{ $moodboard->title }}" class="w-full h-full object-cover">
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
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 p-6 bg-gray-50 rounded-xl">
                <!-- Creator -->
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center text-purple-600">
                        <i class="fas fa-user text-lg"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wide font-bold">Creator</p>
                        <p class="font-semibold text-gray-800">{{ $moodboard->creator }}</p>
                    </div>
                </div>

                @php
                    // Consistent simulated stats logic + Real DB count
                    $likes = $moodboard->created_at->gt(now()->subDay()) ? $moodboard->favorites_count : (100 + (($moodboard->id * 37) % 900) + $moodboard->favorites_count);
                    $views = $likes * 12 + (($moodboard->id * 7) % 100);
                @endphp

                <!-- Likes -->
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center text-red-500">
                        <i class="fas fa-heart text-lg"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wide font-bold">Likes</p>
                        <p class="font-semibold text-gray-800">{{ number_format($likes) }}</p>
                    </div>
                </div>

                <!-- Views -->
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-500">
                        <i class="fas fa-eye text-lg"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wide font-bold">Views</p>
                        <p class="font-semibold text-gray-800">{{ number_format($views) }}</p>
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
                        <div class="flex items-center justify-between">
                            <p class="font-mono text-sm font-semibold text-gray-800">
                                {{ $moodboard->$key }}
                            </p>
                            <button onclick="copyToClipboard('{{ $moodboard->$key }}', this)" 
                                    class="px-3 py-1 bg-gray-200 text-gray-700 text-xs font-semibold rounded-md hover:bg-gray-300">
                                Copy
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-3">
                @php
                    $backRoute = route('moodboards.index');
                    $backText = 'Back to List';
                    
                    if(request('mode') === 'preview') {
                        $backRoute = route('home');
                        $backText = 'Back to Home';
                    } elseif(request('from') === 'profile') {
                        $backRoute = route('user.profile');
                        $backText = 'Back to Profile';
                    }
                @endphp
                <a href="{{ $backRoute }}" 
                   class="flex-1 px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-semibold text-center">
                    <i class="fas fa-arrow-left mr-2"></i>
                    {{ $backText }}
                </a>

                @if(request('mode') !== 'preview' && request('from') !== 'profile')
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
                @endif
            </div>
        </div>
    </div>


</div>
@endsection

@section('scripts')
<script>
    function copyToClipboard(text, button) {
        navigator.clipboard.writeText(text).then(function() {
            button.innerText = 'Copied!';
            setTimeout(function() {
                button.innerText = 'Copy';
            }, 2000);
        }, function(err) {
            console.error('Could not copy text: ', err);
        });
    }
</script>
@endsection
