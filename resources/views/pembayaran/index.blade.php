@extends('layouts.app')

@section('title', 'Data Pembayaran')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 space-y-2 sm:space-y-0">
            <h1 class="text-2xl font-bold text-gray-900">Data Pembayaran</h1>
            <div class="flex gap-2 w-full sm:w-auto">
                <a href="{{ route('pembayaran.export-all-pdf', request()->query()) }}" target="_blank" class="bg-red-600 hover:bg-red-800 text-white py-2 px-4 rounded-md text-center flex items-center">
                    <i class="fas fa-file-pdf mr-2"></i>Export PDF
                </a>
                <a href="{{ route('pembayaran.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md text-center flex items-center">
                    <i class="fas fa-plus mr-2"></i>Tambah Pembayaran
                </a>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-lg">
            <div class="p-6 border-b border-gray-200">
                <form method="GET" action="{{ route('pembayaran.index') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div>
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   placeholder="Cari no pembayaran, nama pasien..." 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Semua Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="sebagian" {{ request('status') == 'sebagian' ? 'selected' : '' }}>Sebagian</option>
                                <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                        </div>
                        <div>
                            <select name="metode_pembayaran" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Semua Metode</option>
                                <option value="cash" {{ request('metode_pembayaran') == 'cash' ? 'selected' : '' }}>Cash</option>
                                <option value="debit" {{ request('metode_pembayaran') == 'debit' ? 'selected' : '' }}>Debit</option>
                                <option value="kredit" {{ request('metode_pembayaran') == 'kredit' ? 'selected' : '' }}>Kredit</option>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Dari</label>
                            <input type="date" name="tanggal_dari" value="{{ request('tanggal_dari') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Sampai</label>
                            <input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="flex space-x-2">
                            <button type="submit" class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md flex items-center mr-2">
                                <i class="fas fa-search mr-1"></i>Search
                            </button>
                            <a href="{{ route('pembayaran.index') }}" class="w-full sm:w-auto bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-md">
                                <i class="fas fa-undo mr-1"></i>Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                No Pembayaran
                            </th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Pasien
                            </th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                                Tanggal
                            </th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total
                            </th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">
                                Dibayar
                            </th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">
                                Kembalian
                            </th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">
                                Status
                            </th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($pembayarans as $pembayaran)
                            <tr class="hover:bg-gray-50">
                                <td class="px-3 py-4 text-sm">
                                    <div class="font-medium text-gray-900">{{ $pembayaran->no_pembayaran }}</div>
                                    <div class="text-gray-500 text-xs block md:hidden">{{ $pembayaran->tanggal_pembayaran->format('d/m/Y') }}</div>
                                </td>
                                <td class="px-3 py-4 text-sm">
                                    <div class="text-gray-900">{{ $pembayaran->kunjungan->pasien->nama }}</div>
                                    <div class="text-gray-500 text-xs block sm:hidden">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $pembayaran->status == 'selesai' ? 'bg-green-100 text-green-800' : 
                                               ($pembayaran->status == 'sebagian' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                            {{ ucfirst($pembayaran->status) }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-900 hidden md:table-cell">
                                    {{ $pembayaran->tanggal_pembayaran->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-3 py-4 text-sm">
                                    <div class="text-gray-900 font-medium">Rp {{ number_format($pembayaran->total_tagihan, 0, ',', '.') }}</div>
                                    <div class="text-gray-500 text-xs block lg:hidden">
                                        Bayar: Rp {{ number_format($pembayaran->jumlah_dibayar, 0, ',', '.') }}
                                        @if($pembayaran->kembalian > 0)
                                        <br>Kembali: Rp {{ number_format($pembayaran->kembalian, 0, ',', '.') }}
                                        @endif
                                    </div>
                                </td>
                                <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-900 hidden lg:table-cell">
                                    Rp {{ number_format($pembayaran->jumlah_dibayar, 0, ',', '.') }}
                                </td>
                                <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-900 hidden lg:table-cell">
                                    Rp {{ number_format($pembayaran->kembalian, 0, ',', '.') }}
                                </td>
                                <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-900 hidden sm:table-cell">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $pembayaran->status == 'selesai' ? 'bg-green-100 text-green-800' : 
                                           ($pembayaran->status == 'sebagian' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                        {{ ucfirst($pembayaran->status) }}
                                    </span>
                                </td>
                                <td class="px-3 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex flex-col sm:flex-row sm:space-x-2 space-y-1 sm:space-y-0 gap-3">
                                        <a href="{{ route('pembayaran.show', $pembayaran) }}" 
                                           class="text-indigo-600 hover:text-indigo-900 text-xs sm:text-sm">
                                            <i class="fas fa-eye"></i><span class="ml-1 sm:hidden">Detail</span>
                                        </a>
                                        <a href="{{ route('pembayaran.edit', $pembayaran) }}" 
                                           class="text-yellow-600 hover:text-yellow-900 text-xs sm:text-sm">
                                            <i class="fas fa-edit"></i><span class="ml-1 sm:hidden">Edit</span>
                                        </a>
                                        <form action="{{ route('pembayaran.destroy', $pembayaran) }}" method="POST" 
                                              class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pembayaran ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 text-xs sm:text-sm">
                                                <i class="fas fa-trash"></i><span class="ml-1 sm:hidden">Hapus</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                                    Tidak ada data pembayaran ditemukan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($pembayarans->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $pembayarans->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
