@extends('layouts.app')
@section('title', '.:Users:.')
@section('content')

    @if(session('success'))
        <div class="alert alert-success p-2 mb-3">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <a href="{{ route('users.create') }}" class="btn btn-primary"><i class="bi bi-plus-square"></i> User</a>
        </div>
        <div class="card-body">
            <table id="example" class="display" style="width: 100%;">

                <thead>

                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>E-mail</th>
                        <th>Foto</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($users as $idx => $m)
                        <tr>
                            <td>{{ $idx + 1 }}</td>
                            <td>{{ $m->name }}</td>
                            <td>{{ $m->email }}</td>
                            <td>
                                @if ($m->foto && file_exists(public_path('storage/' . $m->foto)))
                                    <img src="{{ asset('storage/' . $m->foto) }}" alt="{{ $m->name }}" width="80" height="80">
                                @else
                                    <img src="{{ asset('storage/foto/no-image.jpg') }}" alt="No Image" width="80" height="80">
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('users.destroy', $m) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
@endsection
