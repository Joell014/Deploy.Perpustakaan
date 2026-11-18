<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard Siswa</h2>
    </x-slot>

    @php
        $anggota = auth()->user()->anggota;
        $pinjamanSaya = $anggota ? \App\Models\Peminjaman::where('anggota_id', $anggota->id) : null;
    @endphp

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-gradient-to-r from-sky-600 to-blue-500 rounded-xl shadow p-8 text-white flex items-center justify-between">
                <div>
                    <p class="text-sky-100 text-sm">{{ now()->translatedFormat('l, d F Y') }}</p>
                    <h3 class="text-2xl font-bold mt-1">Halo, {{ auth()->user()->name }} 👋</h3>
                    <p class="mt-1 text-sky-50">Selamat membaca! Temukan buku favoritmu di perpustakaan.</p>
                </div>
                <span class="hidden sm:inline-block bg-white/20 px-4 py-2 rounded-full text-sm font-semibold uppercase tracking-wide">Siswa</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-blue-500">
                    <p class="text-sm text-gray-500">Total Buku Tersedia</p>
                    <p class="text-3xl font-bold text-gray-800">{{ \App\Models\Buku::count() }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-amber-500">
                    <p class="text-sm text-gray-500">Sedang Saya Pinjam</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $pinjamanSaya ? (clone $pinjamanSaya)->whereNull('tanggal_kembali')->count() : 0 }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-green-500">
                    <p class="text-sm text-gray-500">Total Riwayat Saya</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $pinjamanSaya ? (clone $pinjamanSaya)->count() : 0 }}</p>
                </div>
            </div>

            <div>
                <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Menu Saya</h4>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    @can('lihat daftar buku')
                    <a href="{{ route('buku.index') }}" class="group bg-white rounded-xl shadow-sm p-6 hover:shadow-lg hover:-translate-y-1 transition">
                        <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center text-2xl">📚</div>
                        <div class="mt-4 font-semibold text-gray-800 group-hover:text-blue-600">Daftar Buku</div>
                        <div class="text-sm text-gray-500">Jelajahi dan lihat detail buku</div>
                    </a>
                    @endcan

                    @can('melihat riwayat peminjaman sendiri')
                    <a href="{{ route('riwayat.index') }}" class="group bg-white rounded-xl shadow-sm p-6 hover:shadow-lg hover:-translate-y-1 transition">
                        <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center text-2xl">🕘</div>
                        <div class="mt-4 font-semibold text-gray-800 group-hover:text-green-600">Riwayat Peminjaman</div>
                        <div class="text-sm text-gray-500">Peminjaman milik saya</div>
                    </a>
                    @endcan

                    @can('lihat profil sendiri')
                    <a href="{{ route('profile.edit') }}" class="group bg-white rounded-xl shadow-sm p-6 hover:shadow-lg hover:-translate-y-1 transition">
                        <div class="w-12 h-12 rounded-lg bg-purple-100 flex items-center justify-center text-2xl">👤</div>
                        <div class="mt-4 font-semibold text-gray-800 group-hover:text-purple-600">Profil Saya</div>
                        <div class="text-sm text-gray-500">Lihat dan perbarui profil</div>
                    </a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</x-app-layout>