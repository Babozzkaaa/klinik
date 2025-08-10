@extends('layouts.app')

@section('title', 'Tambah Role')

@section('content')
<div class="container mx-auto px-4 py-6">
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('admin.roles.index') }}" class="text-blue-600 hover:text-blue-800">
                    <i class="fas fa-user-tag mr-2"></i>
                    Manajemen Role
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <span class="text-gray-500">Tambah Role</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="max-w-4xl mx-auto">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="bg-blue-600 px-6 py-4">
                <h3 class="text-lg font-medium text-white flex items-center">
                    <i class="fas fa-plus-circle mr-2"></i>
                    Tambah Role Baru
                </h3>
            </div>
            
            <form action="{{ route('admin.roles.store') }}" method="POST" class="p-6">
                @csrf
                
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama Role</label>
                        <input type="text" name="name" id="name" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            value="{{ old('name') }}" placeholder="Contoh: Manager, Staff, etc.">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">Permission</label>
                        <div class="border border-gray-300 rounded-md p-4 max-h-96 overflow-y-auto">
                            @if($groupedPermissions->count() > 0)
                                @foreach($groupedPermissions as $sectionName => $permissions)
                                <div class="mb-6 last:mb-0">
                                    <div class="flex items-center justify-between mb-3 p-3 bg-gray-50 rounded-lg">
                                        <div class="flex items-center">
                                            <input type="checkbox" class="section-select-all h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded mr-3" data-section="{{ $sectionName }}">
                                            <h4 class="text-sm font-semibold text-gray-800 flex items-center">
                                                <i class="fas fa-folder-open text-blue-600 mr-2"></i>
                                                {{ $sectionName }}
                                            </h4>
                                        </div>
                                        <div class="flex space-x-2">
                                            <button type="button" class="select-crud-section text-xs bg-green-100 text-green-700 px-2 py-1 rounded hover:bg-green-200" data-section="{{ $sectionName }}">
                                                <i class="fas fa-edit mr-1"></i>CRUD
                                            </button>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2 pl-6">
                                        @foreach($permissions as $permission)
                                        <div class="flex items-center permission-item" data-section="{{ $sectionName }}" data-action="{{ $permission->action }}">
                                            <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="permission_{{ $permission->id }}"
                                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                                {{ collect(old('permissions'))->contains($permission->id) ? 'checked' : '' }}>
                                            <label for="permission_{{ $permission->id }}" class="ml-2 flex-1">
                                                <div class="text-sm text-gray-900">{{ $permission->name }}</div>
                                                <div class="text-xs text-gray-500 font-mono">{{ $permission->code }}</div>
                                            </label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <p class="text-gray-500 text-center py-4">
                                    <i class="fas fa-info-circle mr-2"></i>
                                    Belum ada permission tersedia. 
                                    <a href="{{ route('admin.permissions.create') }}" class="text-blue-600 hover:text-blue-800">Tambah permission</a> terlebih dahulu.
                                </p>
                            @endif
                        </div>
                        @error('permissions')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3 mt-6 pt-6 border-t">
                    <a href="{{ route('admin.roles.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-md">
                        <i class="fas fa-times mr-2"></i>Batal
                    </a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md">
                        <i class="fas fa-save mr-2"></i>Simpan Role
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.section-select-all').forEach(selectAllCheckbox => {
        selectAllCheckbox.addEventListener('change', function() {
            const section = this.dataset.section;
            const sectionCheckboxes = document.querySelectorAll(`[data-section="${section}"] input[type="checkbox"]:not(.section-select-all)`);
            
            sectionCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
    });

    document.querySelectorAll('.permission-item input[type="checkbox"]').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const section = this.closest('[data-section]').dataset.section;
            const sectionCheckboxes = document.querySelectorAll(`[data-section="${section}"] input[type="checkbox"]:not(.section-select-all)`);
            const selectAllCheckbox = document.querySelector(`.section-select-all[data-section="${section}"]`);
            
            const allChecked = Array.from(sectionCheckboxes).every(cb => cb.checked);
            const someChecked = Array.from(sectionCheckboxes).some(cb => cb.checked);
            
            if (allChecked) {
                selectAllCheckbox.checked = true;
                selectAllCheckbox.indeterminate = false;
            } else if (someChecked) {
                selectAllCheckbox.checked = false;
                selectAllCheckbox.indeterminate = true;
            } else {
                selectAllCheckbox.checked = false;
                selectAllCheckbox.indeterminate = false;
            }
        });
    });

    document.querySelectorAll('.select-crud-section').forEach(button => {
        button.addEventListener('click', function() {
            const section = this.dataset.section;
            const crudActions = ['read', 'create', 'update', 'delete'];
            
            document.querySelectorAll(`[data-section="${section}"] input[type="checkbox"]:not(.section-select-all)`).forEach(checkbox => checkbox.checked = false);
            
            crudActions.forEach(action => {
                const checkbox = document.querySelector(`[data-section="${section}"][data-action="${action}"] input[type="checkbox"]`);
                if (checkbox) checkbox.checked = true;
            });

            const sectionCheckboxes = document.querySelectorAll(`[data-section="${section}"] input[type="checkbox"]:not(.section-select-all)`);
            const selectAllCheckbox = document.querySelector(`.section-select-all[data-section="${section}"]`);
            const someChecked = Array.from(sectionCheckboxes).some(cb => cb.checked);
            const allChecked = Array.from(sectionCheckboxes).every(cb => cb.checked);
            
            if (allChecked) {
                selectAllCheckbox.checked = true;
                selectAllCheckbox.indeterminate = false;
            } else if (someChecked) {
                selectAllCheckbox.checked = false;
                selectAllCheckbox.indeterminate = true;
            }
        });
    });
});
</script>
@endsection
