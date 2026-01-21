<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Barang - Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
        /* Custom scrollbar for textareas */
        textarea::-webkit-scrollbar { width: 8px; }
        textarea::-webkit-scrollbar-track { background: #f1f1f1; }
        textarea::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 4px; }
        textarea::-webkit-scrollbar-thumb:hover { background: #9ca3af; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800" x-data="{ 
    modalOpen: false, 
    detailModalOpen: false,
    isEdit: false,
    editUrl: '',
    formTitle: '', formCategory: 'Elektronik', formLocation: '', formDate: '', formDesc: '', formStatus: 'available',
    
    // Data untuk Detail
    detailItem: null,
    detailImage: '', 

    openAddModal() {
        this.isEdit = false;
        this.formTitle = ''; 
        this.formLocation = ''; 
        this.formDate = ''; 
        this.formDesc = '';
        this.modalOpen = true;
    },
    
    openEditModal(item, updateUrl) {
        this.isEdit = true;
        this.editUrl = updateUrl;
        this.formTitle = item.title;
        this.formCategory = item.category;
        this.formLocation = item.location;
        this.formDate = item.date_event ? item.date_event.split('T')[0] : ''; 
        this.formDesc = item.description;
        this.formStatus = item.status;
        this.modalOpen = true;
    },

    openDetail(item, imageUrl) {
        this.detailItem = item;
        this.detailImage = imageUrl; 
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
                       <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        Dashboard
                    </a>

                    <a href="{{ route('admin.kelola.barang') }}" class="flex items-center gap-3 px-3 py-2.5 bg-cyan-50 text-cyan-600 rounded-lg font-medium transition-colors">
                        <svg class="w-5 h-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
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
                    <h2 class="text-xl font-bold text-gray-800">Kelola Barang Temuan</h2>
                    <p class="text-xs text-gray-500">Tambah, edit, dan kelola data barang temuan</p>
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
                
              <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 mb-6 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-yellow-100 text-yellow-600 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900">{{ $donationReadyCount > 0 ? $donationReadyCount : '0' }} barang siap untuk didonasikan</h4>
                        <p class="text-sm text-gray-600">Barang yang tidak diklaim selama 180 hari otomatis menjadi status donasi.</p>
                    </div>
                </div>
                
                
                <a href="{{ route('admin.kelola.barang', ['status' => 'donated']) }}" class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 transition shadow-sm inline-flex items-center">
                    Lihat Barang
                </a>
            </div>

                <form action="{{ route('admin.kelola.barang') }}" method="GET" class="flex flex-col md:flex-row gap-3 mb-6 items-center">
                    
                    <div class="relative flex-1 w-full">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari berdasarkan nama, ID, atau deskripsi..." class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500 bg-white">
                        <svg class="w-4 h-4 text-gray-400 absolute left-3 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>

                    <button type="button" class="p-2.5 border border-gray-200 bg-white rounded-lg text-gray-500 hover:bg-gray-50">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                    </button>
                    
                    <select name="category" onchange="this.form.submit()" class="px-4 py-2.5 border border-gray-200 rounded-lg text-sm bg-white focus:ring-2 focus:ring-cyan-500 outline-none text-gray-600 min-w-[150px]">
                        <option value="Semua">Semua Kategori</option>
                        <option value="Elektronik" {{ request('category') == 'Elektronik' ? 'selected' : '' }}>Elektronik</option>
                        <option value="Kunci" {{ request('category') == 'Kunci' ? 'selected' : '' }}>Kunci</option>
                        <option value="Pakaian" {{ request('category') == 'Pakaian' ? 'selected' : '' }}>Pakaian</option>
                        <option value="Aksesoris" {{ request('category') == 'Aksesoris' ? 'selected' : '' }}>Aksesoris</option>
                    </select>

                    <select name="status" onchange="this.form.submit()" class="px-4 py-2.5 border border-gray-200 rounded-lg text-sm bg-white focus:ring-2 focus:ring-cyan-500 outline-none text-gray-600 min-w-[150px]">
                        <option value="Semua">Semua Status</option>
                        <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Tersedia</option>
                        <option value="claimed" {{ request('status') == 'claimed' ? 'selected' : '' }}>Diklaim</option>
                        <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }}>Dikembalikan</option>
                        <option value="donated" {{ request('status') == 'donated' ? 'selected' : '' }}>Didonasikan</option>
                    </select>

                    <button type="button" @click="openAddModal()" class="bg-blue-600 text-white px-5 py-2.5 rounded-lg text-sm font-bold hover:bg-blue-700 flex items-center gap-2 transition-colors shadow-sm whitespace-nowrap">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Tambah Barang
                    </button>
                </form>

                <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 text-gray-500 uppercase font-medium border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4">ID</th>
                                <th class="px-6 py-4">Nama Barang</th>
                                <th class="px-6 py-4">Kategori</th>
                                <th class="px-6 py-4">Lokasi</th>
                                <th class="px-6 py-4">Tanggal</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($items as $item)
                            
                            {{-- LOGIKA GAMBAR PINTAR (Di sini kita hitung URL yang benar) --}}
                            @php
                                $imgUrl = 'https://via.placeholder.com/150?text=No+Img';
                                if ($item->image) {
                                    if (\Illuminate\Support\Str::startsWith($item->image, 'http')) {
                                        $imgUrl = $item->image;
                                    } elseif (file_exists(public_path('storage/' . $item->image))) {
                                        $imgUrl = asset('storage/' . $item->image);
                                    } else {
                                        $imgUrl = asset($item->image);
                                    }
                                }
                            @endphp

                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 font-medium text-gray-600">ITM-{{ str_pad($item->id, 3, '0', STR_PAD_LEFT) }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg bg-gray-100 border border-gray-200 overflow-hidden flex-shrink-0">
                                            <img src="{{ $imgUrl }}" 
                                                 class="w-full h-full object-cover"
                                                 alt="{{ $item->title }}">
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-800">{{ $item->title }}</p>
                                            <p class="text-xs text-gray-500 truncate w-40">{{ $item->description }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="bg-white text-gray-700 px-2 py-1 rounded text-xs font-semibold border border-gray-200">{{ $item->category }}</span>
                                </td>
                                <td class="px-6 py-4 text-gray-600">{{ $item->location }}</td>
                                <td class="px-6 py-4 text-gray-600">
                                    {{ \Carbon\Carbon::parse($item->date_event)->translatedFormat('d M Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $colors = [
                                            'available' => 'bg-green-100 text-green-700 border-green-200',
                                            'pending' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                                            'claimed' => 'bg-orange-100 text-orange-700 border-orange-200',
                                            'returned' => 'bg-green-600 text-white border-green-600', 
                                            'donated' => 'bg-purple-100 text-purple-700 border-purple-200',
                                        ];
                                        $label = [
                                            'available' => 'Tersedia',
                                            'pending' => 'Pending',
                                            'claimed' => 'Diklaim',
                                            'returned' => 'Dikembalikan',
                                            'donated' => 'Didonasikan',
                                        ];
                                    @endphp
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold border {{ $colors[$item->status] ?? 'bg-gray-100 text-gray-600' }}">
                                        {{ $label[$item->status] ?? ucfirst($item->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center relative" x-data="{ open: false }">
                                    <button @click="open = !open" @click.away="open = false" class="text-gray-400 hover:text-gray-600 p-1 rounded-full hover:bg-gray-100">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"/></svg>
                                    </button>
                                    
                                    <div x-show="open" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-100 z-50 text-left py-1" x-cloak>
                                        <button @click="open = false; openDetail({{ $item }}, '{{ $imgUrl }}')" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center gap-2">
                                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            Lihat Detail
                                        </button>
                                        <button @click="open = false; openEditModal({{ $item }}, '{{ route('admin.barang.update', $item->id) }}')" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center gap-2">
                                            <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            Edit
                                        </button>
                                        <form action="{{ route('admin.barang.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus barang ini?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="7" class="text-center py-8 text-gray-500">Belum ada data barang.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $items->withQueryString()->links() }}
                    </div>
                </div>

            </div>
        </main>
    </div>

    <div x-show="modalOpen" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
        <div class="fixed inset-0 bg-gray-900 bg-opacity-60 transition-opacity" @click="modalOpen = false"></div>
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg z-50 overflow-hidden transform transition-all scale-100">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                    <h3 class="text-lg font-bold text-gray-800" x-text="isEdit ? 'Edit Data Barang' : 'Tambah Barang Baru'"></h3>
                    <button @click="modalOpen = false" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                
                <form :action="isEdit ? editUrl : '{{ route('admin.barang.store') }}'" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
                    @csrf
                    <template x-if="isEdit"><input type="hidden" name="_method" value="PUT"></template>

                    <div class="relative">
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Barang</label>
                        <div class="relative">
                            <span class="absolute left-3 top-3 text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                            </span>
                            <input type="text" name="title" x-model="formTitle" placeholder="Contoh: Dompet Kulit Hitam" class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Kategori</label>
                            <div class="relative">
                                <span class="absolute left-3 top-3 text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                                </span>
                                <select name="category" x-model="formCategory" class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors appearance-none bg-white">
                                    <option>Elektronik</option><option>Kunci</option><option>Pakaian</option><option>Aksesoris</option><option>Dokumen</option><option>Perabotan</option><option>Lainnya</option>
                                </select>
                                <span class="absolute right-3 top-3 text-gray-400 pointer-events-none">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                </span>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal Ditemukan</label>
                            <div class="relative">
                                <span class="absolute left-3 top-3 text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </span>
                                <input type="date" name="date_found" x-model="formDate" class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" required>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div :class="isEdit ? '' : 'col-span-2'">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Lokasi</label>
                            <div class="relative">
                                <span class="absolute left-3 top-3 text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </span>
                                <select name="location" x-model="formLocation" class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors appearance-none bg-white" required>
                                    <option value="" disabled>Pilih Lokasi</option>
                                    <option value="Gedung Griya">Gedung Griya</option>
                                    <option value="Gedung Modular">Gedung Modular</option>
                                    <option value="Gedung Gor Abc">Gedung Gor Abc</option>
                                    <option value="Selasar">Selasar</option>
                                    <option value="Mushola">Mushola</option>
                                    <option value="Kantin Atas">Kantin Atas</option>
                                    <option value="Kantin Bawah">Kantin Bawah</option>
                                </select>
                                <span class="absolute right-3 top-3 text-gray-400 pointer-events-none">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                </span>
                            </div>
                        </div>

                        <div x-show="isEdit">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Status</label>
                            <div class="relative">
                                <span class="absolute left-3 top-3 text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </span>
                                <select name="status" x-model="formStatus" class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors appearance-none bg-white">
                                    <option value="available">Tersedia</option>
                                    <option value="claimed">Diklaim</option>
                                    <option value="returned">Dikembalikan</option>
                                    <option value="donated">Didonasikan</option>
                                </select>
                                <span class="absolute right-3 top-3 text-gray-400 pointer-events-none">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Deskripsi</label>
                        <textarea name="description" x-model="formDesc" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" placeholder="Ciri-ciri barang secara detail..."></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Upload Gambar</label>
                        <input type="file" name="image" class="block w-full text-sm text-gray-500 
                        file:mr-4 file:py-2.5 file:px-4 
                        file:rounded-lg file:border-0 
                        file:text-sm file:font-semibold 
                        file:bg-blue-50 file:text-blue-700 
                        hover:file:bg-blue-100 transition-colors cursor-pointer border border-gray-200 rounded-lg">
                    </div>

                    <div class="pt-2 flex justify-end gap-3 border-t border-gray-100 mt-4">
                        <button type="button" @click="modalOpen = false" class="px-5 py-2.5 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 font-medium transition-colors">Batal</button>
                        <button type="submit" class="px-5 py-2.5 text-white bg-blue-600 rounded-lg hover:bg-blue-700 font-medium shadow-md transition-colors flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div x-show="detailModalOpen" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
        <div class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity" @click="detailModalOpen = false"></div>
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-xl shadow-xl w-full max-w-2xl z-50 overflow-hidden">
                <div class="flex flex-col md:flex-row">
                    <div class="w-full md:w-1/2 bg-gray-200 h-64 md:h-auto overflow-hidden">
                        {{-- GAMBAR DI MODAL MENGGUNAKAN VARIABEL detailImage DARI ALPINE --}}
                        <img :src="detailImage || 'https://via.placeholder.com/400?text=No+Img'" 
                             class="w-full h-full object-cover">
                    </div>
                    <div class="w-full md:w-1/2 p-6 flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start mb-2">
                                <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs font-bold" x-text="detailItem?.category"></span>
                                <span class="text-xs text-gray-500" x-text="detailItem?.date_event ? detailItem.date_event.split('T')[0] : ''"></span>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-2" x-text="detailItem?.title"></h3>
                            <p class="text-gray-600 text-sm mb-4 leading-relaxed" x-text="detailItem?.description"></p>
                            
                            <div class="space-y-2 text-sm">
                                <div class="flex items-center gap-2 text-gray-700">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    <span x-text="detailItem?.location"></span>
                                </div>
                                <div class="flex items-center gap-2 text-gray-700">
                                    <span class="font-bold">Status:</span>
                                    <span class="uppercase font-semibold" x-text="detailItem?.status"></span>
                                </div>
                            </div>
                        </div>
                        <button @click="detailModalOpen = false" class="mt-6 w-full py-2 bg-gray-100 text-gray-700 font-bold rounded-lg hover:bg-gray-200">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>