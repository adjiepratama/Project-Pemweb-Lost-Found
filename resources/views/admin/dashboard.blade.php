<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Lost & Found UP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800" x-data="{ 
    // --- LOGIC MODAL BARANG (Review Laporan - TETAP AKTIF) ---
    reviewModalOpen: false,
    selectedItem: null,
    actionUrl: '',

    openReviewModal(item) {
        this.selectedItem = item;
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
                    
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 bg-cyan-50 text-cyan-600 rounded-lg font-medium transition-colors">
                        <svg class="w-5 h-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                        Dashboard
                    </a>
                    <a href="{{ route('admin.kelola.barang') }}" class="flex items-center gap-3 px-3 py-2.5 text-gray-600 hover:bg-cyan-50 hover:text-cyan-600 rounded-lg font-medium transition-colors">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        Kelola Barang
                    </a>
                    <a href="{{ route('admin.laporan.temuan') }}" class="flex items-center gap-3 px-3 py-2.5 text-gray-600 hover:bg-cyan-50 hover:text-cyan-600 rounded-lg font-medium transition-colors">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Laporan Temuan
                    </a>
                    <a href="{{ route('admin.verifikasi.klaim') }}" class="flex items-center gap-3 px-3 py-2.5 text-gray-600 hover:bg-cyan-50 hover:text-cyan-600 rounded-lg font-medium transition-colors">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
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
                    <h2 class="text-xl font-bold text-gray-800">Dashboard</h2>
                    <p class="text-xs text-gray-500">Ringkasan aktivitas sistem Lost and Found</p>
                </div>
                
                <a href="{{ route('admin.profile') }}" class="flex items-center gap-4 hover:bg-gray-50 p-2 rounded-lg transition-colors cursor-pointer group">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-semibold text-gray-700 group-hover:text-cyan-600 transition-colors">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500">Administrator</p>
                    </div>
                    <div class="h-10 w-10 rounded-full bg-cyan-100 flex items-center justify-center text-cyan-600 font-bold border border-cyan-200 shadow-sm overflow-hidden group-hover:border-cyan-400 transition-colors">
                        @if(Auth::user()->profile_photo)
                            <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" class="w-full h-full object-cover">
                        @else
                            {{ substr(Auth::user()->name, 0, 1) }}
                        @endif
                    </div>
                </a>
                
            </header>

            <div class="flex-1 overflow-y-auto p-8 space-y-8">
                
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm relative overflow-hidden group hover:border-cyan-300 transition-all duration-200">
                        <div class="absolute right-0 top-0 h-full w-1 bg-cyan-400"></div>
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Total Barang</p>
                                <h3 class="text-3xl font-bold text-gray-800 mt-2">{{ $stats['total_items'] }}</h3>
                                <p class="text-[10px] text-gray-400 mt-1"><span class="text-green-500 font-bold">+{{ $stats['items_this_month'] }}</span> bulan ini</p>
                            </div>
                            <div class="p-2 bg-cyan-50 rounded-lg text-cyan-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg></div>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm relative overflow-hidden group hover:border-blue-300 transition-all duration-200">
                        <div class="absolute right-0 top-0 h-full w-1 bg-blue-400"></div>
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Laporan Masuk</p>
                                <h3 class="text-3xl font-bold text-gray-800 mt-2">{{ $stats['laporan_masuk'] }}</h3>
                                <p class="text-[10px] text-gray-400 mt-1"><span class="{{ $stats['laporan_today'] > 0 ? 'text-blue-600 font-bold' : '' }}">{{ $stats['laporan_today'] }} baru</span> hari ini</p>
                            </div>
                            <div class="p-2 bg-blue-50 rounded-lg text-blue-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg></div>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm relative overflow-hidden group hover:border-orange-300 transition-all duration-200">
                        <div class="absolute right-0 top-0 h-full w-1 bg-orange-400"></div>
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Menunggu Verifikasi</p>
                                <h3 class="text-3xl font-bold text-gray-800 mt-2">{{ $stats['menunggu_verifikasi'] }}</h3>
                                <p class="text-[10px] text-gray-400 mt-1"><span class="{{ $stats['claims_today'] > 0 ? 'text-orange-600 font-bold' : '' }}">{{ $stats['claims_today'] }} klaim</span> hari ini</p>
                            </div>
                            <div class="p-2 bg-orange-50 rounded-lg text-orange-500"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg></div>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm relative overflow-hidden group hover:border-green-300 transition-all duration-200">
                        <div class="absolute right-0 top-0 h-full w-1 bg-green-400"></div>
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Barang Selesai</p>
                                <h3 class="text-3xl font-bold text-gray-800 mt-2">{{ $stats['barang_dikembalikan'] }}</h3>
                                <p class="text-[10px] text-gray-400 mt-1"><span class="text-green-500 font-bold">+{{ $stats['returned_this_month'] }}</span> bulan ini</p>
                            </div>
                            <div class="p-2 bg-green-50 rounded-lg text-green-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg></div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    
                    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 h-full">
                        <div class="flex justify-between items-center mb-6">
                            <div>
                                <h3 class="font-bold text-lg text-gray-900">Laporan Temuan Terbaru</h3>
                                <p class="text-xs text-gray-500">Laporan dari pengguna yang perlu direview</p>
                            </div>
                            <a href="{{ route('admin.laporan.temuan') }}" class="text-xs font-semibold text-gray-900 flex items-center hover:underline">
                                Lihat Semua <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </a>
                        </div>
                        <div class="space-y-4">
                            @foreach($recentReports as $item)
                            <div class="flex items-center justify-between p-4 border border-gray-50 rounded-xl bg-gray-50/50">
                                <div class="flex items-center gap-4">
                                    <div class="p-3 bg-blue-100 text-blue-600 rounded-lg">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-800 text-sm">{{ $item->title }}</h4>
                                        <p class="text-xs text-gray-500">{{ $item->user->name ?? 'Anonim' }} • {{ $item->location }}</p>
                                    </div>
                                </div>
                                <div class="text-right flex flex-col items-end gap-2">
                                    <span class="bg-yellow-100 text-yellow-800 text-[10px] font-bold px-2 py-0.5 rounded">Menunggu</span>
                                    
                                    <button @click="openReviewModal({{ $item }})" class="bg-white border border-gray-300 text-gray-700 hover:border-gray-400 text-xs font-bold px-4 py-1.5 rounded-lg shadow-sm">
                                        Review
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 h-full">
                        <div class="flex justify-between items-center mb-6">
                            <div>
                                <h3 class="font-bold text-lg text-gray-900">Klaim Terbaru</h3>
                                <p class="text-xs text-gray-500">Klaim yang membutuhkan verifikasi</p>
                            </div>
                            <a href="{{ route('admin.verifikasi.klaim') }}" class="text-xs font-semibold text-gray-900 flex items-center hover:underline">
                                Lihat Semua <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </a>
                        </div>
                        <div class="space-y-4">
                            @foreach($recentClaims as $claim)
                            <div class="flex items-center justify-between p-4 border border-gray-50 rounded-xl bg-gray-50/50">
                                <div class="flex items-center gap-4">
                                    <div class="p-3 bg-red-100 text-red-600 rounded-lg">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-800 text-sm">{{ $claim->item->title ?? 'Barang Dihapus' }}</h4>
                                        <p class="text-xs text-gray-500">{{ $claim->user->name ?? 'User Dihapus' }} • {{ $claim->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <div class="text-right flex flex-col items-end gap-2">
                                    <span class="bg-yellow-100 text-yellow-800 text-[10px] font-bold px-2 py-0.5 rounded">Menunggu</span>
                                    
                                    <a href="{{ route('admin.verifikasi.klaim') }}" class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 hover:border-gray-400 text-xs font-bold px-4 py-1.5 rounded-lg shadow-sm transition-colors text-center inline-block">
                                        Proses
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="font-bold text-lg text-gray-900">Barang Temuan Terbaru</h3>
                            <p class="text-xs text-gray-500">Barang yang baru ditambahkan ke sistem</p>
                        </div>
                        <a href="{{ route('admin.kelola.barang') }}" class="text-xs font-semibold text-gray-900 flex items-center hover:underline">
                            Lihat Semua 
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        @foreach($newItems as $item)
                        <div class="flex items-center gap-4 p-4 border border-gray-100 rounded-xl bg-white hover:bg-gray-50 transition">
                            <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center text-cyan-500 flex-shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                            </div>
                            <div class="min-w-0">
                                <h4 class="font-bold text-sm text-gray-900 truncate">{{ $item->title }}</h4>
                                <p class="text-[10px] text-gray-500 truncate">{{ $item->location }}</p>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-[10px] bg-green-100 text-green-700 px-1.5 py-0.5 rounded">Tersedia</span>
                                    <span class="text-[10px] text-gray-400">{{ $item->created_at->diffForHumans(null, true) }} lalu</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </main>
    </div>

    <div x-show="reviewModalOpen" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
        <div class="fixed inset-0 bg-gray-900 bg-opacity-60 transition-opacity" @click="reviewModalOpen = false"></div>
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-xl shadow-xl w-full max-w-sm z-50 overflow-hidden transform transition-all">
                <div class="p-6 text-center">
                    <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center mx-auto mb-4 text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-1">Review Laporan</h3>
                    <p class="text-sm text-gray-500 mb-6">Tentukan status untuk laporan: <br> <span class="font-semibold text-gray-800" x-text="selectedItem?.title"></span></p>
                    
                    <form :action="actionUrl" method="POST" class="grid grid-cols-1 gap-3">
                        @csrf 
                        @method('PUT')
                        <button name="status" value="available" class="w-full py-2.5 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow-sm transition-colors flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Setujui Laporan
                        </button>
                        <button name="status" value="rejected" class="w-full py-2.5 bg-red-50 hover:bg-red-100 text-red-600 font-semibold rounded-lg border border-red-200 transition-colors flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            Tolak Laporan
                        </button>
                        <button type="button" @click="reviewModalOpen = false" class="w-full py-2.5 text-gray-500 font-medium hover:text-gray-700 transition-colors">
                            Batal / Tidak Jadi
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>
</html>