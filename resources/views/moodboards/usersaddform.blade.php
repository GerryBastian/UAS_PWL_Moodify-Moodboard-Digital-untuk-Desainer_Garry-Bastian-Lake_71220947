@extends('layouts.app')
@section('title', 'users')
@section('content')
    @if(session('success'))
        <div class="alert alert-success p-2 mb-3">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">

        </div>
        <div class="card-body">
            <form action="{{ route('users.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name">Nama</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="photo">Foto</label>
                    <input type="file" name="photo" id="photo" accept="image/*" class="form-control-file">
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">SUBMIT</button>
                </div>

            </form>
        </div>
    </div>
@endsection
