@extends('layouts.app')

@section('title', 'Data Obat Kunjungan')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Data Obat Kunjungan</h1>
            @if (auth()->user() && auth()->user()->hasPermission('kunjungan-obat.create'))
            <a href="{{ route('kunjungan-obat.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md flex items-center">
                <i class="fas fa-plus mr-2"></i>Tambah Obat Kunjungan
            </a>
            @endif
        </div>

        <div class="bg-white shadow-md rounded-lg">
            <div class="p-6 border-b border-gray-200">
                <form method="GET" action="{{ route('kunjungan-obat.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Cari nama pasien, obat, atau instruksi..." 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <select name="obat_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Semua Obat</option>
                            @foreach($obats as $obat)
                                <option value="{{ $obat->id }}" {{ request('obat_id') == $obat->id ? 'selected' : '' }}>
                                    {{ $obat->nama_obat }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex space-x-2">
                        <button type="submit" class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md flex items-center mr-2">
                            <i class="fas fa-search mr-2"></i>Search
                        </button>
                        <a href="{{ route('kunjungan-obat.index') }}" class="w-full sm:w-auto bg-gray-300 hover:bg-gray-400 text-gray-700 py-2 px-4 rounded-md">
                            <i class="fas fa-undo mr-2"></i>Reset
                        </a>
                    </div>
                </form>
            </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <a href="{{ request()->fullUrlWithQuery(['sort_field' => 'id', 'sort_direction' => request('sort_direction') === 'asc' ? 'desc' : 'asc']) }}" 
                               class="flex items-center space-x-1 hover:text-gray-700">
                                <span>ID</span>
                                @if(request('sort_field') === 'id' || !request('sort_field'))
                                    <i class="fas fa-sort-{{ request('sort_direction') === 'desc' ? 'down' : 'up' }}"></i>
                                @else
                                    <i class="fas fa-sort text-gray-400"></i>
                                @endif
                            </a>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Pasien
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tanggal Kunjungan
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Obat
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Jumlah
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tarif
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Subtotal
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Instruksi
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($kunjunganObats as $kunjunganObat)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $kunjunganObat->id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $kunjunganObat->kunjungan->pasien->nama }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ \Carbon\Carbon::parse($kunjunganObat->kunjungan->tanggal_kunjungan)->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $kunjunganObat->obat->nama_obat }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ number_format($kunjunganObat->jumlah) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                Rp {{ number_format($kunjunganObat->tarif, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                Rp {{ number_format($kunjunganObat->subtotal, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                <div class="max-w-xs">
                                    {{ $kunjunganObat->instruksi ?? '-' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2 gap-3">
                                    @if(auth()->user() && auth()->user()->hasPermission('kunjungan-obat.read'))
                                        <a href="{{ route('kunjungan-obat.show', $kunjunganObat) }}" class="text-blue-600 hover:text-blue-900">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    @endif
                                    @if(auth()->user() && auth()->user()->hasPermission('kunjungan-obat.update'))
                                        <a href="{{ route('kunjungan-obat.edit', $kunjunganObat) }}" class="text-yellow-600 hover:text-yellow-900">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endif
                                    @if(auth()->user() && auth()->user()->hasPermission('kunjungan-obat.delete'))
                                        <form method="POST" action="{{ route('kunjungan-obat.destroy', $kunjunganObat) }}" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-4 text-center text-gray-500">
                                Tidak ada data obat kunjungan yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

            @if($kunjunganObats->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $kunjunganObats->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
