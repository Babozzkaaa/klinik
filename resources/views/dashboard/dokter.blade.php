@extends('layouts.app')
@section('title', 'Dashboard Dokter')
@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-4">Selamat Datang, {{ auth()->user()->name }} (Dokter)</h1>
    <div class="bg-white rounded shadow p-6">
        <ul class="list-disc ml-6">
            <li>Lihat & input tindakan kunjungan pasien</li>
            <li>Lihat & resepkan obat</li>
            <li>Lihat riwayat pasien</li>
        </ul>
    </div>
</div>
@endsection
