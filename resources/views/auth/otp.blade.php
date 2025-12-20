@extends('layouts.auth')

@section('title', 'Masukkan Kode OTP')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-8">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-4">Masukkan Kode OTP</h2>
    <p class="text-center text-gray-600 mb-8">Kode OTP telah dikirimkan kepada Anda. Silakan masukkan di bawah ini.</p>



    @if (session('status'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('otp.verify') }}">
        @csrf

        <div class="mb-4">
            <label for="otp" class="block text-gray-700 text-sm font-bold mb-2">Kode OTP</label>
            <input id="otp" type="text" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('otp') border-red-500 @enderror" name="otp" required autofocus>
            @error('otp')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-center">
            <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full">
                Verifikasi
            </button>
        </div>
    </form>
</div>
@endsection
