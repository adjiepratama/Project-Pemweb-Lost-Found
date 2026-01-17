<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klaim & Riwayat Saya - Lost & Found UP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
    <style> body { font-family: 'Inter', sans-serif; } [x-cloak] { display: none !important; } </style>
</head>
<body class="bg-gray-50 text-gray-800" x-data="{ activeTab: 'semua', detailOpen: false, selectedItem: {} }">

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
                    <a href="{{ route('user.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        Dashboard
                    </a>
                    <a href="{{ route('user.lapor') }}" class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Lapor Barang
                    </a>
                    <a href="{{ route('user.history') }}" class="flex items-center gap-3 px-4 py-3 text-cyan-600 bg-cyan-50 rounded-lg font-medium transition-colors">
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
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Klaim & Riwayat Saya</h2>

                <div class="flex gap-3 mb-6 overflow-x-auto pb-2 border-b border-gray-200">
                    <button @click="activeTab = 'semua'" :class="activeTab === 'semua' ? 'text-cyan-500 border-b-2 border-cyan-500 font-semibold' : 'text-gray-500 hover:text-gray-700'" class="px-4 py-2 text-sm whitespace-nowrap pb-3">Semua</button>
                    <button @click="activeTab = 'pending'" :class="activeTab === 'pending' ? 'text-cyan-500 border-b-2 border-cyan-500 font-semibold' : 'text-gray-500 hover:text-gray-700'" class="px-4 py-2 text-sm whitespace-nowrap pb-3">Tertunda</button>
                    <button @click="activeTab = 'available'" :class="activeTab === 'available' ? 'text-cyan-500 border-b-2 border-cyan-500 font-semibold' : 'text-gray-500 hover:text-gray-700'" class="px-4 py-2 text-sm whitespace-nowrap pb-3">Disetujui</button>
                    <button @click="activeTab = 'rejected'" :class="activeTab === 'rejected' ? 'text-cyan-500 border-b-2 border-cyan-500 font-semibold' : 'text-gray-500 hover:text-gray-700'" class="px-4 py-2 text-sm whitespace-nowrap pb-3">Ditolak</button>
                </div>

                @if(session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded text-sm">{{ session('success') }}</div>
                @endif
                @if($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded text-sm">{{ $errors->first() }}</div>
                @endif

                <div class="space-y-4">
                    @forelse($items as $item)
                    <div x-show="activeTab === 'semua' || activeTab === '{{ $item->status }}'" class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden hover:shadow-md transition-all">
                        <div class="p-6 flex flex-col md:flex-row gap-6 items-start md:items-center">
                            <div class="w-full md:w-28 h-28 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0 border border-gray-100 relative">
                                <img src="{{ $item->image ? (Str::startsWith($item->image, 'http') ? $item->image : asset($item->image)) : 'https://via.placeholder.com/150?text=No+Img' }}" class="w-full h-full object-cover">
                            </div>

                            <div class="flex-1 w-full">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <div class="flex items-center gap-2 mb-1">
                                            @if(isset($item->jenis_riwayat) && $item->jenis_riwayat == 'klaim')
                                                <span class="bg-purple-100 text-purple-700 text-[10px] font-bold px-2 py-0.5 rounded border border-purple-200">KLAIM SAYA</span>
                                            @else
                                                <span class="bg-blue-100 text-blue-700 text-[10px] font-bold px-2 py-0.5 rounded border border-blue-200">LAPORAN SAYA</span>
                                            @endif
                                            <h3 class="text-base font-bold text-gray-800">{{ $item->title }}</h3>
                                        </div>
                                        <div class="flex items-center gap-2 mb-2">
                                            @if($item->status == 'pending')
                                                <span class="bg-yellow-50 text-yellow-700 text-xs px-2 py-0.5 rounded-full border border-yellow-200 font-medium">Menunggu Verifikasi</span>
                                            @elseif($item->status == 'available' || $item->status == 'verified')
                                                <span class="bg-green-50 text-green-700 text-xs px-2 py-0.5 rounded-full border border-green-200 font-medium">Disetujui</span>
                                            @elseif($item->status == 'rejected')
                                                <span class="bg-red-50 text-red-700 text-xs px-2 py-0.5 rounded-full border border-red-200 font-medium">Ditolak</span>
                                            @endif
                                        </div>
                                        <p class="text-xs text-gray-400">
                                            {{ isset($item->jenis_riwayat) && $item->jenis_riwayat == 'klaim' ? 'Diajukan' : 'Dilaporkan' }} 
                                            {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d M Y, H:i') }} WIB
                                        </p>
                                    </div>

                                    <button 
                                    @click="
                                        detailOpen = true; 
                                        selectedItem = {
                                            title: '{{ addslashes($item->title) }}',
                                            category: '{{ $item->category }}',
                                            location: '{{ $item->location }}',
                                            date: '{{ $item->date_event }}',
                                            description: '{{ addslashes($item->description) }}',
                                            image: '{{ $item->image ? (Str::startsWith($item->image, 'http') ? $item->image : asset($item->image)) : 'https://via.placeholder.com/150' }}',
                                            status: '{{ $item->status }}'
                                        }
                                    " 
                                    class="text-gray-400 hover:text-cyan-600 transition-colors p-2"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                                </div>

                                <div class="mt-4 pt-3 border-t border-gray-100 flex justify-end">
                                    @if($item->status == 'pending')
                                        @if(isset($item->jenis_riwayat) && $item->jenis_riwayat == 'laporan')
                                            <form action="{{ route('user.lapor.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Batalkan laporan ini? Anda bisa menginput ulang nanti.');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="flex items-center gap-1.5 px-3 py-1.5 bg-red-50 text-red-600 text-xs font-semibold rounded-lg hover:bg-red-100 transition-colors border border-red-200">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                                    Batalkan Laporan
                                                </button>
                                            </form>
                                        @elseif(isset($item->jenis_riwayat) && $item->jenis_riwayat == 'klaim')
                                            <form action="{{ route('user.claim.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Batalkan pengajuan klaim ini? Anda bisa mengklaim ulang nanti.');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="flex items-center gap-1.5 px-3 py-1.5 bg-red-50 text-red-600 text-xs font-semibold rounded-lg hover:bg-red-100 transition-colors border border-red-200">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                                    Batalkan Klaim
                                                </button>
                                            </form>
                                        @endif
                                    @else
                                        <span class="text-xs text-gray-400 italic">Sudah diproses, tidak dapat dibatalkan.</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-12">
                        <p class="text-gray-500">Belum ada riwayat laporan atau klaim.</p>
                    </div>
                    @endforelse
                </div>
            </main>
        </div>
    </div>

    <div x-show="detailOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="detailOpen" x-transition.opacity class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="detailOpen = false"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            
            <div x-show="detailOpen" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl w-full relative">
                
                <button @click="detailOpen = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>

                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start gap-6">
                        <div class="w-full sm:w-1/2 flex-shrink-0">
                            <div class="aspect-w-4 aspect-h-3 bg-gray-100 rounded-lg overflow-hidden border border-gray-200">
                                <img :src="selectedItem.image" class="w-full h-full object-cover">
                            </div>
                        </div>

                        <div class="mt-4 sm:mt-0 sm:w-1/2">
                            <h3 class="text-lg leading-6 font-bold text-gray-900 pr-6" x-text="selectedItem.title"></h3>
                            
                            <div class="mt-2 mb-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                      :class="selectedItem.status == 'available' ? 'bg-green-100 text-green-800' : (selectedItem.status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800')"
                                      x-text="selectedItem.status == 'available' ? 'Disetujui' : (selectedItem.status == 'pending' ? 'Menunggu Verifikasi' : 'Ditolak')">
                                </span>
                            </div>

                            <div class="space-y-3 text-sm">
                                <div>
                                    <span class="block text-gray-500 text-xs uppercase tracking-wide">Kategori</span>
                                    <span class="font-medium text-gray-800" x-text="selectedItem.category"></span>
                                </div>
                                <div>
                                    <span class="block text-gray-500 text-xs uppercase tracking-wide">Lokasi & Tanggal</span>
                                    <span class="font-medium text-gray-800" x-text="selectedItem.location + ' • ' + selectedItem.date"></span>
                                </div>
                                <div>
                                    <span class="block text-gray-500 text-xs uppercase tracking-wide">Deskripsi</span>
                                    <p class="text-gray-600 mt-1 bg-gray-50 p-2 rounded border border-gray-100" x-text="selectedItem.description"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" class="w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:ml-3 sm:w-auto sm:text-sm" @click="detailOpen = false">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

</body>
</html>