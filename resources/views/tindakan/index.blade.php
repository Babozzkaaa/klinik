@extends('layouts.app')

@section('title', 'Daftar Tindakan')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">Daftar Tindakan</h2>
        @if(auth()->user() && auth()->user()->hasPermission('tindakan.create'))
        <a href="{{ route('tindakan.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md flex items-center">
            <i class="fas fa-plus mr-2"></i> Tambah Tindakan
        </a>
        @endif
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    <div class="bg-white shadow-md rounded-lg p-4 mb-6">
        <form method="GET" action="{{ route('tindakan.index') }}" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari Tindakan</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}" 
                    placeholder="Nama tindakan..."
                    class="w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <div class="flex items-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md flex items-center mr-2">
                    <i class="fas fa-search mr-2"></i>Search
                </button>
                <a href="{{ route('tindakan.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-md">
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
                            <a href="{{ route('tindakan.index', array_merge(request()->query(), ['sort_by' => 'nama', 'sort_direction' => request('sort_direction') === 'asc' ? 'desc' : 'asc'])) }}" 
                               class="flex items-center hover:text-gray-700">
                                Nama Tindakan
                                @if(request('sort_by') === 'nama')
                                    <i class="fas fa-sort-{{ request('sort_direction') === 'asc' ? 'up' : 'down' }} ml-1"></i>
                                @else
                                    <i class="fas fa-sort ml-1 text-gray-400"></i>
                                @endif
                            </a>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <a href="{{ route('tindakan.index', array_merge(request()->query(), ['sort_by' => 'tarif', 'sort_direction' => request('sort_direction') === 'asc' ? 'desc' : 'asc'])) }}" 
                               class="flex items-center hover:text-gray-700">
                                Tarif
                                @if(request('sort_by') === 'tarif')
                                    <i class="fas fa-sort-{{ request('sort_direction') === 'asc' ? 'up' : 'down' }} ml-1"></i>
                                @else
                                    <i class="fas fa-sort ml-1 text-gray-400"></i>
                                @endif
                            </a>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <a href="{{ route('tindakan.index', array_merge(request()->query(), ['sort_by' => 'created_at', 'sort_direction' => request('sort_direction') === 'asc' ? 'desc' : 'asc'])) }}" 
                               class="flex items-center hover:text-gray-700">
                                Tanggal Dibuat
                                @if(request('sort_by') === 'created_at' || !request('sort_by'))
                                    <i class="fas fa-sort-{{ request('sort_direction') === 'asc' ? 'up' : 'down' }} ml-1"></i>
                                @else
                                    <i class="fas fa-sort ml-1 text-gray-400"></i>
                                @endif
                            </a>
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($tindakans as $tindakan)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $tindakan->nama }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">Rp {{ number_format($tindakan->tarif, 0, ',', '.') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $tindakan->created_at->format('d/m/Y') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <div class="flex justify-center space-x-2 gap-3">
                                @if(auth()->user() && auth()->user()->hasPermission('tindakan.read'))
                                <a href="{{ route('tindakan.show', $tindakan) }}" class="text-indigo-600 hover:text-indigo-900">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @endif
                                
                                @if(auth()->user() && auth()->user()->hasPermission('tindakan.update'))
                                <a href="{{ route('tindakan.edit', $tindakan) }}" class="text-yellow-600 hover:text-yellow-900">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endif
                                
                                @if(auth()->user() && auth()->user()->hasPermission('tindakan.delete'))
                                <form action="{{ route('tindakan.destroy', $tindakan) }}" method="POST" class="inline" 
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus tindakan ini?')">
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
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                            Tidak ada data tindakan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
            {{ $tindakans->links() }}
        </div>
    </div>
</div>
@endsection
