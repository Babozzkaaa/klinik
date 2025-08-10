@extends('layouts.app')

@section('title', 'Daftar Tindakan Kunjungan')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Daftar Tindakan Kunjungan</h1>
        @if(auth()->user() && auth()->user()->hasPermission('kunjungan-tindakan.create'))
        <a href="{{ route('kunjungan-tindakan.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md flex items-center">
            <i class="fas fa-plus mr-2"></i>Tambah Tindakan
        </a>
        @endif
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <form method="GET" action="{{ route('kunjungan-tindakan.index') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Pencarian</label>
                <input type="text" 
                       name="search" 
                       id="search"
                       value="{{ request('search') }}" 
                       placeholder="Cari pasien, tindakan, catatan..."
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>


            <div>
                <label for="tindakan_id" class="block text-sm font-medium text-gray-700 mb-2">Tindakan</label>
                <select name="tindakan_id" id="tindakan_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Tindakan</option>
                    @foreach($tindakans as $tindakan)
                        <option value="{{ $tindakan->id }}" {{ request('tindakan_id') == $tindakan->id ? 'selected' : '' }}>
                            {{ $tindakan->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-end space-x-2">
                <button type="submit" class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md flex items-center mr-2">
                    <i class="fas fa-search mr-2"></i>Search
                </button>
                <a href="{{ route('kunjungan-tindakan.index') }}" class="w-full sm:w-auto bg-gray-300 hover:bg-gray-400 text-gray-700  py-2 px-4 rounded-md">
                    <i class="fas fa-undo mr-2"></i>Reset
                </a>
            </div>
        </form>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pasien</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Kunjungan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <a href="{{ request()->fullUrlWithQuery(['sort_field' => 'tindakan_id', 'sort_direction' => request('sort_direction') === 'asc' ? 'desc' : 'asc']) }}" 
                               class="flex items-center space-x-1 text-gray-500 hover:text-gray-700">
                                <span>Tindakan</span>
                                @if(request('sort_field') === 'tindakan_id')
                                    @if(request('sort_direction') === 'asc')
                                        <i class="fas fa-sort-up"></i>
                                    @else
                                        <i class="fas fa-sort-down"></i>
                                    @endif
                                @else
                                    <i class="fas fa-sort text-gray-400"></i>
                                @endif
                            </a>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <a href="{{ request()->fullUrlWithQuery(['sort_field' => 'jumlah', 'sort_direction' => request('sort_direction') === 'asc' ? 'desc' : 'asc']) }}" 
                               class="flex items-center space-x-1 text-gray-500 hover:text-gray-700">
                                <span>Jumlah</span>
                                @if(request('sort_field') === 'jumlah')
                                    @if(request('sort_direction') === 'asc')
                                        <i class="fas fa-sort-up"></i>
                                    @else
                                        <i class="fas fa-sort-down"></i>
                                    @endif
                                @else
                                    <i class="fas fa-sort text-gray-400"></i>
                                @endif
                            </a>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <a href="{{ request()->fullUrlWithQuery(['sort_field' => 'tarif', 'sort_direction' => request('sort_direction') === 'asc' ? 'desc' : 'asc']) }}" 
                               class="flex items-center space-x-1 text-gray-500 hover:text-gray-700">
                                <span>Tarif</span>
                                @if(request('sort_field') === 'tarif')
                                    @if(request('sort_direction') === 'asc')
                                        <i class="fas fa-sort-up"></i>
                                    @else
                                        <i class="fas fa-sort-down"></i>
                                    @endif
                                @else
                                    <i class="fas fa-sort text-gray-400"></i>
                                @endif
                            </a>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <a href="{{ request()->fullUrlWithQuery(['sort_field' => 'subtotal', 'sort_direction' => request('sort_direction') === 'asc' ? 'desc' : 'asc']) }}" 
                               class="flex items-center space-x-1 text-gray-500 hover:text-gray-700">
                                <span>Subtotal</span>
                                @if(request('sort_field') === 'subtotal')
                                    @if(request('sort_direction') === 'asc')
                                        <i class="fas fa-sort-up"></i>
                                    @else
                                        <i class="fas fa-sort-down"></i>
                                    @endif
                                @else
                                    <i class="fas fa-sort text-gray-400"></i>
                                @endif
                            </a>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <a href="{{ request()->fullUrlWithQuery(['sort_field' => 'created_at', 'sort_direction' => request('sort_direction') === 'asc' ? 'desc' : 'asc']) }}" 
                               class="flex items-center space-x-1 text-gray-500 hover:text-gray-700">
                                <span>Tanggal Dibuat</span>
                                @if(request('sort_field') === 'created_at' || !request('sort_field'))
                                    @if(request('sort_direction') === 'asc')
                                        <i class="fas fa-sort-up"></i>
                                    @else
                                        <i class="fas fa-sort-down"></i>
                                    @endif
                                @else
                                    <i class="fas fa-sort text-gray-400"></i>
                                @endif
                            </a>
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($kunjunganTindakans as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $item->kunjungan->pasien->nama ?? '-' }}</div>
                            <div class="text-sm text-gray-500">No Telepon: {{ $item->kunjungan->pasien->no_telp ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $item->kunjungan->tanggal_kunjungan->format('d/m/Y H:i') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $item->tindakan->nama ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $item->jumlah }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">Rp {{ number_format($item->tarif, 0, ',', '.') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $item->created_at->format('d/m/Y') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <div class="flex justify-center space-x-2 gap-3">
                                @if(auth()->user() && auth()->user()->hasPermission('kunjungan-tindakan.read'))
                                <a href="{{ route('kunjungan-tindakan.show', $item) }}" class="text-blue-600 hover:text-blue-900">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @endif
                                
                                @if(auth()->user() && auth()->user()->hasPermission('kunjungan-tindakan.update'))
                                <a href="{{ route('kunjungan-tindakan.edit', $item) }}" class="text-yellow-600 hover:text-yellow-900">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endif
                                
                                @if(auth()->user() && auth()->user()->hasPermission('kunjungan-tindakan.delete'))
                                <form action="{{ route('kunjungan-tindakan.destroy', $item) }}" method="POST" class="inline" 
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus tindakan kunjungan ini?')">
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
                        <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                            Tidak ada data tindakan kunjungan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
            {{ $kunjunganTindakans->links() }}
        </div>
    </div>
</div>
@endsection
