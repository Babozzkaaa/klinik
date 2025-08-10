@extends('layouts.app')

@section('title', 'Daftar Pegawai')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">Daftar Pegawai</h2>
        @if(auth()->user() && auth()->user()->hasPermission('pegawai.create'))
        <a href="{{ route('pegawai.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md flex items-center">
            <i class="fas fa-plus mr-2"></i> Tambah Pegawai
        </a>
        @endif
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    <div class="bg-white shadow-md rounded-lg p-4 mb-6">
        <form method="GET" action="{{ route('pegawai.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari Pegawai</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}" 
                    placeholder="Nama, NIP, jabatan..."
                    class="w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <div>
                <label for="jabatan" class="block text-sm font-medium text-gray-700 mb-1">Jabatan</label>
                <select name="jabatan" id="jabatan" 
                    class="w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Semua Jabatan</option>
                    <option value="Dokter" {{ request('jabatan') == 'Dokter' ? 'selected' : '' }}>Dokter</option>
                    <option value="Perawat" {{ request('jabatan') == 'Perawat' ? 'selected' : '' }}>Perawat</option>
                    <option value="Apoteker" {{ request('jabatan') == 'Apoteker' ? 'selected' : '' }}>Apoteker</option>
                    <option value="Admin" {{ request('jabatan') == 'Admin' ? 'selected' : '' }}>Admin</option>
                    <option value="Kasir" {{ request('jabatan') == 'Kasir' ? 'selected' : '' }}>Kasir</option>
                </select>
            </div>
            
            <div>
                <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                <select name="jenis_kelamin" id="jenis_kelamin" 
                    class="w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Semua</option>
                    <option value="L" {{ request('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ request('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>
            
            <div class="flex items-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md flex items-center mr-2">
                    <i class="fas fa-search mr-2"></i>Search
                </button>
                <a href="{{ route('pegawai.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-md">
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
                            <a href="{{ route('pegawai.index', array_merge(request()->query(), ['sort_by' => 'nama', 'sort_direction' => request('sort_direction') === 'asc' ? 'desc' : 'asc'])) }}" 
                               class="flex items-center hover:text-gray-700">
                                Nama
                                @if(request('sort_by') === 'nama')
                                    <i class="fas fa-sort-{{ request('sort_direction') === 'asc' ? 'up' : 'down' }} ml-1"></i>
                                @else
                                    <i class="fas fa-sort ml-1 text-gray-400"></i>
                                @endif
                            </a>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <a href="{{ route('pegawai.index', array_merge(request()->query(), ['sort_by' => 'nip', 'sort_direction' => request('sort_direction') === 'asc' ? 'desc' : 'asc'])) }}" 
                               class="flex items-center hover:text-gray-700">
                                NIP
                                @if(request('sort_by') === 'nip')
                                    <i class="fas fa-sort-{{ request('sort_direction') === 'asc' ? 'up' : 'down' }} ml-1"></i>
                                @else
                                    <i class="fas fa-sort ml-1 text-gray-400"></i>
                                @endif
                            </a>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <a href="{{ route('pegawai.index', array_merge(request()->query(), ['sort_by' => 'jabatan', 'sort_direction' => request('sort_direction') === 'asc' ? 'desc' : 'asc'])) }}" 
                               class="flex items-center hover:text-gray-700">
                                Jabatan
                                @if(request('sort_by') === 'jabatan')
                                    <i class="fas fa-sort-{{ request('sort_direction') === 'asc' ? 'up' : 'down' }} ml-1"></i>
                                @else
                                    <i class="fas fa-sort ml-1 text-gray-400"></i>
                                @endif
                            </a>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Spesialisasi
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Gender
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Wilayah
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            User Account
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <a href="{{ route('pegawai.index', array_merge(request()->query(), ['sort_by' => 'created_at', 'sort_direction' => request('sort_direction') === 'asc' ? 'desc' : 'asc'])) }}" 
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
                    @forelse($pegawais as $pegawai)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                        <i class="fas fa-user text-gray-600"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $pegawai->nama }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $pegawai->nip }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $pegawai->jabatan == 'Dokter' ? 'bg-green-100 text-green-800' : 
                                   ($pegawai->jabatan == 'Perawat' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                                {{ $pegawai->jabatan }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $pegawai->spesialisasi ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $pegawai->jenis_kelamin == 'L' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                                {{ $pegawai->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div>{{ $pegawai->kabupaten->nama }}</div>
                            <div class="text-xs text-gray-400">{{ $pegawai->provinsi->nama }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div>{{ $pegawai->user->name }}</div>
                            <div class="text-xs text-gray-400">{{ $pegawai->user->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $pegawai->created_at->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-2 gap-3">
                                @if(auth()->user() && auth()->user()->hasPermission('pegawai.read'))
                                <a href="{{ route('pegawai.show', $pegawai) }}" class="text-indigo-600 hover:text-indigo-900">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @endif
                                @if(auth()->user() && auth()->user()->hasPermission('pegawai.update'))
                                <a href="{{ route('pegawai.edit', $pegawai) }}" class="text-yellow-600 hover:text-yellow-900">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endif
                                @if(auth()->user() && auth()->user()->hasPermission('pegawai.delete'))
                                <form action="{{ route('pegawai.destroy', $pegawai) }}" method="POST" class="inline-block" 
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus pegawai ini?')">
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
                        <td colspan="8" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                            <div class="flex flex-col items-center py-8">
                                <i class="fas fa-user-tie text-4xl text-gray-300 mb-4"></i>
                                <p class="text-lg font-medium">Tidak ada pegawai ditemukan</p>
                                <p class="text-sm">
                                    @if(request()->filled('search'))
                                        Coba ubah kriteria pencarian Anda
                                    @else
                                        Mulai dengan menambahkan pegawai baru
                                    @endif
                                </p>
                                @if(!request()->filled('search') && auth()->user() && auth()->user()->hasPermission('pegawai.create'))
                                <a href="{{ route('pegawai.create') }}" class="mt-4 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                                    <i class="fas fa-plus mr-2"></i>Tambah Pegawai Pertama
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pegawais->hasPages())
        <div class="px-5 py-5 bg-white border-t flex flex-col xs:flex-row items-center xs:justify-between">
            {{ $pegawais->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
