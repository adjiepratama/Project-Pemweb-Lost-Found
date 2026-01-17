<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporkan Barang Hilang - Lost & Found UP</title>
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
                    <a href="{{ route('user.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        Dashboard
                    </a>
                    
                    <a href="#" class="flex items-center gap-3 px-4 py-3 text-cyan-600 bg-cyan-50 rounded-lg font-medium transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Lapor barang
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

            <main class="flex-1 overflow-x-hidden overflow-y-auto  bg-gray-50  p-8">
                
                <div class="max-w-4xl mx-auto">
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">Lapor barang</h2>
                    <p class="text-gray-500 mb-8 text-sm">Isi formulir di bawah ini untuk melaporkan barang Anda yang hilang. Pastikan semua detail sudah benar.</p>

                    @if($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                            <strong class="font-bold">Mohon Periksa Kembali!</strong>
                            <span class="block sm:inline">Ada kolom yang belum Anda lengkapi atau formatnya salah.</span>
                            <ul class="mt-2 list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('user.lapor.store') }}" method="POST" enctype="multipart/form-data"> 
                        @csrf
                        
                        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm mb-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-1">Informasi Pelapor</h3>
                            <p class="text-xs text-gray-400 mb-4">Informasi ini diambil otomatis dari SSO Anda dan tidak dapat diubah.</p>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Nama Pelapor</label>
                                    <input type="text" value="{{ Auth::user()->name }}" readonly class="w-full bg-gray-100 text-gray-500 border border-gray-200 rounded-lg px-4 py-2 text-sm focus:outline-none cursor-not-allowed">
                                </div>
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Nomer Unik</label>
                                    <input type="text" value="{{ Auth::user()->no_unik }}" readonly 
                                           class="w-full bg-gray-100 text-gray-500 border border-gray-200 rounded-lg px-4 py-2 text-sm focus:outline-none cursor-not-allowed">
                                </div>
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                                    <input type="text" value="{{ Auth::user()->email }}" readonly class="w-full bg-gray-100 text-gray-500 border border-gray-200 rounded-lg px-4 py-2 text-sm focus:outline-none cursor-not-allowed">
                                </div>
                            </div>
                        </div>

                        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm mb-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Detail Barang Hilang</h3>
                            <p class="text-xs text-gray-400 mb-4">Berikan informasi lengkap tentang barang yang hilang.</p>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Nama Barang <span class="text-red-500">*</span></label>
                                <input type="text" name="title" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 outline-none transition-all" placeholder="Contoh: Dompet kulit hitam" required>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Kategori <span class="text-red-500">*</span></label>
                                    <select name="category" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 outline-none bg-white" required>
                                        <option value="" disabled selected>Pilih kategori barang</option>
                                        <option value="Elektronik">Elektronik</option>
                                        <option value="Pakaian">Pakaian</option>
                                        <option value="Aksesoris">Aksesoris</option>
                                        <option value="Perabotan">Perabotan</option>
                                        <option value="Kunci">Kunci</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal Hilang/Temuan <span class="text-red-500">*</span></label>
                                    <input type="date" name="date_event" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 outline-none" required>
                                </div>
                            </div>

                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Lokasi Terakhir Terlihat <span class="text-red-500">*</span></label>
                                <input type="text" name="location" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 outline-none transition-all" placeholder="Contoh: Kantin Gedung Rektorat, Lab Komputer A4" required>
                            </div>

                            <div class="mt-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Deskripsi Barang <span class="text-red-500">*</span></label>
                                <textarea name="description" rows="3" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 outline-none transition-all" placeholder="Contoh: Dompet berisi kartu identitas, kartu mahasiswa, dan uang tunai sedikit. Ada stiker 'Universitas Pertamina' di bagian dalam." required></textarea>
                            </div>
                        </div>

                        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm mb-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-1">Foto Barang <span class="text-red-500">*</span></h3>
                            <p class="text-xs text-gray-400 mb-4">Unggah foto barang Anda untuk membantu proses pencarian. Wajib mengunggah foto.</p>
                            
                            <div class="flex items-center justify-center w-full">
                                <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-40 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors" id="dropzone-area">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6 text-center" id="dropzone-text">
                                        <svg class="w-8 h-8 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        <p class="text-sm text-gray-500">Seret & lepas foto di sini, atau <span class="font-bold text-cyan-500">klik untuk memilih file</span></p>
                                        <p class="text-xs text-gray-400 mt-1">PNG, JPG atau JPEG (Maks. 2MB)</p>
                                    </div>
                                    <div id="file-preview" class="hidden flex flex-col items-center">
                                        <p class="text-sm font-semibold text-green-600 mb-1">File Terpilih:</p>
                                        <p class="text-sm text-gray-700" id="filename-display"></p>
                                    </div>
                                    
                                    <input id="dropzone-file" type="file" name="image" class="hidden" onchange="previewImage(this)" required />
                                </label>
                            </div>
                        </div>

                        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm mb-8">
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">Tips Mengambil Foto yang Baik</h3>
                            <p class="text-xs text-gray-400 mb-4">Meningkatkan peluang penemuan dengan foto berkualitas.</p>
                            <ul class="list-disc pl-5 space-y-1 text-xs text-gray-600 mb-6">
                                <li>Ambil foto dari berbagai sudut untuk detail lengkap.</li>
                                <li>Pastikan pencahayaan cukup dan gambar jelas, tidak buram.</li>
                                <li>Sertakan detail unik seperti goresan, stiker, atau logo.</li>
                                <li>Gunakan latar belakang netral agar barang lebih menonjol.</li>
                                <li>Ambil foto item secara keseluruhan, bukan hanya bagian-bagian kecil.</li>
                            </ul>

                            <div class="flex items-start gap-2 mb-6">
                                <input type="checkbox" required class="mt-1 w-4 h-4 text-cyan-600 border-gray-300 rounded focus:ring-cyan-500">
                                <label class="text-xs text-gray-600">Saya mengerti bahwa informasi yang saya berikan akan digunakan untuk membantu menemukan barang hilang saya dan mungkin dibagikan dengan pihak berwenang kampus jika diperlukan.</label>
                            </div>

                            <button type="submit" class="w-full bg-cyan-400 hover:bg-cyan-500 text-white font-bold py-3 px-4 rounded-lg shadow-md transition-colors text-sm">
                                Laporkan Barang Hilang
                            </button>
                        </div>

                    </form>
                </div>

            </main>
           
            <footer class="p-4 bg-white border-t text-center text-xs text-gray-400">
                &copy; 2025 Lost & Found UP. All rights reserved.
            </footer>

        </div>
    </div>

    <script>
        function previewImage(input) {
            const textContainer = document.getElementById('dropzone-text');
            const previewContainer = document.getElementById('file-preview');
            const filenameDisplay = document.getElementById('filename-display');
            const dropzoneArea = document.getElementById('dropzone-area');

            if (input.files && input.files[0]) {
                textContainer.classList.add('hidden');
                previewContainer.classList.remove('hidden');
                filenameDisplay.innerText = input.files[0].name;
                
                dropzoneArea.classList.remove('border-gray-300');
                dropzoneArea.classList.add('border-cyan-400', 'bg-cyan-50');
            }
        }
    </script>
</body>
</html>