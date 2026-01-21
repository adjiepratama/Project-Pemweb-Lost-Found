<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Lost & Found UP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; } [x-cloak] { display: none !important; } </style>
</head>
<body class="bg-gray-50 text-gray-800" x-data="{ 
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
                       <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
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
                    
                    </div>
                    <div class="h-10 w-10 rounded-full bg-cyan-100 flex items-center justify-center text-cyan-600 font-bold border border-cyan-200 shadow-sm overflow-hidden group-hover:border-cyan-400 transition-colors">
                        @if(Auth::user()->profile_photo)
                            {{-- LOGIKA GAMBAR PROFIL --}}
                            <img src="{{ \Illuminate\Support\Str::startsWith(Auth::user()->profile_photo, 'http') ? Auth::user()->profile_photo : asset('storage/' . Auth::user()->profile_photo) }}" 
                                 class="w-full h-full object-cover rounded-full" 
                                 alt="{{ Auth::user()->name }}">
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
                    
                    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                        <div class="flex justify-between items-center mb-6">
                            <div>
                                <h3 class="font-bold text-lg text-gray-900">Laporan Temuan Terbaru</h3>
                                <p class="text-xs text-gray-500">Laporan dari pengguna yang perlu direview</p>
                            </div>
                            <a href="{{ route('admin.laporan.temuan') }}" class="text-sm font-bold text-cyan-600 hover:text-cyan-700 flex items-center gap-1">
                                Lihat Semua <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </a>
                        </div>

                        <div class="space-y-4">
                            @forelse($recentReports as $item)
                            <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition-colors border border-transparent hover:border-gray-100">
                                <div class="flex items-center gap-4">
                                    <div class="h-12 w-12 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0 border border-gray-200">
                                        {{-- LOGIKA GAMBAR UNIVERSAL (Aman untuk Storage & Public) --}}
                                        @php
                                            $imagePath = $item->image;
                                            if (!\Illuminate\Support\Str::startsWith($imagePath, 'http')) {
                                                // Jika tidak ada 'items/' dan tidak ada 'proofs/', asumsikan path lengkap
                                                // Coba cek apakah file ada di storage
                                                if (\Illuminate\Support\Facades\Storage::disk('public')->exists($imagePath)) {
                                                    $imageUrl = asset('storage/' . $imagePath);
                                                } else {
                                                    // Jika tidak ada di storage, mungkin path langsung (seperti dari move() user controller)
                                                    $imageUrl = asset($imagePath);
                                                }
                                            } else {
                                                $imageUrl = $imagePath;
                                            }
                                        @endphp
                                        <img src="{{ $imageUrl ?? 'https://via.placeholder.com/150?text=No+Img' }}" 
                                             class="w-full h-full object-cover">
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-800 text-sm">{{ $item->title }}</p>
                                        <p class="text-xs text-gray-500">{{ $item->user->name ?? 'Anonim' }} • {{ $item->location }}</p>
                                    </div>
                                </div>
                                <div class="flex flex-col items-end gap-2">
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-700 text-[10px] font-bold rounded">Menunggu</span>
                                    <button @click="openReviewModal({{ $item }})" class="bg-white border border-gray-300 text-gray-700 hover:border-gray-400 text-xs font-bold px-4 py-1.5 rounded-lg shadow-sm">
                                        Review
                                    </button>
                                </div>
                            </div>
                            @empty
                            <p class="text-center text-sm text-gray-400 py-4">Tidak ada laporan baru.</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                        <div class="flex justify-between items-center mb-6">
                            <div>
                                <h3 class="font-bold text-gray-800 text-lg">Klaim Terbaru</h3>
                                <p class="text-xs text-gray-500">Klaim yang membutuhkan verifikasi</p>
                            </div>
                            <a href="{{ route('admin.verifikasi.klaim') }}" class="text-sm font-bold text-cyan-600 hover:text-cyan-700 flex items-center gap-1">
                                Lihat Semua <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </a>
                        </div>

                        <div class="space-y-4">
                            @forelse($recentClaims as $claim)
                            <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition-colors border border-transparent hover:border-gray-100">
                                <div class="flex items-center gap-4">
                                    <div class="h-12 w-12 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0 border border-gray-200">
                                        {{-- LOGIKA GAMBAR UNIVERSAL --}}
                                        @php
                                            $imagePath = $claim->item->image;
                                            if (!\Illuminate\Support\Str::startsWith($imagePath, 'http')) {
                                                if (\Illuminate\Support\Facades\Storage::disk('public')->exists($imagePath)) {
                                                    $imageUrl = asset('storage/' . $imagePath);
                                                } else {
                                                    $imageUrl = asset($imagePath);
                                                }
                                            } else {
                                                $imageUrl = $imagePath;
                                            }
                                        @endphp
                                        <img src="{{ $imageUrl ?? 'https://via.placeholder.com/150?text=No+Img' }}" 
                                             class="w-full h-full object-cover">
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-800 text-sm">Klaim: {{ $claim->item->title ?? 'Barang Dihapus' }}</p>
                                        <p class="text-xs text-gray-500">Oleh: {{ $claim->user->name ?? 'User Dihapus' }}</p>
                                    </div>
                                </div>
                                <div class="flex flex-col items-end gap-2">
                                    <span class="px-2 py-1 bg-blue-100 text-blue-700 text-[10px] font-bold rounded">Verifikasi</span>
                                    <a href="{{ route('admin.verifikasi.klaim') }}" class="text-xs text-gray-500 hover:text-gray-800 border px-2 py-1 rounded">Detail</a>
                                </div>
                            </div>
                            @empty
                            <p class="text-center text-sm text-gray-400 py-4">Tidak ada klaim baru.</p>
                            @endforelse
                        </div>
                    </div>

                </div>

                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="font-bold text-gray-800 text-lg">Barang Temuan Terbaru</h3>
                            <p class="text-xs text-gray-500">Barang yang baru ditambahkan ke sistem</p>
                        </div>
                        <a href="{{ route('admin.kelola.barang') }}" class="text-sm font-bold text-cyan-600 hover:text-cyan-700 flex items-center gap-1">
                            Lihat Semua <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        @forelse($newItems as $item)
                        <div class="flex items-center gap-3 p-3 border border-gray-100 rounded-lg hover:shadow-sm transition-shadow">
                            <div class="h-12 w-12 bg-cyan-50 rounded-lg flex-shrink-0 overflow-hidden border border-gray-200">
                                {{-- LOGIKA GAMBAR UNIVERSAL --}}
                                @php
                                    $imagePath = $item->image;
                                    if (!\Illuminate\Support\Str::startsWith($imagePath, 'http')) {
                                        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($imagePath)) {
                                            $imageUrl = asset('storage/' . $imagePath);
                                        } else {
                                            $imageUrl = asset($imagePath);
                                        }
                                    } else {
                                        $imageUrl = $imagePath;
                                    }
                                @endphp
                                <img src="{{ $imageUrl ?? 'https://via.placeholder.com/150?text=No+Img' }}" 
                                     class="w-full h-full object-cover">
                            </div>
                            <div class="min-w-0">
                                <p class="font-bold text-gray-800 text-sm truncate">{{ $item->title }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ $item->location }}</p>
                                
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="px-1.5 py-0.5 rounded text-[10px] font-bold 
                                        {{ $item->status == 'available' ? 'bg-green-100 text-green-600' : 
                                          ($item->status == 'donated' ? 'bg-purple-100 text-purple-600' : 'bg-gray-100 text-gray-500') }}">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                    <span class="text-[10px] text-gray-400">{{ $item->created_at->diffForHumans(null, true) }} lalu</span>
                                </div>
                            </div>
                        </div>
                        @empty
                        <p class="col-span-full text-center text-sm text-gray-400">Belum ada barang.</p>
                        @endforelse
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
