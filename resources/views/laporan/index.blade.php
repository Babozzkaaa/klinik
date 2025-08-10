@extends('layouts.app')

@section('title', 'Laporan Klinik')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6">Laporan Visualisasi Data Klinik</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="bg-white rounded shadow p-4">
            <h2 class="font-semibold mb-2">Jumlah Kunjungan Pasien per Hari (30 Hari Terakhir)</h2>
            <canvas id="chartKunjunganHari"></canvas>
        </div>
        <div class="bg-white rounded shadow p-4">
            <h2 class="font-semibold mb-2">Jumlah Kunjungan Pasien per Bulan (12 Bulan Terakhir)</h2>
            <canvas id="chartKunjunganBulan"></canvas>
        </div>
        <div class="bg-white rounded shadow p-4 md:">
            <h2 class="font-semibold mb-2">10 Jenis Tindakan Terbanyak</h2>
            <canvas id="chartTindakan"></canvas>
        </div>
        <div class="bg-white rounded shadow p-4 md:">
            <h2 class="font-semibold mb-2">10 Obat Paling Sering Diresepkan</h2>
            <canvas id="chartObat"></canvas>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const kunjunganHariLabels = @json($kunjunganPerHari->pluck('tanggal'));
const kunjunganHariData = @json($kunjunganPerHari->pluck('jumlah'));
const kunjunganBulanLabels = @json($kunjunganPerBulan->pluck('bulan'));
const kunjunganBulanData = @json($kunjunganPerBulan->pluck('jumlah'));
const tindakanLabels = @json($tindakanTerbanyak->pluck('tindakan.nama'));
const tindakanData = @json($tindakanTerbanyak->pluck('total'));
const obatLabels = @json($obatTerbanyak->pluck('obat.nama_obat'));
const obatData = @json($obatTerbanyak->pluck('total'));

new Chart(document.getElementById('chartKunjunganHari'), {
    type: 'bar',
    data: {
        labels: kunjunganHariLabels,
        datasets: [{
            label: 'Jumlah Kunjungan',
            data: kunjunganHariData,
            backgroundColor: '#0ea5e9',
        }]
    },
    options: {responsive: true, plugins: {legend: {display: false}}}
});

new Chart(document.getElementById('chartKunjunganBulan'), {
    type: 'line',
    data: {
        labels: kunjunganBulanLabels,
        datasets: [{
            label: 'Jumlah Kunjungan',
            data: kunjunganBulanData,
            borderColor: '#0ea5e9',
            backgroundColor: 'rgba(14,165,233,0.1)',
            fill: true,
        }]
    },
    options: {responsive: true, plugins: {legend: {display: false}}}
});

new Chart(document.getElementById('chartTindakan'), {
    type: 'bar',
    data: {
        labels: tindakanLabels,
        datasets: [{
            label: 'Jumlah',
            data: tindakanData,
            backgroundColor: '#38bdf8',
        }]
    },
    options: {responsive: true, plugins: {legend: {display: false}}}
});

new Chart(document.getElementById('chartObat'), {
    type: 'bar',
    data: {
        labels: obatLabels,
        datasets: [{
            label: 'Jumlah',
            data: obatData,
            backgroundColor: '#fbbf24',
        }]
    },
    options: {responsive: true, plugins: {legend: {display: false}}}
});
</script>
@endpush
