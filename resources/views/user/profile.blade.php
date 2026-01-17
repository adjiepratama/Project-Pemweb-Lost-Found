<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - Lost & Found UP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; } </style>
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
                    <a href="{{ route('user.lapor') }}" class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Lapor Barang
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
                    <div class="flex items-center gap-3 border-l pl-6 border-gray-200">
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-semibold text-gray-700 leading-none">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-400 mt-1">Pengguna</p>
                        </div>
                        <div class="h-9 w-9 rounded-full bg-cyan-100 overflow-hidden border border-cyan-300 ring-2 ring-cyan-100">
                            @if(Auth::user()->profile_photo)
                                <img src="{{ asset(Auth::user()->profile_photo) }}" class="h-full w-full object-cover">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0D8ABC&color=fff" class="h-full w-full object-cover">
                            @endif
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-8">
                <div class="max-w-4xl mx-auto">
                    
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Pengaturan Profil</h2>
                    </div>

                    @if(session('success'))
                        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                            <strong class="font-bold">Berhasil!</strong> {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 gap-8">
                        
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                            <div class="p-6 border-b border-gray-100">
                                <h3 class="text-lg font-semibold text-gray-800">Informasi Pribadi</h3>
                                <p class="text-sm text-gray-500">Anda hanya dapat mengubah foto profil. Data diri lainnya dikelola oleh sistem.</p>
                            </div>
                            
                            <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data" class="p-6">
                                @csrf
                                @method('PUT')

                                <div class="flex flex-col md:flex-row gap-8 items-start">
                                    
                                    <div class="w-full md:w-1/3 flex flex-col items-center">
                                        <div class="relative group">
                                            <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-gray-100 shadow-md">
                                                <img id="preview-image" 
                                                     src="{{ Auth::user()->profile_photo ? asset(Auth::user()->profile_photo) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=0D8ABC&color=fff' }}" 
                                                     class="w-full h-full object-cover">
                                            </div>
                                            <label for="photo-upload" class="absolute bottom-0 right-0 bg-cyan-500 hover:bg-cyan-600 text-white p-2 rounded-full cursor-pointer shadow-lg transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                            </label>
                                            <input type="file" id="photo-upload" name="profile_photo" class="hidden" accept="image/*" onchange="previewImage(this)">
                                        </div>
                                        <p class="text-xs text-gray-400 mt-3 text-center">Format: JPG, PNG. Maks 2MB.</p>
                                    </div>

                                    <div class="w-full md:w-2/3 space-y-4">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                                                <input type="text" value="{{ Auth::user()->name }}" readonly class="w-full bg-gray-100 text-gray-500 border border-gray-200 rounded-lg px-3 py-2 cursor-not-allowed focus:outline-none">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                                                <input type="text" value="{{ Auth::user()->username }}" readonly class="w-full bg-gray-100 text-gray-500 border border-gray-200 rounded-lg px-3 py-2 cursor-not-allowed focus:outline-none">
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                                <input type="text" value="{{ Auth::user()->email }}" readonly class="w-full bg-gray-100 text-gray-500 border border-gray-200 rounded-lg px-3 py-2 cursor-not-allowed focus:outline-none">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">No Unik (NIM)</label>
                                                <input type="text" value="{{ Auth::user()->no_unik }}" readonly class="w-full bg-gray-100 text-gray-500 border border-gray-200 rounded-lg px-3 py-2 cursor-not-allowed focus:outline-none">
                                            </div>
                                        </div>

                                        <div class="pt-2 text-right">
                                            <button type="submit" class="px-4 py-2 bg-cyan-600 hover:bg-cyan-700 text-white font-medium rounded-lg text-sm transition-colors shadow-sm">
                                                Simpan Foto Baru
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                            <div class="p-6 border-b border-gray-100">
                                <h3 class="text-lg font-semibold text-gray-800">Keamanan</h3>
                                <p class="text-sm text-gray-500">Ubah kata sandi akun Anda secara berkala.</p>
                            </div>
                            
                            <form action="{{ route('user.password.update') }}" method="POST" class="p-6">
                                @csrf
                                @method('PUT')
                                
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi Saat Ini</label>
                                        <input type="password" name="current_password" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 outline-none">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi Baru</label>
                                        <input type="password" name="new_password" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 outline-none">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Sandi Baru</label>
                                        <input type="password" name="new_password_confirmation" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 outline-none">
                                    </div>
                                </div>

                                <div class="pt-6 text-right">
                                    <button type="submit" class="px-4 py-2 bg-gray-800 hover:bg-gray-900 text-white font-medium rounded-lg text-sm transition-colors shadow-sm">
                                        Perbarui Kata Sandi
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-image').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>