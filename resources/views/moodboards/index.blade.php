@extends('layouts.app')

@section('title', 'Moodboards - Moodify')

@section('content')
<!-- Search & Filter -->
@if(!isset($context) || $context !== 'management')
<div class="bg-white rounded-xl shadow-md p-6 mb-8">
    <form method="GET" action="{{ isset($context) && $context === 'discovery' ? route('home') : route('moodboards.index') }}" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
        <!-- New Moodboard Button -->
        @if(isset($context) && $context === 'management')
            <!-- Button moved to card-header -->
        @endif
        
        <!-- Search -->
        <div class="relative md:col-span-10">
            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
            <input type="text" 
                   name="search" 
                   value="{{ request('search') }}"
                   placeholder="Search moodboards..."
                   class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
        </div>
        <!-- Search Button -->
        <div class="md:col-span-2">
            <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-pink-600 hover:opacity-90 text-white font-bold py-3 px-4 rounded-lg transition-all shadow-md flex items-center justify-center gap-2 transform hover:-translate-y-0.5">
                <i class="fas fa-search"></i> Search
            </button>
        </div>
    </form>
</div>
@endif

@if($moodboards->count() > 0)

    @if(isset($context) && $context === 'management')
    
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="font-weight-bold m-0 text-gray-800">Moodboard Management</h4>
                <a href="{{ route('moodboards.create') }}" class="btn text-white font-weight-bold px-4 py-2" style="background: linear-gradient(90deg, #9333ea 0%, #db2777 100%); border: none; border-radius: 8px;">
                    <i class="fas fa-plus mr-2"></i> Moodboard
                </a>
            </div>

            <table id="example" class="table table-hover" style="width: 100%;">
                <thead>
                    <tr class="text-uppercase text-muted small border-bottom">
                        <th class="border-0 font-weight-bold" style="width: 5%;">No</th>
                        <th class="border-0 font-weight-bold" style="width: 15%;">Image</th>
                        <th class="border-0 font-weight-bold">Title</th>
                        <th class="border-0 font-weight-bold">Creator</th>
                        <th class="border-0 font-weight-bold">Theme</th>
                        <th class="border-0 font-weight-bold text-center" style="width: 15%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($moodboards as $idx => $moodboard)
                    <tr>
                        <td class="align-middle">{{ $idx + 1 }}</td>
                        <td class="align-middle">
                            @if($moodboard->image_path && Storage::exists('public/' . $moodboard->image_path))
                                <img src="{{ asset('storage/' . $moodboard->image_path) }}" 
                                     alt="{{ $moodboard->title }}" 
                                     class="rounded-3 shadow-sm"
                                     style="width: 80px; height: 80px; object-fit: cover;">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center rounded-3 text-muted shadow-sm" style="width: 80px; height: 80px;">
                                    <i class="fas fa-image fa-lg"></i>
                                </div>
                            @endif
                        </td>
                        <td class="align-middle font-weight-bold">{{ $moodboard->title }}</td>
                        <td class="align-middle text-muted small">{{ $moodboard->creator ?? 'Anonymous' }}</td>
                        <td class="align-middle">
                            <span class="badge px-3 py-2 rounded-pill" style="background-color: #f3e8ff; color: #9333ea;">{{ ucfirst($moodboard->theme) }}</span>
                        </td>
                        <td class="align-middle text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('moodboards.edit', $moodboard) }}" class="btn btn-sm font-weight-bold d-flex align-items-center gap-2 px-3 py-2" style="background-color: #fff9c4; color: #f59e0b; border-radius: 8px; border: none;">
                                    <i class="fas fa-pen"></i> Edit
                                </a>
                                <form action="{{ route('moodboards.destroy', $moodboard) }}" method="POST" onsubmit="return confirm('Delete this moodboard?')" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm font-weight-bold d-flex align-items-center gap-2 px-3 py-2" style="background-color: #ffe4e6; color: #e11d48; border-radius: 8px; border: none;">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                                <a href="{{ route('moodboards.show', $moodboard) }}" class="btn btn-sm font-weight-bold d-flex align-items-center gap-2 px-3 py-2" style="background-color: #e0f2fe; color: #0284c7; border-radius: 8px; border: none;">
                                    <i class="fas fa-eye"></i> Lihat
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- DataTables Script -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                language: {
                    lengthMenu: "Tampilkan _MENU_ data per halaman",
                    zeroRecords: "Data tidak ditemukan",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                    infoFiltered:("(disaring dari _MAX_ total data)"),
                    search: "Cari:",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Selanjutnya",
                        previous: "Sebelumnya"
                    }
                },
                "dom": '<"d-flex justify-content-between align-items-center mb-3"lf>rt<"d-flex justify-content-between align-items-center mt-3"ip>',
                "ordering": true,
                "stateSave": true,
                "columnDefs": [
                    { "orderable": false, "targets": [1, 5] } // Disable sorting for Image and Actions
                ]
            });
        });
    </script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .dataTables_wrapper .dataTables_length select {
            padding-right: 30px !important;
            padding-left: 10px !important;
            border-radius: 8px;
            border-color: #dee2e6;
        }
        .dataTables_wrapper .dataTables_filter input {
            border-radius: 8px;
            border-color: #dee2e6;
            padding: 5px 15px;
        }
        .table thead th {
            font-size: 0.75rem;
            letter-spacing: 1px;
        }
        .page-item.active .page-link {
            background: linear-gradient(90deg, #9333ea 0%, #db2777 100%);
            border: none;
            color: white;
            box-shadow: 0 2px 4px rgba(147, 51, 234, 0.3);
        }
        .page-link {
            color: #6b7280;
            border-radius: 8px !important;
            margin: 0 4px;
            border: 1px solid #e5e7eb;
            font-weight: 600;
        }
        .page-link:hover {
            background-color: #f3f4f6;
            color: #9333ea;
        }
        .page-item:first-child .page-link, .page-item:last-child .page-link {
            border-radius: 8px !important;
            background: white;
            color: #9333ea;
            border: 1px solid #e5e7eb;
        }
        .page-item:first-child .page-link:hover, .page-item:last-child .page-link:hover {
            background: linear-gradient(90deg, #9333ea 0%, #db2777 100%);
            color: white;
            border: none;
            opacity: 1;
        }
        .page-item.disabled .page-link {
            background: #f3f4f6;
            color: #9ca3af;
            border: 1px solid #e5e7eb;
            background-image: none; /* Remove gradient if disabled */
        }
        .btn-light:hover {
            background-color: #f3f4f6;
        }
        /* Action Button Hovers */
        .btn-hover-warning, .btn-hover-danger, .btn-hover-info {
            transition: all 0.3s ease;
        }
        .btn-hover-warning:hover {
            background-color: #fff3cd !important;
            color: #856404 !important;
            transform: translateY(-2px);
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.15) !important;
        }
        .btn-hover-danger:hover {
            background-color: #f8d7da !important;
            color: #721c24 !important;
            transform: translateY(-2px);
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.15) !important;
        }
        .btn-hover-info:hover {
            background-color: #cff4fc !important;
            color: #055160 !important;
            transform: translateY(-2px);
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.15) !important;
        }
    </style>
    @else
    <!-- Moodboard Grid (Discovery Layout) -->
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        @foreach($moodboards as $moodboard)
        <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
            <a href="{{ route('moodboards.show', ['moodboard' => $moodboard, 'mode' => 'preview']) }}" class="block">
                <div class="relative h-48">
                    @if($moodboard->image_path && Storage::exists('public/' . $moodboard->image_path))
                        <img src="{{ asset('storage/' . $moodboard->image_path) }}" 
                             alt="{{ $moodboard->title }}" 
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-purple-200 to-pink-200 flex items-center justify-center">
                            <i class="fas fa-palette text-white text-6xl opacity-50"></i>
                        </div>
                    @endif
                    <div class="absolute bottom-2 left-2 flex gap-2">
                        <div class="w-8 h-8 rounded-md shadow-md border-2 border-white" 
                             style="background-color: {{ $moodboard->color_key_1 ?? '#cccccc' }}"></div>
                        <div class="w-8 h-8 rounded-md shadow-md border-2 border-white" 
                             style="background-color: {{ $moodboard->color_key_2 ?? '#cccccc' }}"></div>
                        <div class="w-8 h-8 rounded-md shadow-md border-2 border-white" 
                             style="background-color: {{ $moodboard->color_key_3 ?? '#cccccc' }}"></div>
                    </div>
                    <!-- Action Icons -->
                    <div class="absolute top-2 right-2 flex gap-2">
                         <button type="button" class="w-8 h-8 rounded-full bg-white/90 hover:bg-white text-gray-600 shadow-sm flex items-center justify-center transition-all hover:scale-110 backdrop-blur-sm" title="Share" onclick="event.preventDefault(); alert('Share clicked!')">
                             <i class="fas fa-share-alt text-xs"></i>
                         </button>
                         <button type="button" class="w-8 h-8 rounded-full bg-white/90 hover:bg-white text-gray-600 shadow-sm flex items-center justify-center transition-all hover:scale-110 backdrop-blur-sm" title="Copy Link" onclick="event.preventDefault(); navigator.clipboard.writeText('{{ route('moodboards.show', $moodboard) }}'); alert('Link copied!');">
                             <i class="fas fa-link text-xs"></i>
                         </button>
                    </div>
                </div>
            </a>
            
            <!-- Card Content -->
            <div class="p-6">
                <!-- Code ID -->

                <div class="flex items-start justify-between mb-3">
                    <h3 class="text-xl font-bold text-gray-800">{{ $moodboard->title }}</h3>
                    <span class="px-3 py-1 bg-purple-100 text-purple-700 text-xs font-semibold rounded-full">
                        {{ ucfirst($moodboard->theme) }}
                    </span>
                </div>
                
                <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                    {{ Str::limit($moodboard->description, 100) }}
                </p>

                <div class="flex items-center gap-2 text-sm text-gray-500 mb-4">
                    <i class="fas fa-user"></i>
                    <span>{{ $moodboard->creator ?? 'Anonymous' }}</span>
                </div>



                <div class="flex gap-2">
                    <a href="{{ route('moodboards.show', ['moodboard' => $moodboard, 'mode' => 'preview']) }}" 
                       class="flex-1 flex items-center justify-center gap-2 bg-purple-50 text-purple-600 px-4 py-2 rounded-lg hover:bg-purple-100 transition-colors font-semibold">
                        <i class="fas fa-eye"></i> View Details
                    </a>
                    <form action="{{ route('moodboards.favorite', $moodboard) }}" method="POST" class="flex-none flex items-center gap-2">
                        @csrf
                        <span class="text-xs font-semibold text-gray-500">
                            {{ $moodboard->created_at->gt(now()->subDay()) ? $moodboard->favorites_count : (100 + (($moodboard->id * 37) % 900) + $moodboard->favorites_count) }}
                        </span>
                        <button type="submit" class="w-10 h-full flex items-center justify-center transition-transform hover:scale-110 {{ Auth::user()->favorites->contains($moodboard->id) ? 'text-red-500' : 'text-gray-300 hover:text-red-500' }} border border-gray-200 rounded-lg hover:border-red-200">
                            <i class="{{ Auth::user()->favorites->contains($moodboard->id) ? 'fas' : 'far' }} fa-heart text-xl"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <!-- Pagination -->
    @if(!isset($context) || $context !== 'management')
    <div class="mt-6">
        {{ $moodboards->links('pagination.tailwind') }}
    </div>
    @endif

@else
<div class="text-center py-16">
    <i class="fas fa-palette text-gray-300 text-6xl mb-4"></i>
    <h3 class="text-xl font-semibold text-gray-600 mb-2">No moodboards found</h3>
    
    @if(isset($context) && $context === 'management')
        <p class="text-gray-500 mb-4">Create your first moodboard to get started!</p>
        <a href="{{ route('moodboards.create') }}" 
           class="inline-flex items-center gap-2 bg-gradient-to-r from-purple-600 to-pink-600 text-white px-6 py-3 rounded-lg hover:shadow-lg transition-all duration-300 font-semibold">
            <i class="fas fa-plus"></i>
            Create Moodboard
        </a>
    @else
        <p class="text-gray-500 mb-4">Check back later for new moodboards.</p>
    @endif
</div>
@endif

@endsection