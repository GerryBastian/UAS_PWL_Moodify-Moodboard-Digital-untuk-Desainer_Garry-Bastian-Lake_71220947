@extends('layouts.main')
@section('title', '.:Home:.')
@section('content')
    <h3>HOME</h3>
    <p>Selamat datang, {{ Auth::user()->name }}!</p>
@endsection