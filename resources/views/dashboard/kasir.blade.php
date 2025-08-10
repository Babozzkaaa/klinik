@extends('layouts.app')
@section('title', 'Dashboard Kasir')
@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-4">Selamat Datang, {{ auth()->user()->name }} (Kasir)</h1>
    <div class="bg-white rounded shadow p-6">
        <ul class="list-disc ml-6">
            <li>Proses pembayaran pasien</li>
            <li>Lihat data pasien, kunjungan, tindakan, obat</li>
            <li>Lihat & export laporan pembayaran</li>
        </ul>
    </div>
</div>
@endsection
