@extends('layouts.app')
@section('title', '.:Users:.')
@section('content')

<div class="bg-white rounded-xl shadow-md p-6 mb-8">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Users Management</h2>
        <a href="/users/addform" class="flex items-center gap-2 bg-gradient-to-r from-purple-600 to-pink-600 text-white px-4 py-2 rounded-lg hover:shadow-lg transition-all duration-300 font-semibold">
            <i class="fas fa-plus"></i>
            User
        </a>
    </div>

    <div class="overflow-x-auto">
        <table id="usersTable" class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">E-mail</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Foto</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($users as $idx => $m)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $idx + 1 }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $m->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $m->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $imageUrl = $m->foto 
                                    ? asset('storage/'.$m->foto) 
                                    : 'https://ui-avatars.com/api/?name='.urlencode($m->name).'&background=9333ea&color=fff&size=128';
                            @endphp
                            <img src="{{ $imageUrl }}" 
                                 alt="{{ $m->name }}" 
                                 class="w-16 h-16 rounded-full object-cover border-2 border-purple-200"
                                 onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($m->name) }}&background=9333ea&color=fff&size=128';">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <a href="/users/delete/{{ $m->id }}" 
                               onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')"
                               class="inline-flex items-center gap-2 bg-red-50 text-red-600 px-4 py-2 rounded-lg hover:bg-red-100 transition-colors">
                                <i class="fas fa-trash"></i>
                                Hapus
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<style>
    #usersTable_wrapper .dataTables_filter input {
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
        padding: 0.5rem 1rem;
        margin-left: 0.5rem;
    }
    #usersTable_wrapper .dataTables_filter input:focus {
        outline: none;
        border-color: #9333ea;
        ring: 2px;
        ring-color: #9333ea;
    }
    #usersTable_wrapper .dataTables_length select {
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
        padding: 0.5rem;
    }
    #usersTable_wrapper .dataTables_paginate .paginate_button {
        padding: 0.5rem 1rem;
        margin: 0 0.25rem;
        border-radius: 0.5rem;
        border: 1px solid #d1d5db;
    }
    #usersTable_wrapper .dataTables_paginate .paginate_button:hover {
        background: linear-gradient(to right, #9333ea, #db2777);
        color: white !important;
        border-color: transparent;
    }
    #usersTable_wrapper .dataTables_paginate .paginate_button.current {
        background: linear-gradient(to right, #9333ea, #db2777);
        color: white !important;
        border-color: transparent;
    }
</style>
<script>
    $(document).ready(function() {
        $('#usersTable').DataTable({
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data per halaman",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                infoFiltered: "(disaring dari _MAX_ total data)",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Selanjutnya",
                    previous: "Sebelumnya"
                }
            }
        });
    });
</script>
@endsection