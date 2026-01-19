<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Temuan - Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800" x-data="{ 
    reviewModalOpen: false,
    selectedItem: null,
    actionUrl: '',

    openReview(item) {
        this.selectedItem = item;
        // URL untuk update status item
        this.actionUrl = '{{ url('admin/item-status') }}/' + item.id; 
        this.reviewModalOpen = true;
    }
}">

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
                    <p class="px-2 text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">Menu Utama</p>
                    
                    <a href="{{ route('admin.dashboard') }}" 
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-medium transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-cyan-50 text-cyan-600' : 'text-gray-600 hover:bg-cyan-50 hover:text-cyan-600' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.dashboard') ? 'text-cyan-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6z"/></svg>
                        Dashboard
                    </a>

                    <a href="{{ route('admin.kelola.barang') }}" 
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-medium transition-colors {{ request()->routeIs('admin.kelola.barang') ? 'bg-cyan-50 text-cyan-600' : 'text-gray-600 hover:bg-cyan-50 hover:text-cyan-600' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.kelola.barang') ? 'text-cyan-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        Kelola Barang
                    </a>

                    <a href="{{ route('admin.laporan.temuan') }}" 
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-medium transition-colors {{ request()->routeIs('admin.laporan.temuan') ? 'bg-cyan-50 text-cyan-600' : 'text-gray-600 hover:bg-cyan-50 hover:text-cyan-600' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.laporan.temuan') ? 'text-cyan-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Laporan Temuan
                    </a>

                    <a href="{{ route('admin.verifikasi.klaim') }}" 
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-medium transition-colors {{ request()->routeIs('admin.verifikasi.klaim') ? 'bg-cyan-50 text-cyan-600' : 'text-gray-600 hover:bg-cyan-50 hover:text-cyan-600' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.verifikasi.klaim') ? 'text-cyan-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                        Verifikasi Klaim
                    </a>
                </nav>
            </div>

            <div class="p-4 border-t border-gray-100">
                <a href="{{ route('logout') }}" class="flex items-center gap-3 px-4 py-2 text-gray-600 hover:text-red-600 transition-colors text-sm font-medium">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Keluar
                </a>
            </div>
        </aside>

        <main class="flex-1 flex flex-col h-screen overflow-hidden bg-gray-50">
            
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-8">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Laporan Temuan Barang</h2>
                    <p class="text-xs text-gray-500">Kelola dan verifikasi laporan temuan barang dari pengguna</p>
                </div>
                <a href="{{ route('admin.profile') }}" class="flex items-center gap-4 hover:bg-gray-50 p-2 rounded-lg transition-colors cursor-pointer group">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-semibold text-gray-700 group-hover:text-cyan-600 transition-colors">{{ Auth::user()->name }}</p>
                    </div>
                    <div class="h-8 w-8 rounded-full bg-cyan-100 flex items-center justify-center text-cyan-600 font-bold border border-cyan-200 shadow-sm overflow-hidden group-hover:border-cyan-400 transition-colors">
                        @if(Auth::user()->profile_photo)
                            <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" class="w-full h-full object-cover">
                        @else
                            {{ substr(Auth::user()->name, 0, 1) }}
                        @endif
                    </div>
                </a>
            </header>

            <div class="flex-1 overflow-y-auto p-8">
                
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm flex items-start justify-between">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Total Laporan</p>
                            <h3 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                {{ $stats['total'] }}
                            </h3>
                        </div>
                    </div>

                    <div class="bg-yellow-50 p-5 rounded-xl border border-yellow-100 shadow-sm flex items-start justify-between">
                        <div>
                            <p class="text-sm text-yellow-700 mb-1">Menunggu Review</p>
                            <h3 class="text-2xl font-bold text-yellow-800 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                {{ $stats['pending'] }}
                            </h3>
                        </div>
                    </div>

                    <div class="bg-green-50 p-5 rounded-xl border border-green-100 shadow-sm flex items-start justify-between">
                        <div>
                            <p class="text-sm text-green-700 mb-1">Disetujui</p>
                            <h3 class="text-2xl font-bold text-green-800 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                {{ $stats['approved'] }}
                            </h3>
                        </div>
                    </div>

                    <div class="bg-red-50 p-5 rounded-xl border border-red-100 shadow-sm flex items-start justify-between">
                        <div>
                            <p class="text-sm text-red-700 mb-1">Ditolak</p>
                            <h3 class="text-2xl font-bold text-red-800 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                {{ $stats['rejected'] }}
                            </h3>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm mb-6 flex flex-col md:flex-row gap-4 justify-between items-center">
                    
                    <form action="{{ route('admin.laporan.temuan') }}" method="GET" class="relative w-full md:w-1/2">
                        @if(request('status'))
                            <input type="hidden" name="status" value="{{ request('status') }}">
                        @endif
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari laporan, nama pelapor, atau ID..." class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500 bg-gray-50">
                        <svg class="w-4 h-4 text-gray-400 absolute left-3 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </form>

                    <div class="flex gap-2">
                        @php
                            $currentStatus = request('status', 'semua');
                            $btnBase = "px-4 py-2 rounded-lg text-sm font-medium border transition-colors";
                            $btnActive = "bg-blue-700 text-white border-blue-700";
                            $btnInactive = "bg-white text-gray-600 border-gray-300 hover:bg-gray-50";
                        @endphp

                        <a href="{{ route('admin.laporan.temuan', ['status' => 'semua', 'search' => request('search')]) }}" 
                           class="{{ $btnBase }} {{ $currentStatus == 'semua' ? $btnActive : $btnInactive }}">
                           Semua
                        </a>
                        
                        <a href="{{ route('admin.laporan.temuan', ['status' => 'pending', 'search' => request('search')]) }}" 
                           class="{{ $btnBase }} {{ $currentStatus == 'pending' ? $btnActive : $btnInactive }} flex items-center gap-1">
                           <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                           Pending
                        </a>

                        <a href="{{ route('admin.laporan.temuan', ['status' => 'disetujui', 'search' => request('search')]) }}" 
                           class="{{ $btnBase }} {{ $currentStatus == 'disetujui' ? $btnActive : $btnInactive }} flex items-center gap-1">
                           <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                           Disetujui
                        </a>

                        <a href="{{ route('admin.laporan.temuan', ['status' => 'ditolak', 'search' => request('search')]) }}" 
                           class="{{ $btnBase }} {{ $currentStatus == 'ditolak' ? $btnActive : $btnInactive }} flex items-center gap-1">
                           <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                           Ditolak
                        </a>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 text-gray-500 uppercase font-medium border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4">ID</th>
                                <th class="px-6 py-4">Barang</th>
                                <th class="px-6 py-4">Pelapor</th>
                                <th class="px-6 py-4">Lokasi</th>
                                <th class="px-6 py-4">Tanggal Lapor</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($laporan as $item)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 font-medium text-gray-600">RPT{{ str_pad($item->id, 3, '0', STR_PAD_LEFT) }}</td>
                                
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg bg-gray-100 border border-gray-200 overflow-hidden flex-shrink-0">
                                            <img src="{{ $item->image ? asset('storage/'.$item->image) : 'https://via.placeholder.com/150?text=No+Img' }}" class="w-full h-full object-cover">
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-800">{{ $item->title }}</p>
                                            <p class="text-xs text-gray-500">{{ $item->category }}</p>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <div>
                                        <p class="font-semibold text-gray-800">{{ $item->user->name ?? 'Anonim' }}</p>
                                        <p class="text-xs text-gray-500">{{ $item->user->no_unik ?? '-' }}</p>
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-gray-600">
                                    {{ $item->location }}
                                </td>

                                <td class="px-6 py-4 text-gray-600">
                                    {{ \Carbon\Carbon::parse($item->date_event)->translatedFormat('d M Y') }}
                                </td>

                                <td class="px-6 py-4">
                                    @if($item->status == 'pending')
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700 border border-yellow-200">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            Menunggu Review
                                        </span>
                                    @elseif($item->status == 'available')
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                            Disetujui
                                        </span>
                                    @elseif($item->status == 'rejected')
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700 border border-red-200">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                            Ditolak
                                        </span>
                                    @else
                                        <span class="px-3 py-1 rounded-full text-xs bg-gray-100 text-gray-600">{{ ucfirst($item->status) }}</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-center relative" x-data="{ open: false }">
                                    <button @click="open = !open" @click.away="open = false" class="text-gray-400 hover:text-gray-600 p-1 rounded-full hover:bg-gray-100">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"/></svg>
                                    </button>
                                    
                                    <div x-show="open" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-100 z-50 text-left py-1" x-cloak>
                                        @if($item->status == 'pending')
                                            <button @click="open = false; openReview({{ $item }})" class="w-full text-left px-4 py-2 text-sm text-blue-600 hover:bg-blue-50 flex items-center gap-2 font-medium">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                Review Laporan
                                            </button>
                                        @endif

                                        <button @click="open = false; openReview({{ $item }})" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center gap-2">
                                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            Lihat Detail
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="7" class="text-center py-12 text-gray-500">Tidak ada laporan ditemukan.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $laporan->withQueryString()->links() }}
                    </div>
                </div>

            </div>
        </main>
    </div>

    <div x-show="reviewModalOpen" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
        <div class="fixed inset-0 bg-gray-900 bg-opacity-60 transition-opacity" @click="reviewModalOpen = false"></div>
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-xl shadow-xl w-full max-w-2xl z-50 overflow-hidden transform transition-all">
                <div class="flex flex-col md:flex-row">
                    <div class="w-full md:w-1/2 bg-gray-200 h-64 md:h-auto relative">
                        <img :src="selectedItem?.image ? '/storage/' + selectedItem.image : 'https://via.placeholder.com/400?text=No+Img'" class="w-full h-full object-cover">
                        <div class="absolute top-2 left-2">
                             <span class="bg-white/90 backdrop-blur text-gray-800 px-2 py-1 rounded text-xs font-bold" x-text="selectedItem?.category"></span>
                        </div>
                    </div>

                    <div class="w-full md:w-1/2 p-6 flex flex-col justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2" x-text="selectedItem?.title"></h3>
                            
                            <div class="space-y-3 text-sm text-gray-600 mb-6">
                                <div class="flex gap-2">
                                    <svg class="w-4 h-4 mt-0.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    <div>
                                        <p class="font-semibold text-gray-800" x-text="selectedItem?.user?.name || 'Anonim'"></p>
                                        <p class="text-xs">Pelapor</p>
                                    </div>
                                </div>
                                <div class="flex gap-2">
                                    <svg class="w-4 h-4 mt-0.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    <span x-text="selectedItem?.location"></span>
                                </div>
                                <div class="flex gap-2">
                                    <svg class="w-4 h-4 mt-0.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <span x-text="selectedItem?.date_event ? selectedItem.date_event.split('T')[0] : ''"></span>
                                </div>
                                <div class="p-3 bg-gray-50 rounded-lg border border-gray-100 italic">
                                    "<span x-text="selectedItem?.description || 'Tidak ada deskripsi'"></span>"
                                </div>
                            </div>
                        </div>

                        <div x-show="selectedItem?.status == 'pending'">
                            <p class="text-xs font-semibold text-gray-500 mb-2 uppercase tracking-wide">Tentukan Status:</p>
                            <form :action="actionUrl" method="POST" class="grid grid-cols-2 gap-3">
                                @csrf 
                                @method('PUT')
                                <button name="status" value="available" class="py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow-sm transition-colors flex items-center justify-center gap-2 text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    Setujui
                                </button>
                                <button name="status" value="rejected" class="py-2 bg-red-50 hover:bg-red-100 text-red-600 font-semibold rounded-lg border border-red-200 transition-colors flex items-center justify-center gap-2 text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    Tolak
                                </button>
                            </form>
                        </div>
                        
                        <div x-show="selectedItem?.status != 'pending'" class="text-center">
                            <span class="inline-block px-4 py-2 bg-gray-100 rounded-full text-sm font-semibold text-gray-500">
                                Laporan ini sudah <span x-text="selectedItem?.status == 'available' ? 'Disetujui' : 'Ditolak'"></span>
                            </span>
                        </div>

                        <button @click="reviewModalOpen = false" class="mt-4 w-full py-2 text-gray-500 hover:text-gray-800 text-sm font-medium">
                            Tutup / Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>