@extends('layouts.app')

@section('title', 'Daftar Kabupaten/Kota')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">Daftar Kabupaten/Kota</h2>
        @if(auth()->user() && auth()->user()->hasPermission('kabupaten.create'))
        <a href="{{ route('kabupaten.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-md flex items-center">
            <i class="fas fa-plus mr-2"></i> Tambah Kabupaten
        </a>
        @endif
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    <div class="bg-white shadow-md rounded-lg p-4 mb-6">
        <form method="GET" action="{{ route('kabupaten.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari Kabupaten/Kota</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}" 
                    placeholder="Nama atau kode kabupaten/kota..."
                    class="w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <div>
                <label for="provinsi_id" class="block text-sm font-medium text-gray-700 mb-1">Provinsi</label>
                <select name="provinsi_id" id="provinsi_id" 
                    class="w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Semua Provinsi</option>
                    @foreach($provinsis as $provinsi)
                        <option value="{{ $provinsi->id }}" {{ request('provinsi_id') == $provinsi->id ? 'selected' : '' }}>
                            {{ $provinsi->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="flex items-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md flex items-center mr-2">
                    <i class="fas fa-search mr-2"></i>Search
                </button>
                <a href="{{ route('kabupaten.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-md">
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
                            <a href="{{ route('kabupaten.index', array_merge(request()->query(), ['sort_by' => 'nama', 'sort_direction' => request('sort_direction') === 'asc' ? 'desc' : 'asc'])) }}" 
                               class="flex items-center hover:text-gray-700">
                                Nama Kabupaten/Kota
                                @if(request('sort_by') === 'nama')
                                    <i class="fas fa-sort-{{ request('sort_direction') === 'asc' ? 'up' : 'down' }} ml-1"></i>
                                @else
                                    <i class="fas fa-sort ml-1 text-gray-400"></i>
                                @endif
                            </a>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <a href="{{ route('kabupaten.index', array_merge(request()->query(), ['sort_by' => 'kode', 'sort_direction' => request('sort_direction') === 'asc' ? 'desc' : 'asc'])) }}" 
                               class="flex items-center hover:text-gray-700">
                                Kode
                                @if(request('sort_by') === 'kode')
                                    <i class="fas fa-sort-{{ request('sort_direction') === 'asc' ? 'up' : 'down' }} ml-1"></i>
                                @else
                                    <i class="fas fa-sort ml-1 text-gray-400"></i>
                                @endif
                            </a>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Provinsi
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <a href="{{ route('kabupaten.index', array_merge(request()->query(), ['sort_by' => 'created_at', 'sort_direction' => request('sort_direction') === 'asc' ? 'desc' : 'asc'])) }}" 
                               class="flex items-center hover:text-gray-700">
                                Tanggal Dibuat
                                @if(request('sort_by') === 'created_at' || !request('sort_by'))
                                    <i class="fas fa-sort-{{ request('sort_direction') === 'asc' ? 'up' : 'down' }} ml-1"></i>
                                @else
                                    <i class="fas fa-sort ml-1 text-gray-400"></i>
                                @endif
                            </a>
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($kabupatens as $kabupaten)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $kabupaten->nama }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $kabupaten->kode }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                {{ $kabupaten->provinsi->nama }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $kabupaten->created_at->format('d M Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-2 gap-3">
                                @if(auth()->user() && auth()->user()->hasPermission('kabupaten.read'))
                                <a href="{{ route('kabupaten.show', $kabupaten) }}" class="text-indigo-600 hover:text-indigo-900">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @endif
                                @if(auth()->user() && auth()->user()->hasPermission('kabupaten.update'))
                                <a href="{{ route('kabupaten.edit', $kabupaten) }}" class="text-yellow-600 hover:text-yellow-900">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endif
                                @if(auth()->user() && auth()->user()->hasPermission('kabupaten.delete'))
                                <form action="{{ route('kabupaten.destroy', $kabupaten) }}" method="POST" class="inline-block" 
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus kabupaten/kota ini?')">
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
                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                            <div class="flex flex-col items-center py-8">
                                <i class="fas fa-city text-4xl text-gray-300 mb-4"></i>
                                <p class="text-lg font-medium">Tidak ada kabupaten/kota ditemukan</p>
                                <p class="text-sm">
                                    @if(request()->filled('search'))
                                        Coba ubah kriteria pencarian Anda
                                    @else
                                        Mulai dengan menambahkan kabupaten/kota baru
                                    @endif
                                </p>
                                @if(!request()->filled('search') && auth()->user() && auth()->user()->hasPermission('kabupaten.create'))
                                <a href="{{ route('kabupaten.create') }}" class="mt-4 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                                    <i class="fas fa-plus mr-2"></i>Tambah Kabupaten/Kota Pertama
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($kabupatens->hasPages())
            <div>
                {{ $kabupatens->links() }}
            </div>

        @endif
    </div>
</div>
@endsection
