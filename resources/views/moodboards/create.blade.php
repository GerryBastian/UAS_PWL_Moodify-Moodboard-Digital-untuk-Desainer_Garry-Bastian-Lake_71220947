@extends('layouts.app')

@section('title', 'Create New Moodboard')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-xl p-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Create a New Moodboard</h1>

    <form action="{{ route('moodboards.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Title -->
        <div class="mb-4">
            <label for="title" class="block text-gray-700 font-semibold mb-2">Title</label>
            <input type="text" id="title" name="title" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600" required>
        </div>

        <!-- Description -->
        <div class="mb-4">
            <label for="description" class="block text-gray-700 font-semibold mb-2">Description</label>
            <textarea id="description" name="description" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600" required></textarea>
        </div>

        <!-- Image -->
        <div class="mb-4">
            <label for="image" class="block text-gray-700 font-semibold mb-2">Image</label>
            <input type="file" id="image" name="image" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600">
        </div>

        <!-- Creator -->
        <div class="mb-4">
            <label for="creator" class="block text-gray-700 font-semibold mb-2">Creator</label>
            <input type="text" id="creator" name="creator" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600" required>
        </div>

        <!-- Theme -->
        <div class="mb-4">
            <label for="theme" class="block text-gray-700 font-semibold mb-2">Theme</label>
            <select id="theme" name="theme" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600">
                @foreach($themes as $theme)
                    <option value="{{ $theme }}" {{ old('theme') == $theme ? 'selected' : '' }}>
                        {{ ucfirst($theme) }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Color Palette -->
        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">Color Palette</label>
            <div class="grid grid-cols-3 gap-4">
                @for($i = 1; $i <= 3; $i++)
                <div>
                    <label class="block text-xs text-gray-600 mb-2">Color {{ $i }}</label> 
                    <input type="color"
                           id="color_picker_{{ $i }}"
                           value="{{ old('color_key_'.$i, '#ffffff') }}"
                           class="w-full h-12 rounded-lg cursor-pointer border-2 border-gray-300">
                    <input type="text"
                           name="color_key_{{ $i }}"
                           id="color_text_{{ $i }}"
                           value="{{ old('color_key_'.$i, '#ffffff') }}"
                           class="w-full mt-2 px-2 py-1 text-xs border border-gray-300 rounded text-center font-mono"
                           pattern="^#[0-9A-Fa-f]{6}$"
                           required>
                </div>
                @endfor
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-3">
            <a href="{{ route('moodboards.index') }}" class="flex-1 px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-semibold text-center">
                Cancel
            </a>
            <button type="submit" class="flex-1 px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg hover:shadow-lg transition-all duration-300 font-semibold text-center">
                Create Moodboard
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    for (let i = 1; i <= 3; i++) {
        const colorPicker = document.getElementById(`color_picker_${i}`);
        const colorText = document.getElementById(`color_text_${i}`);

        colorPicker.addEventListener('input', (event) => {
            colorText.value = event.target.value;
        });

        colorText.addEventListener('input', (event) => {
         
            let value = event.target.value;
            if (value.length > 0 && value[0] !== '#') {
                value = '#' + value;
            }
            colorPicker.value = value;
        });
    }
});
</script>
@endsection
