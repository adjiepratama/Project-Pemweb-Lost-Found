<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pengguna - Lost & Found UP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
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
                    <a href="/user/dashboard" class="flex items-center gap-3 px-4 py-3 text-cyan-600 bg-cyan-50 rounded-lg font-medium transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        Dashboard
                    </a>
                    
                    <a href="#" class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Laporkan Hilang
                    </a>

                    <a href="#" class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-lg transition-colors">
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

        <div class="flex-1 flex flex-col overflow-hidden">
            
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-8">
                <button class="md:hidden text-gray-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                
                <div></div> 

                <div class="flex items-center gap-4">
                    <button class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    </button>
                    <div class="flex items-center gap-2">
                        <span class="text-sm font-medium text-gray-700 hidden sm:block">{{ Auth::user()->name }}</span>
                        <div class="h-8 w-8 rounded-full bg-gray-200 overflow-hidden border border-gray-300">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0D8ABC&color=fff" alt="Profile" class="h-full w-full object-cover">
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-white p-8">
                
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Dashboard Pengguna</h2>

                <section class="mb-8 border border-gray-100 rounded-xl p-6 shadow-sm bg-white">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Cari Barang</h3>
                    
                    <div class="mb-4">
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </span>
                            <input type="text" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 text-sm" placeholder="Cari nama barang atau deskripsi...">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                        <select class="block w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm text-gray-600 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                            <option>Kategori</option>
                            <option>Elektronik</option>
                            <option>Pakaian</option>
                        </select>
                        <select class="block w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm text-gray-600 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                            <option>Lokasi Penemuan</option>
                            <option>Gedung A</option>
                            <option>Kantin</option>
                        </select>
                        <select class="block w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm text-gray-600 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                            <option>Status</option>
                            <option>Ditemukan</option>
                            <option>Hilang</option>
                        </select>
                        <input type="date" class="block w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm text-gray-600 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                    </div>

                    <div class="flex justify-end gap-3">
                        <button class="px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">Reset Filter</button>
                        <button class="px-4 py-2 text-sm font-medium text-white bg-cyan-400 rounded-lg hover:bg-cyan-500 shadow-sm">Terapkan Filter</button>
                    </div>
                </section>

                <section class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Pencarian Berbasis Gambar</h3>
                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 flex flex-col items-center justify-center bg-gray-50 hover:bg-gray-100 transition-colors cursor-pointer">
                        <svg class="w-10 h-10 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <p class="text-sm text-gray-500 mb-4">Seret gambar ke sini atau klik untuk mengunggah</p>
                        <button class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">Pilih Gambar</button>
                    </div>
                </section>

                <section>
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Barang Temuan Terbaru</h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                        <article class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden hover:shadow-md transition-shadow">
                            <div class="h-40 bg-gray-200 w-full overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1627123424574-181ce5171c98?auto=format&fit=crop&q=80&w=400" alt="Dompet" class="w-full h-full object-cover">
                            </div>
                            <div class="p-4">
                                <h4 class="font-bold text-gray-800 text-sm mb-1 truncate">Dompet Kulit Cokelat</h4>
                                <div class="space-y-1 text-xs text-gray-500">
                                    <p>Kategori: Aksesoris</p>
                                    <p>Lokasi: Perpustakaan Lt. 2</p>
                                    <p>Tanggal: 26 Okt 2023</p>
                                </div>
                                <div class="mt-3">
                                    <span class="px-2 py-1 text-[10px] font-semibold text-green-700 bg-green-100 rounded-full">Dikembalikan</span>
                                </div>
                                <button class="mt-4 w-full py-2 bg-gray-50 text-gray-600 text-xs font-semibold rounded-lg hover:bg-gray-100">Lihat Detail</button>
                            </div>
                        </article>

                        <article class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden hover:shadow-md transition-shadow">
                            <div class="h-40 bg-gray-200 w-full overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1572635196237-14b3f281503f?auto=format&fit=crop&q=80&w=400" alt="Kacamata" class="w-full h-full object-cover">
                            </div>
                            <div class="p-4">
                                <h4 class="font-bold text-gray-800 text-sm mb-1 truncate">Kacamata Hitam</h4>
                                <div class="space-y-1 text-xs text-gray-500">
                                    <p>Kategori: Aksesoris</p>
                                    <p>Lokasi: Kantin Utara</p>
                                    <p>Tanggal: 25 Okt 2023</p>
                                </div>
                                <div class="mt-3">
                                    <span class="px-2 py-1 text-[10px] font-semibold text-yellow-700 bg-yellow-100 rounded-full">Didonasikan</span>
                                </div>
                                <button class="mt-4 w-full py-2 bg-gray-50 text-gray-600 text-xs font-semibold rounded-lg hover:bg-gray-100">Lihat Detail</button>
                            </div>
                        </article>

                        </div>
                </section>

            </main>
            
            <footer class="p-4 bg-white border-t text-center text-xs text-gray-400">
                &copy; 2025 Lost & Found UP. All rights reserved.
            </footer>

        </div>
    </div>
</body>
</html>