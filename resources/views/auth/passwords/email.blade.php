@extends('layouts.auth')

@section('title', 'Lupa Password')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-8">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-4">Lupa Password?</h2>
    <p class="text-center text-gray-600 mb-8">Jangan khawatir! Masukkan email Anda dan kami akan mengirimkan link untuk mengatur ulang password.</p>

    @if (session('status'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-4">
            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Alamat Email</label>
            <input id="email" type="email" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-500 @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
            @error('email')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-center">
            <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full">
                Kirim Link Reset Password
            </button>
        </div>
    </form>

    <p class="text-center text-gray-600 text-sm mt-8">
        Ingat password Anda? 
        <a href="{{ route('login') }}" class="font-medium text-purple-600 hover:text-purple-500">
            Login
        </a>
    </p>
</div>
@endsection
