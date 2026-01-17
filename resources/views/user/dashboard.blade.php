<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pengguna - Lost & Found UP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        /* Animasi Modal */
        .modal { transition: opacity 0.25s ease; }
        body.modal-active { overflow-x: hidden; overflow-y: hidden !important; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    <div class="flex h-screen overflow-hidden">
       
        <aside class="w-64 bg-white border-r border-gray-200 hidden md:flex flex-col justify-between">
            <div>
                <div class="h-16 flex items-center px-6 border-b border-gray-100">
                    <span class="text-cyan-500 text-xl font-bold flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        Lost & Found UP
                    </span>
                </div>
                <nav class="mt-6 px-4 space-y-1">
    
    <a href="{{ route('user.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-cyan-600 bg-cyan-50 rounded-lg font-medium transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
        Dashboard
    </a>

    <a href="{{ route('user.lapor') }}" class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-lg transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        Lapor Barang
    </a>

    <a href="{{ route('user.history') }}" class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-lg transition-colors">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
    Riwayat
</a>

</nav>
            </div>
            <div class="p-4 border-t border-gray-100">
                <a href="{{ url('logout') }}" class="flex items-center gap-3 px-4 py-2 text-gray-600 hover:text-red-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Keluar
                </a>
            </div>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden relative">
           
        <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-8 z-10 relative">
        <button class="md:hidden text-gray-500">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
        
        <div></div> 

        <div class="flex items-center gap-6">
            
            <div x-data="{ notifOpen: false }" class="relative">
                <button @click="notifOpen = !notifOpen" class="relative p-1 rounded-full text-gray-400 hover:text-gray-600 focus:outline-none transition-colors">
                    @if(Auth::user()->unreadNotifications->count() > 0)
                        <span class="absolute top-1.5 right-1.5 h-2 w-2 rounded-full bg-red-500 ring-2 ring-white animate-pulse"></span>
                    @endif
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                </button>

                <div x-show="notifOpen" 
                    @click.away="notifOpen = false"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-lg border border-gray-100 z-50 overflow-hidden origin-top-right"
                    style="display: none;">

                    <div class="px-4 py-3 border-b border-gray-50 flex justify-between items-center bg-gray-50">
                        <h3 class="text-sm font-semibold text-gray-700">Notifikasi</h3>
                        @if(Auth::user()->unreadNotifications->count() > 0)
                            <a href="{{ route('markAsRead') }}" class="text-xs text-cyan-600 hover:text-cyan-700 font-medium">Tandai dibaca</a>
                        @endif
                    </div>

                    <div class="max-h-80 overflow-y-auto">
                        @forelse(Auth::user()->notifications as $notification)
                            <a href="{{ $notification->data['link'] ?? '#' }}" class="block px-4 py-3 hover:bg-gray-50 transition-colors border-b border-gray-50 relative {{ $notification->read_at ? '' : 'bg-cyan-50/40' }}">
                                <div class="flex gap-3">
                                    <div class="flex-shrink-0 mt-1">
                                        @if(isset($notification->data['type']) && $notification->data['type'] == 'success')
                                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center text-green-600">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                            </div>
                                        @elseif(isset($notification->data['type']) && $notification->data['type'] == 'danger')
                                            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center text-red-600">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                            </div>
                                        @else
                                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-600">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-800 font-medium">{{ $notification->data['title'] }}</p>
                                        <p class="text-xs text-gray-500 mt-0.5 line-clamp-2">{{ $notification->data['message'] }}</p>
                                        <p class="text-[10px] text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                    </div>
                                    
                                    @if(is_null($notification->read_at))
                                        <div class="absolute right-3 top-4 w-2 h-2 bg-cyan-500 rounded-full"></div>
                                    @endif
                                </div>
                            </a>
                        @empty
                            <div class="px-4 py-8 text-center">
                                <p class="text-xs text-gray-400">Belum ada notifikasi.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
            <a href="{{ route('user.profile') }}" class="flex items-center gap-3 border-l pl-6 border-gray-200 group">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-semibold text-gray-700 leading-none group-hover:text-cyan-600 transition-colors">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-400 mt-1">Pengguna</p>
                </div>
                <div class="h-9 w-9 rounded-full bg-gray-200 overflow-hidden border border-gray-300 ring-2 ring-gray-100 group-hover:ring-cyan-200 transition-all">
                    @if(Auth::user()->profile_photo)
                        <img src="{{ asset(Auth::user()->profile_photo) }}" class="h-full w-full object-cover">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0D8ABC&color=fff" class="h-full w-full object-cover">
                    @endif
                </div>
            </a>
        </div>
        </header>

         <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-8">
               
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Dashboard Pengguna</h2>

                @if(session('success'))
                    <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">Berhasil!</strong>
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                        <strong class="font-bold">Gagal!</strong>
                        <ul class="list-disc pl-5 mt-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            
                <form action="{{ route('user.dashboard') }}" method="GET">
                <section class="mb-8 border border-gray-100 rounded-xl p-6 shadow-sm bg-white">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Cari Barang</h3>
                   
                    <div class="mb-4">
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </span>
                            <input type="text" name="search" value="{{ request('search') }}" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 text-sm" placeholder="Cari nama barang atau deskripsi...">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                        <select name="category" class="block w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm text-gray-600 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                            <option>Kategori</option>
                            <option {{ request('category') == 'Elektronik' ? 'selected' : '' }}>Elektronik</option>
                            <option {{ request('category') == 'Pakaian' ? 'selected' : '' }}>Pakaian</option>
                            <option {{ request('category') == 'Aksesoris' ? 'selected' : '' }}>Aksesoris</option>
                            <option {{ request('category') == 'Perabotan' ? 'selected' : '' }}>Perabotan</option>
                            <option {{ request('category') == 'Kunci' ? 'selected' : '' }}>Kunci</option>
                        </select>
                        
                        <select name="location" class="block w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm text-gray-600 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                            <option>Lokasi Penemuan</option>
                            <option {{ request('location') == 'Gedung A' ? 'selected' : '' }}>Gedung A</option>
                            <option {{ request('location') == 'Gedung B' ? 'selected' : '' }}>Gedung B</option>
                            <option {{ request('location') == 'Gedung C' ? 'selected' : '' }}>Gedung C</option>
                            <option {{ request('location') == 'Kantin atas' ? 'selected' : '' }}>Kantin atas</option>
                            <option {{ request('location') == 'Kantin bawah' ? 'selected' : '' }}>Kantin bawah</option>
                            <option {{ request('location') == 'Gor ABC' ? 'selected' : '' }}>Gor ABC</option>
                        </select>
                        
                        <select name="status" class="block w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm text-gray-600 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                            <option>Status</option>
                            <option {{ request('status') == 'Dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                            <option {{ request('status') == 'Ditemukan' ? 'selected' : '' }}>Ditemukan</option>
                            <option {{ request('status') == 'Didonasikan' ? 'selected' : '' }}>Didonasikan</option>
                        </select>
                        
                        <input type="date" name="date" value="{{ request('date') }}" class="block w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm text-gray-600 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                    </div>

                    <div class="flex justify-end gap-3">
                        <a href="{{ route('user.dashboard') }}" class="px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 flex items-center">Reset Filter</a>
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-cyan-400 rounded-lg hover:bg-cyan-500 shadow-sm">Terapkan Filter</button>
                    </div>
                </section>
                </form>

              <form id="imageSearchForm" action="{{ route('user.image.search') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <section class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-700 mb-4">Pencarian Berbasis Gambar</h3>
                        
                        <div onclick="document.getElementById('imageSearchInput').click()" 
                             class="border-2 border-dashed border-gray-300 rounded-xl p-8 flex flex-col items-center justify-center bg-gray-50 hover:bg-gray-100 transition-colors cursor-pointer group">
                            
                            <svg class="w-10 h-10 text-gray-400 mb-3 group-hover:text-cyan-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            
                            <p class="text-sm text-gray-500 mb-4">Seret gambar ke sini atau klik untuk mengunggah</p>
                            
                            <button type="button" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 pointer-events-none">
                                Pilih Gambar
                            </button>

                            <input type="file" id="imageSearchInput" name="image_search" class="hidden" onchange="document.getElementById('imageSearchForm').submit()">
                        </div>
                    </section>
                </form>

                <section>
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Barang Temuan Terbaru</h3>
                   
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                        @forelse($items as $item)
                        <article class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden hover:shadow-md transition-shadow">
                            <div class="h-40 bg-gray-200 w-full overflow-hidden relative">
                                <img src="{{ Str::startsWith($item->image, 'http') ? $item->image : asset($item->image) }}" 
                                alt="{{ $item->title }}" 
                                class="w-full h-full object-cover">
                            </div>
                            <div class="p-4">
                                <h4 class="font-bold text-gray-800 text-sm mb-1 truncate">{{ $item->title }}</h4>
                                <div class="space-y-1 text-xs text-gray-500">
                                    <p>Kategori: {{ $item->category }}</p>
                                    <p>Lokasi: {{ $item->location }}</p>
                                    <p>Tanggal: {{ $item->date_event }}</p>
                                </div>
                                <div class="mt-3">
                                    @if($item->status == 'returned')
                                        <span class="px-2 py-1 text-[10px] font-semibold text-green-700 bg-green-100 rounded-full">Dikembalikan</span>
                                    @elseif($item->status == 'donated')
                                        <span class="px-2 py-1 text-[10px] font-semibold text-purple-700 bg-purple-100 rounded-full">Didonasikan</span>
                                    @else
                                        <span class="px-2 py-1 text-[10px] font-semibold text-cyan-700 bg-cyan-100 rounded-full">Ditemukan</span>
                                    @endif
                                </div>
                                
                                <button onclick="openDetailModal(this)" 
                                data-id="{{ $item->id }}"
                                data-title="{{ $item->title }}"
                                data-category="{{ $item->category }}"
                                data-location="{{ $item->location }}"
                                data-date="{{ $item->date_event }}"
                                data-status="{{ $item->status }}"
                                
                                {{-- PERBAIKAN LOGIKA GAMBAR DI SINI --}}
                                data-image="{{ $item->image ? (Str::startsWith($item->image, 'http') ? $item->image : asset($item->image)) : 'https://via.placeholder.com/400x300?text=No+Image' }}"
                                
                                data-description="{{ $item->description }}"
                                class="mt-4 w-full py-2 bg-gray-50 text-gray-600 text-xs font-semibold rounded-lg hover:bg-gray-100 transition-colors">
                                Lihat Detail
                            </button>
                            </div>
                        </article>
                        @empty
                        <div class="col-span-full text-center py-10 text-gray-500">
                            Tidak ada barang yang ditemukan.
                        </div>
                        @endforelse

                    </div>
                </section>

            </main>
           
            <footer class="p-4 bg-white border-t text-center text-xs text-gray-400">
                &copy; 2025 Lost & Found UP. All rights reserved.
            </footer>

        </div>
    </div>

    <div id="detailModal" class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center z-50">
        <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50" onclick="closeDetailModal()"></div>
        
        <div class="modal-container bg-white w-11/12 md:max-w-4xl mx-auto rounded-xl shadow-lg z-50 overflow-y-auto max-h-[90vh]">
            
            <div class="py-4 px-6 border-b border-gray-200 flex justify-between items-center">
                <h3 class="font-bold text-xl text-gray-800">Detail Item</h3>
                <div class="cursor-pointer z-50" onclick="closeDetailModal()">
                    <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                        <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                    </svg>
                </div>
            </div>

            <div class="p-6">
                <div class="flex flex-col md:flex-row gap-6">
                    <div class="w-full md:w-1/2">
                        <div class="aspect-w-4 aspect-h-3 bg-gray-200 rounded-lg overflow-hidden">
                            <img id="modalImage" src="" alt="Detail Gambar" class="w-full h-64 object-cover rounded-lg">
                        </div>
                        <div class="flex gap-2 mt-4">
                            <div class="w-16 h-16 border-2 border-cyan-400 rounded-lg overflow-hidden p-1">
                                <img id="modalThumb" src="" class="w-full h-full object-cover rounded">
                            </div>
                        </div>
                    </div>

                    <div class="w-full md:w-1/2 space-y-4">
                        <div>
                            <h2 id="modalTitle" class="text-2xl font-bold text-gray-800">Nama Barang</h2>
                            <div class="mt-2" id="modalStatusBadge">
                                </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-gray-500">Kategori</p>
                                <p id="modalCategory" class="font-semibold text-gray-800">Elektronik</p>
                            </div>
                            <div>
                                <p class="text-gray-500">Lokasi Ditemukan</p>
                                <p id="modalLocation" class="font-semibold text-gray-800">Gedung A</p>
                            </div>
                            <div>
                                <p class="text-gray-500">Tanggal</p>
                                <p id="modalDate" class="font-semibold text-gray-800">2023-10-20</p>
                            </div>
                        </div>

                        <div>
                            <p class="text-gray-500 text-sm mb-1">Deskripsi</p>
                            <p id="modalDescription" class="text-gray-700 text-sm leading-relaxed bg-gray-50 p-3 rounded-lg border border-gray-100">
                                Deskripsi barang...
                            </p>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                            <h5 class="font-bold text-sm text-gray-800 mb-1">Catatan</h5>
                            <p class="text-xs text-gray-500">Untuk mengklaim barang ini, anda perlu membuktikan kepemilikan dengan mendeskripsikan ciri-ciri spesifik barang.</p>
                        </div>

                        <div class="pt-4">
                            <button onclick="openClaimModal()" class="w-full bg-cyan-400 hover:bg-cyan-500 text-white font-bold py-3 px-4 rounded-lg shadow-md transition-colors">
                                Ajukan Klaim Kepemilikan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


            <div id="claimModal" class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center z-[60]">
            <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50" onclick="closeClaimModal()"></div>
            
            <div class="modal-container bg-white w-11/12 md:max-w-2xl mx-auto rounded-xl shadow-lg z-[60] overflow-y-auto max-h-[90vh]">
            
            <div class="py-4 px-6 border-b border-gray-200 flex justify-between items-center">
            <h3 class="font-bold text-xl text-gray-800">Ajukan Klaim Kepemilikan</h3>
            <div class="cursor-pointer" onclick="closeClaimModal()">
            <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
            <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
            </svg>
            </div>
            </div>

            <div class="p-6">
            <div class="bg-orange-50 border border-orange-100 rounded-lg p-4 mb-6 flex gap-3">
            <svg class="w-6 h-6 text-orange-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            <div>
            <h4 class="font-bold text-sm text-gray-800">Perhatian!</h4>
            <p class="text-xs text-gray-600 mt-1">Untuk mengklaim barang ini, anda perlu membuktikan kepemilikan dengan mendeskripsikan ciri-ciri spesifik barang. Verifikasi akan dilakukan oleh Admin.</p>
            </div>
            </div>

            <form action="{{ route('claim.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="claimItemId" name="item_id" value="">

            <h4 class="font-bold text-gray-800 mb-4">Data Diri</h4>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
            <label class="block text-gray-700 text-sm font-bold mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
            <input type="text" name="claimer_name" value="{{ Auth::user()->name }}" readonly 
            class="shadow-sm border border-gray-300 text-gray-500 text-sm rounded-lg focus:ring-cyan-500 focus:border-cyan-500 block w-full p-2.5 cursor-not-allowed">
            </div>

            <div>
            <label class="block text-gray-700 text-sm font-bold mb-2">No Unik <span class="text-red-500">*</span></label>
            <input type="text" name="claimer_nim" value="{{ Auth::user()->no_unik }}" readonly 
            class="shadow-sm border border-gray-300 text-gray-500 text-sm rounded-lg focus:ring-cyan-500 focus:border-cyan-500 block w-full p-2.5 cursor-not-allowed">
            </div>

            <div>
            <label class="block text-gray-700 text-sm font-bold mb-2">Email <span class="text-red-500">*</span></label>
            <input type="text" name="claimer_email" value="{{ Auth::user()->email }}" readonly 
            class="shadow-sm border border-gray-300 text-gray-500 text-sm rounded-lg focus:ring-cyan-500 focus:border-cyan-500 block w-full p-2.5 cursor-not-allowed">
            </div>
            </div>
            
            <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Nomor WhatsApp <span class="text-red-500">*</span></label>
            <input type="text" name="claimer_phone" class="shadow-sm border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-cyan-500 focus:border-cyan-500 block w-full p-2.5" placeholder="Contoh: 082122260991" required>
            </div>

            <h4 class="font-bold text-gray-800 mb-4">Bukti Kepemilikan</h4>
            
            <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Deskripsi/Ciri-ciri barang <span class="text-red-500">*</span></label>
            <textarea name="claim_description" rows="3" class="shadow-sm border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-cyan-500 focus:border-cyan-500 block w-full p-2.5" placeholder="Contoh: Barang warna merah, ada stiker di belakang..." required></textarea>
            </div>

            <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Foto Bukti Pendukung <span class="text-red-500">*</span></label>
            <p class="text-xs text-gray-500 mb-2">Unggah foto struk pembelian, atau foto lama anda dengan barang tersebut.</p>
            
            <div class="flex items-center justify-center w-full">
            <label for="claim_proof_input" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors" id="dropzone-area">
            
            <div class="flex flex-col items-center justify-center pt-5 pb-6" id="dropzone-text-container">
            <svg class="w-8 h-8 mb-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
            </svg>
            <p class="text-xs text-gray-500 text-center"><span class="font-semibold">Klik untuk upload</span> gambar bukti</p>
            <p class="text-[10px] text-gray-400 mt-1">JPG, PNG (Max. 2MB)</p>
            </div>

            <div id="file-name-display" class="hidden flex flex-col items-center">
            <svg class="w-8 h-8 mb-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <p class="text-sm text-green-600 font-bold" id="selected-filename">Nama File</p>
            <p class="text-xs text-gray-400">Klik untuk ganti</p>
            </div>

            <input id="claim_proof_input" type="file" name="claim_proof" class="hidden" onchange="previewFileName(this)" />
            </label>
            </div> </div>

            <div class="pt-4 flex justify-end">
            <button type="submit" class="w-full bg-cyan-400 hover:bg-cyan-500 text-white font-bold py-3 px-4 rounded-lg shadow-md transition-colors">
            Ajukan Klaim Kepemilikan
            </button>
            </div>
            </form>
            </div>
            </div>
            </div>


    <script>
        // Fungsi Buka Modal Detail
        function openDetailModal(button) {
            // 1. Ambil data dari tombol yang diklik
            const id = button.getAttribute('data-id');
            const title = button.getAttribute('data-title');
            const category = button.getAttribute('data-category');
            const location = button.getAttribute('data-location');
            const date = button.getAttribute('data-date');
            const status = button.getAttribute('data-status');
            const image = button.getAttribute('data-image');
            const desc = button.getAttribute('data-description');

            // 2. Isi data ke dalam Modal Detail
            document.getElementById('modalTitle').innerText = title;
            document.getElementById('modalCategory').innerText = category;
            document.getElementById('modalLocation').innerText = location;
            document.getElementById('modalDate').innerText = date;
            document.getElementById('modalImage').src = image;
            document.getElementById('modalThumb').src = image;
            document.getElementById('modalDescription').innerText = desc || 'Tidak ada deskripsi.';
            
            // Simpan ID barang ke input hidden di form klaim (untuk persiapan)
            document.getElementById('claimItemId').value = id;

            // 3. Buat Badge Status secara dinamis
            let badgeClass = '';
            let badgeText = '';
            
            if(status === 'returned') {
                badgeClass = 'bg-green-100 text-green-700';
                badgeText = 'Dikembalikan';
            } else if (status === 'donated') {
                badgeClass = 'bg-purple-100 text-purple-700';
                badgeText = 'Didonasikan';
            } else {
                badgeClass = 'bg-cyan-100 text-cyan-700';
                badgeText = 'Ditemukan';
            }

            const badgeHtml = `<span class="px-3 py-1 text-xs font-bold ${badgeClass} rounded-full">${badgeText}</span>`;
            document.getElementById('modalStatusBadge').innerHTML = badgeHtml;

            // 4. Tampilkan Modal
            toggleModal('detailModal');
        }

        // Fungsi Buka Modal Klaim (Dari tombol di dalam Modal Detail)
        function openClaimModal() {
            closeDetailModal(); // Tutup detail dulu
            setTimeout(() => {
                toggleModal('claimModal'); // Baru buka form klaim
            }, 300); // Delay sedikit biar smooth
        }

        // Fungsi Tutup Modal
        function closeDetailModal() {
            toggleModal('detailModal');
        }
        function closeClaimModal() {
            toggleModal('claimModal');
        }

        // Helper Toggle (Show/Hide logic)
        function toggleModal(modalID){
            const modal = document.getElementById(modalID);
            modal.classList.toggle('opacity-0');
            modal.classList.toggle('pointer-events-none');
            document.body.classList.toggle('modal-active');
        }

        // Close modal on Escape key
        document.onkeydown = function(evt) {
            evt = evt || window.event;
            let isEscape = false;
            if ("key" in evt) {
                isEscape = (evt.key === "Escape" || evt.key === "Esc");
            } else {
                isEscape = (evt.keyCode === 27);
            }
            if (isEscape && document.body.classList.contains('modal-active')) {
                // Tutup semua modal
                document.getElementById('detailModal').classList.add('opacity-0', 'pointer-events-none');
                document.getElementById('claimModal').classList.add('opacity-0', 'pointer-events-none');
                document.body.classList.remove('modal-active');
            }
        };

        // FUNGSI BARU: Untuk Mengubah Tampilan Saat File Dipilih
function previewFileName(input) {
    const dropzoneText = document.getElementById('dropzone-text-container');
    const fileNameDisplay = document.getElementById('file-name-display');
    const fileNameText = document.getElementById('selected-filename');
    const dropzoneArea = document.getElementById('dropzone-area');

    if (input.files && input.files[0]) {
        // Ambil nama file
        const file = input.files[0];
        
        // Sembunyikan teks default "Klik untuk upload"
        dropzoneText.classList.add('hidden');
        
        // Munculkan teks nama file
        fileNameDisplay.classList.remove('hidden');
        fileNameText.textContent = file.name;

        // Ubah warna border biar kelihatan sukses (Opsional)
        dropzoneArea.classList.remove('border-gray-300');
        dropzoneArea.classList.add('border-green-400', 'bg-green-50');
    }
}
    </script>
</body>
</html>