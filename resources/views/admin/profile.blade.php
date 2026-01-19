<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Profil - Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
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
                    <p class="px-2 text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">Menu Utama</p>
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 text-gray-600 hover:bg-cyan-50 hover:text-cyan-600 rounded-lg font-medium transition-colors">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
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
                    <h2 class="text-xl font-bold text-gray-800">Pengaturan Profil</h2>
                    <p class="text-xs text-gray-500">Kelola informasi pribadi dan keamanan akun</p>
                </div>
                <div class="flex items-center gap-4">
                     <div class="text-right hidden sm:block">
                        <p class="text-sm font-semibold text-gray-700">{{ Auth::user()->name }}</p>
                    </div>
                    <div class="h-8 w-8 rounded-full bg-cyan-100 flex items-center justify-center text-cyan-600 font-bold overflow-hidden">
                        @if(Auth::user()->profile_photo)
                            <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" class="w-full h-full object-cover">
                        @else
                            {{ substr(Auth::user()->name, 0, 1) }}
                        @endif
                    </div>
                </div>
            </header>

            <div class="flex-1 overflow-y-auto p-8">
                
                @if(session('success'))
                <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    {{ session('success') }}
                </div>
                @endif

                @if($errors->any())
                <div class="bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="bg-white rounded-xl border border-gray-200 shadow-sm mb-8">
                    <div class="p-6 border-b border-gray-100">
                        <h3 class="text-lg font-bold text-gray-900">Informasi Pribadi</h3>
                        <p class="text-sm text-gray-500">Anda hanya dapat mengubah foto profil. Data lain dikelola oleh sistem.</p>
                    </div>
                    
                    <div class="p-6">
                        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="flex flex-col md:flex-row gap-8">
                            @csrf
                            @method('PUT')

                            <div class="w-full md:w-1/3 flex flex-col items-center justify-center" x-data="imageViewer()">
                                <div class="relative group">
                                    <div class="w-40 h-40 rounded-full bg-cyan-600 flex items-center justify-center text-white text-4xl font-bold overflow-hidden border-4 border-white shadow-lg">
                                        <template x-if="imageUrl">
                                            <img :src="imageUrl" class="w-full h-full object-cover">
                                        </template>
                                        
                                        <template x-if="!imageUrl">
                                            @if(Auth::user()->profile_photo)
                                                <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" class="w-full h-full object-cover">
                                            @else
                                                <span>{{ substr(Auth::user()->name, 0, 2) }}</span>
                                            @endif
                                        </template>
                                    </div>

                                    <label for="avatarInput" class="absolute bottom-2 right-2 bg-cyan-500 hover:bg-cyan-600 text-white p-2 rounded-full cursor-pointer shadow-md transition-colors border-2 border-white">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    </label>
                                    
                                    <input type="file" id="avatarInput" name="profile_photo" class="hidden" accept="image/*" @change="fileChosen">
                                </div>
                                <p class="text-xs text-gray-400 mt-3">Format: JPG, PNG. Maks 2MB.</p>
                            </div>

                            <div class="w-full md:w-2/3 grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="col-span-2 md:col-span-1">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                                    <input type="text" name="name" value="{{ Auth::user()->name }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-cyan-500 focus:border-cyan-500 bg-gray-50 text-gray-500 cursor-not-allowed" readonly>
                                </div>

                                <div class="col-span-2 md:col-span-1">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                                    <input type="text" value="{{ Auth::user()->name }}" class="w-full border-gray-300 rounded-lg shadow-sm bg-gray-50 text-gray-500 cursor-not-allowed" readonly>
                                </div>

                                <div class="col-span-2 md:col-span-1">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                    <input type="email" value="{{ Auth::user()->email }}" class="w-full border-gray-300 rounded-lg shadow-sm bg-gray-50 text-gray-500 cursor-not-allowed" readonly>
                                </div>

                                <div class="col-span-2 md:col-span-1">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">No Unik (NIM/NIP)</label>
                                    <input type="text" value="12345678" class="w-full border-gray-300 rounded-lg shadow-sm bg-gray-50 text-gray-500 cursor-not-allowed" readonly>
                                </div>

                                <div class="col-span-2 flex justify-end mt-2">
                                    <button type="submit" class="bg-cyan-600 hover:bg-cyan-700 text-white font-bold py-2.5 px-6 rounded-lg shadow-sm transition-colors text-sm">
                                        Simpan Foto Baru
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                    <div class="p-6 border-b border-gray-100">
                        <h3 class="text-lg font-bold text-gray-900">Keamanan</h3>
                        <p class="text-sm text-gray-500">Ubah kata sandi akun Anda secara berkala.</p>
                    </div>
                    
                    <div class="p-6">
                        <form action="{{ route('admin.password.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi Saat Ini</label>
                                    <input type="password" name="current_password" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-cyan-500 focus:border-cyan-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi Baru</label>
                                    <input type="password" name="password" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-cyan-500 focus:border-cyan-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Sandi Baru</label>
                                    <input type="password" name="password_confirmation" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-cyan-500 focus:border-cyan-500">
                                </div>
                            </div>

                            <div class="flex justify-end mt-6">
                                <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white font-bold py-2.5 px-6 rounded-lg shadow-sm transition-colors text-sm">
                                    Perbarui Kata Sandi
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <script>
        function imageViewer() {
            return {
                imageUrl: null,

                fileChosen(event) {
                    this.fileToDataUrl(event, src => this.imageUrl = src)
                },

                fileToDataUrl(event, callback) {
                    if (! event.target.files.length) return

                    let file = event.target.files[0],
                        reader = new FileReader()

                    reader.readAsDataURL(file)
                    reader.onload = e => callback(e.target.result)
                },
            }
        }
    </script>
</body>
</html>