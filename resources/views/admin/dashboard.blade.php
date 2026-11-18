<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard Admin</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Banner --}}
            <div class="bg-gradient-to-r from-purple-700 to-indigo-600 rounded-xl shadow p-8 text-white flex items-center justify-between">
                <div>
                    <p class="text-purple-200 text-sm">{{ now()->translatedFormat('l, d F Y') }}</p>
                    <h3 class="text-2xl font-bold mt-1">Halo, {{ auth()->user()->name }} 👋</h3>
                    <p class="mt-1 text-purple-100">Anda memiliki akses penuh untuk mengelola perpustakaan.</p>
                </div>
                <span class="hidden sm:inline-block bg-white/20 px-4 py-2 rounded-full text-sm font-semibold uppercase tracking-wide">Administrator</span>
            </div>

            {{-- Statistik --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-purple-500">
                    <p class="text-sm text-gray-500">Total Pengguna</p>
                    <p class="text-3xl font-bold text-gray-800">{{ \App\Models\User::count() }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-blue-500">
                    <p class="text-sm text-gray-500">Total Buku</p>
                    <p class="text-3xl font-bold text-gray-800">{{ \App\Models\Buku::count() }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-green-500">
                    <p class="text-sm text-gray-500">Total Anggota</p>
                    <p class="text-3xl font-bold text-gray-800">{{ \App\Models\Anggota::count() }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-amber-500">
                    <p class="text-sm text-gray-500">Sedang Dipinjam</p>
                    <p class="text-3xl font-bold text-gray-800">{{ \App\Models\Peminjaman::whereNull('tanggal_kembali')->count() }}</p>
                </div>
            </div>

            {{-- Menu --}}
            <div>
                <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Menu Administrasi</h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

                    @can('kelola data pengguna')
                    <a href="{{ route('admin.users.index') }}" class="group bg-white rounded-xl shadow-sm p-6 hover:shadow-lg hover:-translate-y-1 transition">
                        <div class="w-12 h-12 rounded-lg bg-purple-100 flex items-center justify-center text-2xl">👥</div>
                        <div class="mt-4 font-semibold text-gray-800 group-hover:text-purple-600">Pengguna & Role</div>
                        <div class="text-sm text-gray-500">Kelola akun dan penetapan role</div>
                    </a>
                    @endcan

                    @can('kelola-buku')
                    <a href="{{ route('buku.kelola') }}" class="group bg-white rounded-xl shadow-sm p-6 hover:shadow-lg hover:-translate-y-1 transition">                            <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center text-2xl">📚</div>
                            <div class="mt-4 font-semibold text-gray-800 group-hover:text-blue-600">Kelola Buku</div>
                    </a>
                    @endcan

                    @can('kelola peminjaman')
                    @endcan
                    <a href="{{ route('peminjaman.index') }}" class="group bg-white rounded-xl shadow-sm p-6 hover:shadow-lg hover:-translate-y-1 transition">
                        <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center text-2xl">🔄</div>
                        <div class="mt-4 font-semibold text-gray-800 group-hover:text-green-600">Peminjaman</div>
                        <div class="text-sm text-gray-500">Data peminjaman dan pengembalian</div>
                    </a>

                    @can('lihat laporan perpustakaan')
                    <a href="{{ route('laporan.index') }}" class="group bg-white rounded-xl shadow-sm p-6 hover:shadow-lg hover:-translate-y-1 transition">
                        <div class="w-12 h-12 rounded-lg bg-amber-100 flex items-center justify-center text-2xl">📊</div>
                        <div class="mt-4 font-semibold text-gray-800 group-hover:text-amber-600">Laporan</div>
                        <div class="text-sm text-gray-500">Laporan perpustakaan</div>
                    </a>
                    @endcan

                </div>
            </div>
        </div>
    </div>
</x-app-layout>