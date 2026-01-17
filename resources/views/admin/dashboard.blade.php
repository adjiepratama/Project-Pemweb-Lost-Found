<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Lost & Found UP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>body{font-family:'Inter',sans-serif}</style>
</head>
<body class="bg-gray-100 text-gray-800">

<div class="flex min-h-screen">
    <aside class="w-64 bg-gray-900 text-white flex flex-col">
        <div class="h-16 flex items-center justify-center border-b border-gray-800 font-bold text-xl">
            Admin Panel
        </div>
        <nav class="flex-1 py-6">
            <a href="#" class="block px-6 py-3 bg-gray-800 border-l-4 border-cyan-500">Dashboard</a>
            <a href="{{ url('/') }}" class="block px-6 py-3 hover:bg-gray-800 text-gray-400 hover:text-white mt-auto">Ke Halaman Utama</a>
            <a href="{{ url('/logout') }}" class="block px-6 py-3 hover:bg-red-900 text-red-400 mt-4">Logout</a>
        </nav>
    </aside>

    <main class="flex-1 p-8 overflow-y-auto">
        <h1 class="text-3xl font-bold mb-8">Dashboard Admin</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6">
                {{ session('success') }}
            </div>
        @endif

        <section class="mb-10">
            <h2 class="text-xl font-bold mb-4 flex items-center gap-2">
                <span class="w-3 h-3 bg-yellow-400 rounded-full"></span> 
                Permintaan Laporan Barang ({{ $pendingItems->count() }})
            </h2>
            
            <div class="bg-white rounded-xl shadow overflow-hidden">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-600 font-bold border-b">
                        <tr>
                            <th class="px-6 py-3">Foto</th>
                            <th class="px-6 py-3">Nama Barang</th>
                            <th class="px-6 py-3">Pelapor</th>
                            <th class="px-6 py-3">Tanggal</th>
                            <th class="px-6 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($pendingItems as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <img src="{{ asset($item->image) }}" class="w-12 h-12 object-cover rounded bg-gray-200">
                            </td>
                            <td class="px-6 py-4 font-medium">{{ $item->title }}<br><span class="text-xs text-gray-400">{{ $item->category }}</span></td>
                            <td class="px-6 py-4">{{ $item->user->name }}<br><span class="text-xs text-gray-400">{{ $item->user->no_unik }}</span></td>
                            <td class="px-6 py-4">{{ $item->date_event }}</td>
                            <td class="px-6 py-4 flex justify-center gap-2">
                                <form action="{{ route('admin.item.update', $item->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="status" value="available">
                                    <button class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-xs font-bold transition">Setujui</button>
                                </form>
                                <form action="{{ route('admin.item.update', $item->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="status" value="rejected">
                                    <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs font-bold transition">Tolak</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="px-6 py-8 text-center text-gray-400">Tidak ada laporan pending.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <section>
            <h2 class="text-xl font-bold mb-4 flex items-center gap-2">
                <span class="w-3 h-3 bg-blue-400 rounded-full"></span> 
                Permintaan Klaim Barang ({{ $pendingClaims->count() }})
            </h2>
            
            <div class="bg-white rounded-xl shadow overflow-hidden">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-600 font-bold border-b">
                        <tr>
                            <th class="px-6 py-3">Barang</th>
                            <th class="px-6 py-3">Pengklaim</th>
                            <th class="px-6 py-3">Bukti/Deskripsi</th>
                            <th class="px-6 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($pendingClaims as $claim)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium">{{ $claim->item->title }}</td>
                            <td class="px-6 py-4">
                                {{ $claim->claimer_name }}<br>
                                <span class="text-xs text-gray-400">{{ $claim->claimer_phone }}</span>
                            </td>
                            <td class="px-6 py-4 max-w-xs truncate">
                                <p class="truncate">{{ $claim->claim_description }}</p>
                                @if($claim->claim_proof)
                                    <a href="{{ asset($claim->claim_proof) }}" target="_blank" class="text-xs text-cyan-600 hover:underline">Lihat Bukti Foto</a>
                                @endif
                            </td>
                            <td class="px-6 py-4 flex justify-center gap-2">
                                <form action="{{ route('admin.claim.update', $claim->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="status" value="verified">
                                    <button class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs font-bold transition">Verifikasi</button>
                                </form>
                                <form action="{{ route('admin.claim.update', $claim->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="status" value="rejected">
                                    <button class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-1 rounded text-xs font-bold transition">Tolak</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="px-6 py-8 text-center text-gray-400">Tidak ada klaim pending.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

    </main>
</div>

</body>
</html>

