@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-8">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-8">Login to Your Account</h2>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-4">
            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email Address</label>
            <input id="email" type="email" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-500 @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
            @error('email')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6" x-data="{ show: false }">
            <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
            <div class="relative">
                <input id="password" :type="show ? 'text' : 'password'" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline @error('password') border-red-500 @enderror" name="password" required autocomplete="current-password">
                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5 mb-3">
                    <i class="fas" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                </button>
            </div>
            @error('password')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center">
                <input class="mr-2 leading-tight" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="text-sm text-gray-600" for="remember">
                    Remember Me
                </label>
            </div>
            <a href="{{ route('password.request') }}" class="inline-block align-baseline font-bold text-sm text-purple-600 hover:text-purple-800">
                Forgot Password?
            </a>
        </div>

        <div class="flex items-center justify-center">
            <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Login
            </button>
        </div>
    </form>

    <p class="text-center text-gray-600 text-sm mt-8">
        Don't have an account? 
        <a href="{{ route('register') }}" class="font-medium text-purple-600 hover:text-purple-500">
            Sign up
        </a>
    </p>
</div>
@endsection
