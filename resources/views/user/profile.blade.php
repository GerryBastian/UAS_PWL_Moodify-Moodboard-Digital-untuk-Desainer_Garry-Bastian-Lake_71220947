@extends('layouts.app')

@section('title', 'My Profile - Moodify')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800">My Profile</h1>
    <p class="text-gray-500 mt-2">Kelola informasi profil Anda</p>
</div>

<!-- Profile Card -->
<div class="bg-white rounded-xl shadow-md p-8 mb-8">
    <div class="flex items-start gap-6">
        <div class="flex-shrink-0">
            @php
                $imageUrl = $user->foto 
                    ? asset('storage/'.$user->foto) 
                    : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=9333ea&color=fff&size=128';
            @endphp
            <img src="{{ $imageUrl }}" 
                 alt="{{ $user->name }}" 
                 class="w-32 h-32 rounded-full object-cover border-4 border-purple-200"
                 onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=9333ea&color=fff&size=128';">
        </div>
        <div class="flex-1">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">{{ $user->name }}</h2>
                    <p class="text-gray-500">{{ $user->email }}</p>
                    <span class="inline-block mt-2 px-3 py-1 text-sm font-semibold rounded-full {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-gray-100 text-gray-700' }}">
                        {{ ucfirst($user->role) }}
                    </span>
                </div>
                <a href="{{ route('user.profile.edit') }}" 
                   class="flex items-center gap-2 bg-gradient-to-r from-purple-600 to-pink-600 text-white px-4 py-2 rounded-lg hover:shadow-lg transition-all duration-300 font-semibold">
                    <i class="fas fa-edit"></i>
                    Edit Profile
                </a>
            </div>
            <div class="grid grid-cols-2 gap-4 text-sm">

                <div>
                    <p class="text-gray-500">Total Moodboards</p>
                    <p class="font-semibold text-gray-800">{{ $moodboards->count() }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- My Moodboards -->
<!-- My Moodboards -->
<div class="bg-white rounded-xl shadow-md p-6 mb-8">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold text-gray-800">My Moodboards</h2>
        <a href="{{ route('moodboards.create') }}" 
           class="flex items-center gap-2 bg-gradient-to-r from-purple-600 to-pink-600 text-white px-4 py-2 rounded-lg hover:shadow-lg transition-all duration-300 font-semibold">
            <i class="fas fa-plus"></i>
            Create New
        </a>
    </div>
    
    @if($moodboards->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($moodboards as $moodboard)
        <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-shadow">
            @if($moodboard->image_path)
                <img src="{{ asset('storage/'.$moodboard->image_path) }}" 
                     alt="{{ $moodboard->title }}" 
                     class="w-full h-48 object-cover">
            @else
                <div class="w-full h-48 bg-gradient-to-br from-purple-200 to-pink-200 flex items-center justify-center">
                    <i class="fas fa-palette text-white text-4xl opacity-50"></i>
                </div>
            @endif
            <div class="p-4">
                <h3 class="font-semibold text-gray-800 mb-2">{{ $moodboard->title }}</h3>
                <p class="text-sm text-gray-500 mb-3">{{ Str::limit($moodboard->description, 60) }}</p>
                <div class="flex items-center justify-between">
                    <span class="px-2 py-1 text-xs font-semibold bg-purple-100 text-purple-700 rounded">
                        {{ ucfirst($moodboard->theme) }}
                    </span>
                    <div class="flex gap-2">
                        <a href="{{ route('moodboards.show', ['moodboard' => $moodboard, 'from' => 'profile']) }}" 
                           class="text-purple-600 hover:text-purple-700 text-sm font-semibold">
                            View <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="text-center py-12">
        <i class="fas fa-palette text-gray-300 text-5xl mb-4"></i>
        <p class="text-gray-500 mb-4">Anda belum membuat moodboard</p>
        <a href="{{ route('moodboards.create') }}" 
           class="inline-flex items-center gap-2 bg-gradient-to-r from-purple-600 to-pink-600 text-white px-6 py-3 rounded-lg hover:shadow-lg transition-all duration-300 font-semibold">
            <i class="fas fa-plus"></i>
            Create Your First Moodboard
        </a>
    </div>
    @endif
</div>

<!-- My Favorites -->
<div class="bg-white rounded-xl shadow-md p-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold text-gray-800">My Favorites</h2>
    </div>
    
    @if($favorites->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($favorites as $fav)
        <div class="border border-red-100 rounded-lg overflow-hidden hover:shadow-lg transition-shadow">
            @if($fav->image_path)
                <img src="{{ asset('storage/'.$fav->image_path) }}" 
                     alt="{{ $fav->title }}" 
                     class="w-full h-48 object-cover">
            @else
                <div class="w-full h-48 bg-gradient-to-br from-red-200 to-pink-200 flex items-center justify-center">
                    <i class="fas fa-heart text-white text-4xl opacity-50"></i>
                </div>
            @endif
            <div class="p-4 bg-red-50">
                <h3 class="font-semibold text-gray-800 mb-1">{{ $fav->title }}</h3>
                <p class="text-xs text-gray-500 mb-2">by {{ $fav->creator }}</p>
                <div class="flex items-center justify-between">
                    <span class="px-2 py-1 text-xs font-semibold bg-white text-red-500 rounded border border-red-200">
                        {{ ucfirst($fav->theme) }}
                    </span>
                    <a href="{{ route('moodboards.show', ['moodboard' => $fav, 'from' => 'profile']) }}" 
                       class="text-red-600 hover:text-red-700 text-sm font-semibold">
                        View <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="text-center py-12">
        <i class="far fa-heart text-gray-300 text-5xl mb-4"></i>
        <p class="text-gray-500 mb-4">You haven't liked any moodboards yet.</p>
        <a href="{{ route('home') }}" 
           class="inline-flex items-center gap-2 bg-white border border-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-50 transition-colors font-semibold">
            Explore Moodboards
        </a>
    </div>
    @endif
</div>


@endsection



