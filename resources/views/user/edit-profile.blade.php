@extends('layouts.app')

@section('title', 'Edit Profile - Moodify')

@section('content')
<div class="bg-white rounded-xl shadow-md p-8 max-w-2xl mx-auto">
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-gray-800 mb-2">Edit Profile</h2>
        <p class="text-gray-500">Update informasi profil Anda</p>
    </div>

    <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')
        
        <div>
            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nama</label>
            <input type="text" 
                   name="name" 
                   id="name" 
                   value="{{ old('name', $user->name) }}"
                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('name') border-red-500 @enderror" 
                   required>
            @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">E-mail</label>
            <input type="email" 
                   name="email" 
                   id="email" 
                   value="{{ old('email', $user->email) }}"
                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('email') border-red-500 @enderror" 
                   required>
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password Baru (Kosongkan jika tidak ingin mengubah)</label>
            <input type="password" 
                   name="password" 
                   id="password" 
                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('password') border-red-500 @enderror">
            @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        
        <div>
            <label for="foto" class="block text-sm font-semibold text-gray-700 mb-2">Foto Profil</label>
            @if($user->foto)
                <div class="mb-3">
                    <img src="{{ asset('storage/'.$user->foto) }}" 
                         alt="{{ $user->name }}" 
                         class="w-24 h-24 rounded-full object-cover border-2 border-purple-200">
                </div>
            @endif
            <input type="file" 
                   name="foto" 
                   id="foto" 
                   accept="image/jpeg,image/png,image/jpg,image/gif" 
                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('foto') border-red-500 @enderror">
            <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG, GIF. Maksimal 2MB</p>
            @error('foto')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit" 
                    class="flex items-center gap-2 bg-gradient-to-r from-purple-600 to-pink-600 text-white px-6 py-3 rounded-lg hover:shadow-lg transition-all duration-300 font-semibold">
                <i class="fas fa-save"></i>
                Update Profile
            </button>
            <a href="{{ route('user.profile') }}" 
               class="flex items-center gap-2 bg-gray-100 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-200 transition-colors font-semibold">
                <i class="fas fa-arrow-left"></i>
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection



