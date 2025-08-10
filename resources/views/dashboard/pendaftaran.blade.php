@extends('layouts.app')
@section('title', 'Dashboard Petugas Pendaftaran')
@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-4">Selamat Datang, {{ auth()->user()->name }} (Petugas Pendaftaran)</h1>
    <div class="bg-white rounded shadow p-6">
        <ul class="list-disc ml-6">
            <li>Input & edit data pasien</li>
            <li>Daftarkan kunjungan pasien</li>
            <li>Lihat data master (provinsi, kabupaten, pegawai, tindakan, obat)</li>
        </ul>
    </div>
</div>
@endsection
