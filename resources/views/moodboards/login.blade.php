@extends('layouts.auth')

@section('title', 'Login - Moodify')

@section('content')
<div class="flex items-center justify-center">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <h1 class="text-3xl font-bold text-gray-800 text-center mb-2">Welcome Back!</h1>
            <p class="text-gray-500 text-center mb-8">Login to continue to Moodify</p>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-semibold mb-2">Email Address</label>
                    <input id="email" type="email"
                           class="w-full px-4 py-2 border @error('email') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600"
                           name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <div class="flex justify-between items-center mb-2">
                        <label for="password" class="block text-gray-700 font-semibold">Password</label>
                        @if (Route::has('password.request'))
                            <a class="text-sm text-purple-600 hover:underline" href="{{ route('password.request') }}">
                                Forgot Password?
                            </a>
                        @endif
                    </div>
                    <input id="password" type="password"
                           class="w-full px-4 py-2 border @error('password') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600"
                           name="password" required autocomplete="current-password">

                    @error('password')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="mb-6 flex items-center">
                    <input class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="ml-2 block text-sm text-gray-900" for="remember">
                        Remember me
                    </label>
                </div>

                <!-- Submit Button -->
                <div class="mb-6">
                    <button type="submit" class="w-full px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg hover:shadow-lg transition-all duration-300 font-semibold text-center">
                        Login
                    </button>
                </div>

                <p class="text-center text-sm text-gray-600">
                    Don't have an account? <a href="{{ route('register') }}" class="font-semibold text-purple-600 hover:underline">Sign up</a>
                </p>
            </form>
        </div>
    </div>
</div>
@endsection