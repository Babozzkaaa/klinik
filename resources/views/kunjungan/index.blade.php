@extends('layouts.app')

@section('title', 'Daftar Kunjungan')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Daftar Kunjungan</h1>
        @if(auth()->user() && auth()->user()->hasPermission('kunjungan.create'))
        <a href="{{ route('kunjungan.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white  py-2 px-4 rounded-md flex items-center">
            <i class="fas fa-plus mr-2"></i>Tambah Kunjungan
        </a>
        @endif
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <form method="GET" action="{{ route('kunjungan.index') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Pencarian</label>
                <input type="text" 
                       name="search" 
                       id="search"
                       value="{{ request('search') }}" 
                       placeholder="Cari pasien, dokter, keluhan..."
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label for="jenis_kunjungan" class="block text-sm font-medium text-gray-700 mb-2">Jenis Kunjungan</label>
                <select name="jenis_kunjungan" id="jenis_kunjungan" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Jenis</option>
                    <option value="umum" {{ request('jenis_kunjungan') === 'umum' ? 'selected' : '' }}>Umum</option>
                    <option value="rujukan" {{ request('jenis_kunjungan') === 'rujukan' ? 'selected' : '' }}>Rujukan</option>
                    <option value="kontrol" {{ request('jenis_kunjungan') === 'kontrol' ? 'selected' : '' }}>Kontrol</option>
                    <option value="rutin" {{ request('jenis_kunjungan') === 'rutin' ? 'selected' : '' }}>Rutin</option>
                    <option value="vaksinasi" {{ request('jenis_kunjungan') === 'vaksinasi' ? 'selected' : '' }}>Vaksinasi</option>
                    <option value="darurat" {{ request('jenis_kunjungan') === 'darurat' ? 'selected' : '' }}>Darurat</option>
                </select>
            </div>

            <div>
                <label for="dokter_id" class="block text-sm font-medium text-gray-700 mb-2">Dokter</label>
                <select name="dokter_id" id="dokter_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Dokter</option>
                    @foreach($dokters as $dokter)
                        <option value="{{ $dokter->id }}" {{ request('dokter_id') == $dokter->id ? 'selected' : '' }}>
                            {{ $dokter->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="tanggal_dari" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Dari</label>
                <input type="date" 
                       name="tanggal_dari" 
                       id="tanggal_dari"
                       value="{{ request('tanggal_dari') }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label for="tanggal_sampai" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Sampai</label>
                <input type="date" 
                       name="tanggal_sampai" 
                       id="tanggal_sampai"
                       value="{{ request('tanggal_sampai') }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="flex items-end space-x-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md flex items-center mr-2">
                    <i class="fas fa-search mr-2"></i>Search
                </button>
                <a href="{{ route('kunjungan.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700  py-2 px-4 rounded-md">
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <a href="{{ request()->fullUrlWithQuery(['sort_field' => 'tanggal_kunjungan', 'sort_direction' => request('sort_direction') === 'asc' ? 'desc' : 'asc']) }}" 
                               class="flex items-center space-x-1 text-gray-500 hover:text-gray-700">
                                <span>Tanggal Kunjungan</span>
                                @if(request('sort_field') === 'tanggal_kunjungan')
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pasien</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dokter</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <a href="{{ request()->fullUrlWithQuery(['sort_field' => 'jenis_kunjungan', 'sort_direction' => request('sort_direction') === 'asc' ? 'desc' : 'asc']) }}" 
                               class="flex items-center space-x-1 text-gray-500 hover:text-gray-700">
                                <span>Jenis Kunjungan</span>
                                @if(request('sort_field') === 'jenis_kunjungan')
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keluhan</th>
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
                    @forelse($kunjungans as $kunjungan)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $kunjungan->tanggal_kunjungan->format('d/m/Y H:i') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $kunjungan->pasien->nama ?? '-' }}</div>
                            <div class="text-sm text-gray-500">No Telepon: {{ $kunjungan->pasien->no_telp ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $kunjungan->dokter->nama ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if($kunjungan->jenis_kunjungan === 'darurat') bg-red-100 text-red-800
                                @elseif($kunjungan->jenis_kunjungan === 'rujukan') bg-yellow-100 text-yellow-800
                                @elseif($kunjungan->jenis_kunjungan === 'kontrol') bg-blue-100 text-blue-800
                                @elseif($kunjungan->jenis_kunjungan === 'vaksinasi') bg-green-100 text-green-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst($kunjungan->jenis_kunjungan) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">{{ Str::limit($kunjungan->keluhan, 50) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $kunjungan->created_at->format('d/m/Y') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <div class="flex justify-center space-x-2 gap-3">
                                @if(auth()->user() && auth()->user()->hasPermission('kunjungan.read'))
                                <a href="{{ route('kunjungan.show', $kunjungan) }}" class="text-blue-600 hover:text-blue-900">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @endif
                                
                                @if(auth()->user() && auth()->user()->hasPermission('kunjungan.update'))
                                <a href="{{ route('kunjungan.edit', $kunjungan) }}" class="text-yellow-600 hover:text-yellow-900">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endif
                                
                                @if(auth()->user() && auth()->user()->hasPermission('kunjungan.delete'))
                                <form action="{{ route('kunjungan.destroy', $kunjungan) }}" method="POST" class="inline" 
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus kunjungan ini?')">
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
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                            Tidak ada data kunjungan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
            {{ $kunjungans->links() }}
        </div>
    </div>
</div>
@endsection
