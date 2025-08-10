@extends('layouts.app')

@section('title', 'Tambah Permission')

@section('content')
<div class="container mx-auto px-4 py-6">
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('admin.permissions.index') }}" class="text-green-600 hover:text-green-800">
                    <i class="fas fa-key mr-2"></i>
                    Manajemen Permission
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <span class="text-gray-500">Tambah Permission</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="max-w-2xl mx-auto">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="bg-green-600 px-6 py-4">
                <h3 class="text-lg font-medium text-white flex items-center">
                    <i class="fas fa-plus-circle mr-2"></i>
                    Tambah Permission Baru
                </h3>
            </div>
            
            <form action="{{ route('admin.permissions.store') }}" method="POST" class="p-6">
                @csrf
                
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama Permission</label>
                        <input type="text" name="name" id="name" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500"
                            value="{{ old('name') }}" placeholder="Contoh: Dashboard Admin, Kelola Produk">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="code" class="block text-sm font-medium text-gray-700">Kode Permission</label>
                        <input type="text" name="code" id="code" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500"
                            value="{{ old('code') }}" placeholder="Contoh: admin_dashboard, manage_produk">
                        @error('code')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Kode unik untuk identifikasi permission dalam sistem (gunakan underscore, lowercase)</p>
                    </div>

                    <div class="border border-blue-200 rounded-lg p-4 bg-blue-50">
                        <div class="flex items-center mb-3">
                            <input type="checkbox" name="generate_crud" id="generate_crud" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="generate_crud" class="ml-2 block text-sm font-medium text-blue-800">
                                <i class="fas fa-magic mr-1"></i>
                                Generate CRUD Permissions
                            </label>
                        </div>
                        <p class="text-xs text-blue-700 mb-3">Membuat 4 permission: Create, Read, Update, Delete untuk suatu resource</p>
                        
                        <div id="crud_options" class="space-y-3" style="display: none;">
                            <div>
                                <label for="resource_name" class="block text-sm font-medium text-blue-800">Resource Display Name</label>
                                <input type="text" name="resource_name" id="resource_name"
                                    class="mt-1 block w-full border border-blue-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Contoh: Obat, Pasien, User">
                                <p class="mt-1 text-xs text-blue-600">Nama yang akan ditampilkan di permission (contoh: "Lihat Obat", "Tambah Pasien")</p>
                            </div>

                            <div>
                                <label for="resource_code" class="block text-sm font-medium text-blue-800">Resource Code</label>
                                <input type="text" name="resource_code" id="resource_code"
                                    class="mt-1 block w-full border border-blue-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Contoh: obat, pasien, user">
                                <p class="mt-1 text-xs text-blue-600">Kode resource untuk CRUD (huruf kecil, tanpa spasi)</p>
                            </div>
                            
                            
                            
                            <div class="bg-blue-100 p-3 rounded border">
                                <p class="text-xs text-blue-800 font-medium mb-1">Preview permissions yang akan dibuat:</p>
                                <div id="crud_preview" class="text-xs text-blue-700 grid grid-cols-2 gap-1">
                                    <div>• <span class="resource-display">Resource</span> (read)</div>
                                    <div>• Tambah <span class="resource-display">Resource</span> (create)</div>
                                    <div>• Edit <span class="resource-display">Resource</span> (update)</div>
                                    <div>• Hapus <span class="resource-display">Resource</span> (delete)</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3 mt-6 pt-6 border-t">
                    <a href="{{ route('admin.permissions.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-md">
                        <i class="fas fa-times mr-2"></i>Batal
                    </a>
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-md">
                        <i class="fas fa-save mr-2"></i>Simpan Permission
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('name').addEventListener('input', function() {
    const name = this.value;
    const code = name.toLowerCase()
        .replace(/[^a-z0-9\s]/g, '')
        .replace(/\s+/g, '_') 
        .replace(/_+/g, '_') 
        .replace(/^_|_$/g, '');
    
    document.getElementById('code').value = code;
});

document.getElementById('generate_crud').addEventListener('change', function() {
    const crudOptions = document.getElementById('crud_options');
    const nameField = document.getElementById('name');
    const codeField = document.getElementById('code');
    
    if (this.checked) {
        crudOptions.style.display = 'block';
        nameField.required = false;
        codeField.required = false;
        nameField.disabled = true;
        codeField.disabled = true;
    } else {
        crudOptions.style.display = 'none';
        nameField.required = true;
        codeField.required = true;
        nameField.disabled = false;
        codeField.disabled = false;
    }
});

function updateCrudPreview() {
    const resourceName = document.getElementById('resource_name').value || 'Resource';
    const resourceCode = document.getElementById('resource_code').value || 'resource';
    
    document.querySelectorAll('.resource-display').forEach(el => {
        el.textContent = resourceName;
    });
    
    const preview = document.getElementById('crud_preview');
    preview.innerHTML = `
        <div>• Lihat ${resourceName} (${resourceCode}.read)</div>
        <div>• Tambah ${resourceName} (${resourceCode}.create)</div>
        <div>• Edit ${resourceName} (${resourceCode}.update)</div>
        <div>• Hapus ${resourceName} (${resourceCode}.delete)</div>
    `;
}

document.getElementById('resource_name').addEventListener('input', updateCrudPreview);
document.getElementById('resource_code').addEventListener('input', updateCrudPreview);
</script>
@endsection
