<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Klaim - Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800" x-data="{ 
    // State Modal
    verifyModalOpen: false,
    rejectModalOpen: false,
    detailModalOpen: false,
    
    // Data Seleksi
    selectedClaim: null,
    actionUrl: '',
    adminNote: '',

    // Helper untuk membuka modal
    openVerify(claim) {
        this.selectedClaim = claim;
        this.actionUrl = '{{ url('admin/klaim') }}/' + claim.id;
        this.adminNote = '';
        this.verifyModalOpen = true;
    },

    openReject(claim) {
        this.selectedClaim = claim;
        this.actionUrl = '{{ url('admin/klaim') }}/' + claim.id;
        this.adminNote = '';
        this.rejectModalOpen = true;
    },

    openDetail(claim) {
        this.selectedClaim = claim;
        this.detailModalOpen = true;
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
                    
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-medium transition-colors text-gray-600 hover:bg-cyan-50 hover:text-cyan-600">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6z"/></svg>
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
                    <a href="{{ route('admin.verifikasi.klaim') }}" class="flex items-center gap-3 px-3 py-2.5 bg-cyan-50 text-cyan-600 rounded-lg font-medium transition-colors">
                        <svg class="w-5 h-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                        Verifikasi Klaim
                    </a>
                </nav>
            </div>
            <div class="p-4 border-t border-gray-100">
                <a href="{{ route('logout') }}" class="flex items-center gap-3 px-4 py-2 text-gray-600 hover:text-red-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Keluar
                </a>
            </div>
        </aside>

        <main class="flex-1 flex flex-col h-screen overflow-hidden bg-gray-50">
            
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-8">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Verifikasi Klaim</h2>
                    <p class="text-xs text-gray-500">Proses dan verifikasi klaim kepemilikan barang</p>
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
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-orange-50 p-5 rounded-xl border border-orange-100 shadow-sm flex items-start gap-4">
                        <div class="w-12 h-12 rounded-full bg-orange-100 flex items-center justify-center text-orange-600 flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800">{{ $stats['pending'] }}</h3>
                            <p class="text-sm text-gray-600">Menunggu Diproses</p>
                        </div>
                    </div>

                    <div class="bg-blue-50 p-5 rounded-xl border border-blue-100 shadow-sm flex items-start gap-4">
                        <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800">{{ $stats['verification'] }}</h3>
                            <p class="text-sm text-gray-600">Dalam Verifikasi</p>
                        </div>
                    </div>

                    <div class="bg-green-50 p-5 rounded-xl border border-green-100 shadow-sm flex items-start gap-4">
                        <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center text-green-600 flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800">{{ $stats['approved_month'] }}</h3>
                            <p class="text-sm text-gray-600">Disetujui Bulan Ini</p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('admin.verifikasi.klaim') }}" method="GET" class="flex flex-col md:flex-row gap-4 mb-6 items-center">
                    <div class="relative flex-1 w-full">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari berdasarkan nama, NIM, atau ID klaim..." class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500 bg-white">
                        <svg class="w-4 h-4 text-gray-400 absolute left-3 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>

                    <select name="status" onchange="this.form.submit()" class="px-4 py-2.5 border border-gray-200 rounded-lg text-sm bg-white focus:ring-2 focus:ring-cyan-500 outline-none text-gray-600 min-w-[150px]">
                        <option value="semua">Semua Status</option>
                        <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                        <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </form>

                <div class="space-y-4">
                    @forelse($claims as $claim)
                    <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm hover:shadow-md transition-shadow flex flex-col md:flex-row items-start gap-6">
                        
                        <div class="w-16 h-16 bg-gray-100 rounded-xl flex items-center justify-center flex-shrink-0 overflow-hidden border border-gray-200">
                            <img src="{{ $claim->item->image ? asset('storage/'.$claim->item->image) : 'https://via.placeholder.com/150?text=No+Img' }}" class="w-full h-full object-cover">
                        </div>

                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-3 mb-1">
                                <span class="text-xs font-mono text-gray-400">CLM-{{ str_pad($claim->id, 3, '0', STR_PAD_LEFT) }}</span>
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-red-100 text-red-600 border border-red-200">Prioritas Tinggi</span>
                                
                                @if($claim->status == 'pending')
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-yellow-100 text-yellow-600 border border-yellow-200">Menunggu</span>
                                @elseif($claim->status == 'verified')
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-green-100 text-green-600 border border-green-200">Disetujui</span>
                                @elseif($claim->status == 'rejected')
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-red-100 text-red-600 border border-red-200">Ditolak</span>
                                @endif
                            </div>
                            
                            <h3 class="text-lg font-bold text-gray-900 truncate">{{ $claim->item->title }}</h3>
                            <p class="text-sm text-gray-500 truncate mb-2">{{ $claim->item->description }}</p>
                            
                            <div class="flex flex-wrap items-center gap-4 text-xs text-gray-500">
                                <span class="flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg> {{ $claim->item->location }}</span>
                                <span class="flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg> Ditemukan: {{ $claim->item->date_event ? \Carbon\Carbon::parse($claim->item->date_event)->format('d M Y') : '-' }}</span>
                            </div>
                        </div>

                        <div class="flex-1 border-l border-gray-100 pl-6 hidden md:block">
                            <p class="text-xs text-gray-400 mb-2 font-semibold uppercase tracking-wide">Pengklaim:</p>
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 font-bold text-xs">
                                    {{ substr($claim->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-800">{{ $claim->user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $claim->user->no_unik }} • {{ $claim->user->email }}</p>
                                    
                                    <div class="flex gap-4 mt-2 text-xs text-gray-500">
                                        <span class="flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg> {{ $claim->claimer_phone ?? '-' }}</span>
                                        <span class="flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> {{ $claim->created_at->format('d M Y, H:i') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col gap-2 min-w-[120px]">
                            <button @click="openDetail({{ $claim }})" class="w-full py-2 bg-white border border-gray-300 text-gray-700 text-xs font-bold rounded-lg hover:bg-gray-50 flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                Detail
                            </button>

                            @if($claim->status == 'pending')
                                <button @click="openVerify({{ $claim }})" class="w-full py-2 bg-blue-700 text-white text-xs font-bold rounded-lg hover:bg-blue-800 flex items-center justify-center gap-2 shadow-sm">
                                    Verifikasi
                                </button>
                                <button @click="openReject({{ $claim }})" class="w-full py-2 bg-red-50 text-red-600 border border-red-200 text-xs font-bold rounded-lg hover:bg-red-100 flex items-center justify-center gap-2">
                                    Tolak
                                </button>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-12 text-gray-500 bg-white rounded-xl border border-gray-200">
                        <p>Tidak ada data klaim ditemukan.</p>
                    </div>
                    @endforelse
                </div>

                <div class="mt-6">
                    {{ $claims->withQueryString()->links() }}
                </div>
            </div>
        </main>
    </div>

    <div x-show="verifyModalOpen" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
        <div class="fixed inset-0 bg-gray-900 bg-opacity-60 transition-opacity" @click="verifyModalOpen = false"></div>
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-2xl shadow-xl w-full max-w-md z-50 overflow-hidden transform transition-all">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-xl font-bold text-gray-900">Setujui Klaim</h3>
                        <button @click="verifyModalOpen = false" class="text-gray-400 hover:text-gray-600">&times;</button>
                    </div>
                    
                    <p class="text-gray-500 text-sm mb-4">Konfirmasi persetujuan klaim kepemilikan barang ini</p>

                    <div class="bg-gray-50 p-3 rounded-xl border border-gray-100 flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center border border-gray-200 overflow-hidden">
                             <img :src="selectedClaim?.item?.image ? '/storage/' + selectedClaim.item.image : 'https://via.placeholder.com/150'" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <p class="font-bold text-sm text-gray-800" x-text="selectedClaim?.item?.title"></p>
                            <p class="text-xs text-gray-500">Diklaim oleh: <span x-text="selectedClaim?.user?.name"></span></p>
                        </div>
                    </div>

                    <form :action="actionUrl" method="POST">
                        @csrf @method('PUT')
                        <input type="hidden" name="status" value="verified">

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Catatan (Opsional)</label>
                            <textarea name="note" rows="3" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 text-sm p-3" placeholder="Tambahkan catatan untuk arsip..."></textarea>
                        </div>

                        <div class="bg-green-50 border border-green-100 rounded-lg p-3 mb-6 text-xs text-green-800 space-y-1">
                            <p class="font-bold mb-1">Langkah Selanjutnya:</p>
                            <ul class="list-disc pl-4 space-y-0.5">
                                <li>Hubungi pengklaim untuk pengambilan barang</li>
                                <li>Siapkan formulir serah terima</li>
                                <li>Minta tanda tangan saat penyerahan</li>
                            </ul>
                        </div>

                        <div class="flex gap-3">
                            <button type="button" @click="verifyModalOpen = false" class="flex-1 py-2.5 bg-white border border-gray-300 text-gray-700 font-bold rounded-lg hover:bg-gray-50">Batal</button>
                            <button type="submit" class="flex-1 py-2.5 bg-green-500 text-white font-bold rounded-lg hover:bg-green-600 shadow-sm flex items-center justify-center gap-2">
                                Konfirmasi Persetujuan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div x-show="rejectModalOpen" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
        <div class="fixed inset-0 bg-gray-900 bg-opacity-60 transition-opacity" @click="rejectModalOpen = false"></div>
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-2xl shadow-xl w-full max-w-md z-50 overflow-hidden transform transition-all">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-xl font-bold text-gray-900">Tolak Klaim</h3>
                        <button @click="rejectModalOpen = false" class="text-gray-400 hover:text-gray-600">&times;</button>
                    </div>
                    
                    <p class="text-gray-500 text-sm mb-4">Berikan alasan penolakan klaim ini</p>

                    <div class="bg-gray-50 p-3 rounded-xl border border-gray-100 flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center border border-gray-200 overflow-hidden">
                             <img :src="selectedClaim?.item?.image ? '/storage/' + selectedClaim.item.image : 'https://via.placeholder.com/150'" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <p class="font-bold text-sm text-gray-800" x-text="selectedClaim?.item?.title"></p>
                            <p class="text-xs text-gray-500">Diklaim oleh: <span x-text="selectedClaim?.user?.name"></span></p>
                        </div>
                    </div>

                    <form :action="actionUrl" method="POST">
                        @csrf @method('PUT')
                        <input type="hidden" name="status" value="rejected">

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Alasan Penolakan <span class="text-red-500">*</span></label>
                            <textarea name="note" rows="3" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500 text-sm p-3" placeholder="Jelaskan alasan penolakan klaim ini..." required></textarea>
                        </div>

                        <div class="flex gap-3">
                            <button type="button" @click="rejectModalOpen = false" class="flex-1 py-2.5 bg-white border border-gray-300 text-gray-700 font-bold rounded-lg hover:bg-gray-50">Batal</button>
                            <button type="submit" class="flex-1 py-2.5 bg-red-500 text-white font-bold rounded-lg hover:bg-red-600 shadow-sm flex items-center justify-center gap-2">
                                Konfirmasi Penolakan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div x-show="detailModalOpen" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
        <div class="fixed inset-0 bg-gray-900 bg-opacity-60 transition-opacity" @click="detailModalOpen = false"></div>
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl z-50 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-800">Detail Klaim & Bukti</h3>
                    <button @click="detailModalOpen = false" class="text-gray-400 hover:text-gray-600">&times;</button>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="font-bold text-gray-900 mb-2">Barang yang Diklaim</h4>
                            <div class="aspect-video bg-gray-100 rounded-lg overflow-hidden mb-3">
                                <img :src="selectedClaim?.item?.image ? '/storage/' + selectedClaim.item.image : 'https://via.placeholder.com/400?text=No+Img'" class="w-full h-full object-cover">
                            </div>
                            <p class="font-bold text-gray-800" x-text="selectedClaim?.item?.title"></p>
                            <p class="text-sm text-gray-600" x-text="selectedClaim?.item?.description"></p>
                        </div>

                        <div>
                            <h4 class="font-bold text-gray-900 mb-2">Bukti Kepemilikan</h4>
                            
                            <div class="aspect-video bg-gray-100 rounded-lg overflow-hidden mb-3 relative border border-gray-200">
                                <template x-if="selectedClaim?.claim_proof">
                                    <img :src="'/storage/' + selectedClaim.claim_proof" class="w-full h-full object-cover">
                                </template>
                                <template x-if="!selectedClaim?.claim_proof">
                                    <div class="flex items-center justify-center h-full text-gray-400 text-xs">Tidak ada foto bukti</div>
                                </template>
                            </div>

                            <div class="space-y-3">
                                <div>
                                    <p class="text-xs text-gray-400 font-bold uppercase">Deskripsi Ciri-ciri</p>
                                    <p class="text-sm text-gray-700 bg-gray-50 p-2 rounded border border-gray-100" x-text="selectedClaim?.claim_description || '-'"></p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 font-bold uppercase">Data Pengklaim</p>
                                    <p class="text-sm text-gray-800 font-semibold" x-text="selectedClaim?.user?.name"></p>
                                    <p class="text-xs text-gray-500" x-text="selectedClaim?.user?.no_unik"></p>
                                    <p class="text-xs text-gray-500" x-text="selectedClaim?.user?.phone"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end">
                    <button @click="detailModalOpen = false" class="px-4 py-2 bg-white border border-gray-300 text-gray-700 font-bold rounded-lg hover:bg-gray-100">Tutup</button>
                </div>
            </div>
        </div>
    </div>

</body>
</html>