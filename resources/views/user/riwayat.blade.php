<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Aktivitas - Lost & Found UP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800" x-data="{ 
    activeTab: 'semua', 
    detailOpen: false, 
    selectedItem: {} 
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
                                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-600">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                </div>
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
                            @php
                                $profilePhoto = Auth::user()->profile_photo;
                                $profileUrl = 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=0D8ABC&color=fff';
                                if ($profilePhoto) {
                                    if (\Illuminate\Support\Str::startsWith($profilePhoto, 'http')) {
                                        $profileUrl = $profilePhoto;
                                    } elseif (file_exists(public_path('storage/' . $profilePhoto))) {
                                        $profileUrl = asset('storage/' . $profilePhoto);
                                    } else {
                                        $profileUrl = asset($profilePhoto);
                                    }
                                }
                            @endphp
                            <img src="{{ $profileUrl }}" class="h-full w-full object-cover">
                        </div>
                    </a>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-8">
                
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Klaim & Riwayat Saya</h2>

                <div class="flex gap-3 mb-6 overflow-x-auto pb-2 border-b border-gray-200">
                    <button @click="activeTab = 'semua'" :class="activeTab === 'semua' ? 'text-cyan-500 border-b-2 border-cyan-500 font-semibold' : 'text-gray-500 hover:text-gray-700'" class="px-4 py-2 text-sm whitespace-nowrap pb-3 transition-colors">Semua</button>
                    <button @click="activeTab = 'laporan'" :class="activeTab === 'laporan' ? 'text-cyan-500 border-b-2 border-cyan-500 font-semibold' : 'text-gray-500 hover:text-gray-700'" class="px-4 py-2 text-sm whitespace-nowrap pb-3 transition-colors">Laporan Penemuan</button>
                    <button @click="activeTab = 'klaim'" :class="activeTab === 'klaim' ? 'text-cyan-500 border-b-2 border-cyan-500 font-semibold' : 'text-gray-500 hover:text-gray-700'" class="px-4 py-2 text-sm whitespace-nowrap pb-3 transition-colors">Klaim Barang</button>
                </div>

                @if(session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded text-sm">{{ session('success') }}</div>
                @endif
                @if($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded text-sm">{{ $errors->first() }}</div>
                @endif

                <div class="space-y-4">
                    @forelse($items as $item)
                
                    @php
                        $jenis = $item->jenis_riwayat ?? 'laporan';
                        
                        // Menangani jika data berupa stdClass (hasil join) atau Model
                        // Jika 'klaim' dan ada relasi 'item' (Model Eloquent)
                        if ($jenis == 'klaim' && isset($item->item)) {
                            $dataRef = $item->item;
                        } 
                        // Jika data flat (stdClass) atau laporan
                        else {
                            $dataRef = $item;
                        }

                        // Ambil atribut dengan fallback aman
                        $displayTitle = $dataRef->title ?? '-';
                        $displayCategory = $dataRef->category ?? '-';
                        $displayLocation = $dataRef->location ?? '-';
                        $displayDate = $dataRef->date_event ?? '-';
                        $displayDesc = $dataRef->description ?? '-';
                        
                        // Logika Gambar Pintar
                        $rawImage = $dataRef->image ?? null;
                        $finalImage = 'https://via.placeholder.com/400x300?text=No+Image';

                        if ($rawImage) {
                            if (\Illuminate\Support\Str::startsWith($rawImage, 'http')) {
                                $finalImage = $rawImage;
                            } elseif (file_exists(public_path('storage/' . $rawImage))) {
                                $finalImage = asset('storage/' . $rawImage);
                            } else {
                                $finalImage = asset($rawImage);
                            }
                        }
                    @endphp

                    <div x-show="activeTab === 'semua' || activeTab === '{{ $jenis }}'" 
                         class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden hover:shadow-md transition-all">
                        
                        <div class="p-5 flex flex-col md:flex-row gap-6 items-start">
                            <div class="w-full md:w-32 h-32 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0 border border-gray-100 relative group cursor-pointer"
                                 @click="detailOpen = true; 
                                         selectedItem = {
                                            title: '{{ addslashes($displayTitle) }}',
                                            category: '{{ $displayCategory }}',
                                            location: '{{ $displayLocation }}',
                                            date: '{{ $displayDate }}',
                                            description: '{{ addslashes($displayDesc) }}',
                                            image: '{{ $finalImage }}',
                                            status: '{{ $item->status }}'
                                         }">
                                <img src="{{ $finalImage }}" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </div>
                            </div>

                            <div class="flex-1 w-full flex flex-col justify-between h-full min-h-[8rem]">
                                <div>
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center gap-2">
                                            @if($jenis == 'klaim')
                                                <span class="bg-purple-100 text-purple-700 text-[10px] font-bold px-2 py-0.5 rounded border border-purple-200">KLAIM BARANG</span>
                                            @else
                                                <span class="bg-blue-100 text-blue-700 text-[10px] font-bold px-2 py-0.5 rounded border border-blue-200">LAPORAN SAYA</span>
                                            @endif
                                            
                                            <span class="text-[10px] text-gray-400 font-medium">
                                                {{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}
                                            </span>
                                        </div>
                                        
                                        @if($item->status == 'pending')
                                            <span class="bg-yellow-50 text-yellow-700 text-xs px-2.5 py-1 rounded-full border border-yellow-200 font-medium flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> Menunggu
                                            </span>
                                        @elseif($item->status == 'available' || $item->status == 'verified')
                                            <span class="bg-green-50 text-green-700 text-xs px-2.5 py-1 rounded-full border border-green-200 font-medium flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Disetujui
                                            </span>
                                        @elseif($item->status == 'rejected')
                                            <span class="bg-red-50 text-red-700 text-xs px-2.5 py-1 rounded-full border border-red-200 font-medium flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg> Ditolak
                                            </span>
                                        @endif
                                    </div>

                                    <h3 class="text-lg font-bold text-gray-800 mb-1">
                                        {{ $displayTitle }}
                                    </h3>
                                    <p class="text-sm text-gray-500 line-clamp-1">
                                        {{ $displayDesc }}
                                    </p>
                                </div>

                                <div class="mt-4 flex justify-end items-center gap-3 border-t border-gray-50 pt-3">
                                    <button @click="detailOpen = true; 
                                            selectedItem = {
                                                title: '{{ addslashes($displayTitle) }}',
                                                category: '{{ $displayCategory }}',
                                                location: '{{ $displayLocation }}',
                                                date: '{{ $displayDate }}',
                                                description: '{{ addslashes($displayDesc) }}',
                                                image: '{{ $finalImage }}',
                                                status: '{{ $item->status }}'
                                            }"
                                            class="text-sm font-medium text-cyan-600 hover:text-cyan-700">
                                        Lihat Detail
                                    </button>

                                    @if($item->status == 'pending')
                                        @if($jenis == 'laporan')
                                            <form action="{{ route('user.lapor.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan laporan ini?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-sm font-medium text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition-colors">
                                                    Batalkan
                                                </button>
                                            </form>
                                        @elseif($jenis == 'klaim')
                                            <form action="{{ route('user.claim.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan klaim ini?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-sm font-medium text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition-colors">
                                                    Batalkan
                                                </button>
                                            </form>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-16 bg-white rounded-xl border border-gray-200">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <p class="text-gray-500">Belum ada riwayat aktivitas.</p>
                    </div>
                    @endforelse
                </div>
            </main>
        </div>
    </div>

    <div x-show="detailOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            
            <div x-show="detailOpen" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-900 bg-opacity-60 transition-opacity backdrop-blur-sm" 
                 @click="detailOpen = false"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="detailOpen" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl w-full">
                
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <h3 class="text-lg font-bold text-gray-800" id="modal-title">Detail Riwayat</h3>
                    <button @click="detailOpen = false" class="text-gray-400 hover:text-gray-600 transition-colors p-1 rounded-full hover:bg-gray-100 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <div class="px-6 py-6">
                    <div class="flex flex-col md:flex-row gap-8">
                        <div class="w-full md:w-1/2 flex-shrink-0">
                            <div class="aspect-w-4 aspect-h-3 bg-gray-100 rounded-xl overflow-hidden border border-gray-200 shadow-sm relative group">
                                <img :src="selectedItem.image" class="w-full h-full object-cover">
                            </div>
                            
                            <div class="mt-4 flex justify-center">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border shadow-sm"
                                    :class="{
                                        'bg-green-50 text-green-700 border-green-200': ['available', 'verified'].includes(selectedItem.status),
                                        'bg-yellow-50 text-yellow-700 border-yellow-200': selectedItem.status === 'pending',
                                        'bg-red-50 text-red-700 border-red-200': selectedItem.status === 'rejected'
                                    }">
                                    <span class="w-2 h-2 rounded-full mr-2" 
                                          :class="{
                                              'bg-green-500': ['available', 'verified'].includes(selectedItem.status),
                                              'bg-yellow-500': selectedItem.status === 'pending',
                                              'bg-red-500': selectedItem.status === 'rejected'
                                          }"></span>
                                    <span x-text="{
                                        'available': 'Disetujui',
                                        'verified': 'Disetujui',
                                        'pending': 'Menunggu Verifikasi',
                                        'rejected': 'Ditolak'
                                    }[selectedItem.status] || selectedItem.status"></span>
                                </span>
                            </div>
                        </div>

                        <div class="w-full md:w-1/2 flex flex-col justify-between">
                            <div class="space-y-5">
                                <div>
                                    <h3 class="text-2xl font-bold text-gray-900 leading-tight" x-text="selectedItem.title"></h3>
                                    <p class="text-sm text-gray-500 mt-1 flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        <span x-text="selectedItem.location"></span>
                                    </p>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                                        <p class="text-xs text-gray-500 uppercase font-semibold mb-1">Kategori</p>
                                        <p class="text-sm font-medium text-gray-900" x-text="selectedItem.category"></p>
                                    </div>
                                    <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                                        <p class="text-xs text-gray-500 uppercase font-semibold mb-1">Tanggal</p>
                                        <p class="text-sm font-medium text-gray-900" x-text="selectedItem.date"></p>
                                    </div>
                                </div>

                                <div>
                                    <p class="text-xs text-gray-500 uppercase font-semibold mb-2">Deskripsi</p>
                                    <div class="text-sm text-gray-700 leading-relaxed bg-white border border-gray-100 p-3 rounded-lg shadow-sm">
                                        <p x-text="selectedItem.description || 'Tidak ada deskripsi tersedia.'"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-end gap-3">
                    <button type="button" 
                        class="px-5 py-2.5 bg-white text-gray-700 font-medium rounded-lg border border-gray-300 shadow-sm hover:bg-gray-50 transition-colors" 
                        @click="detailOpen = false">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

</body>
</html>