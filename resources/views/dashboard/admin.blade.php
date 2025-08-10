@extends('layouts.app')
@section('title', 'Dashboard Admin')
@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-4">Selamat Datang, {{ auth()->user()->name }} (Admin)</h1>
    <div class="bg-white rounded shadow p-6">
        <ul class="list-disc ml-6">
            <li>Manajemen seluruh data master, transaksi, laporan, user, role, permission</li>
            <li>Akses penuh ke semua fitur sistem</li>
        </ul>
    </div>
</div>
@endsection
