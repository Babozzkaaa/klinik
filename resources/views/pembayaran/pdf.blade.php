@php
    $pasien = $pembayaran->kunjungan->pasien;
    $kunjungan = $pembayaran->kunjungan;
@endphp
<html>
<head>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .table th, .table td { border: 1px solid #333; padding: 6px; }
        .table th { background: #eee; }
    </style>
</head>
<body>
    @php
        $pasien = $pembayaran->kunjungan->pasien;
        $kunjungan = $pembayaran->kunjungan;
        $klinik_nama = 'KLINIK SEHAT';
        $klinik_alamat = 'Jl. Braga, No 100';
        $klinik_telp = '(021) 12345678';
    @endphp
    <html>
    <head>
        <style>
            body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #222; }
            .header { text-align: center; margin-bottom: 18px; }
            .logo { width: 60px; height: 60px; margin-bottom: 8px; }
            .clinic-title { font-size: 20px; font-weight: bold; letter-spacing: 1px; }
            .clinic-info { font-size: 12px; color: #555; margin-bottom: 8px; }
            .divider { border-bottom: 2px solid #0e7490; margin: 10px 0 18px 0; }
            .main-table { width: 100%; border-collapse: collapse; margin-bottom: 18px; }
            .main-table th, .main-table td { padding: 6px 8px; }
            .main-table th { text-align: left; width: 38%; color: #0e7490; background: #f0f9ff; }
            .main-table td { background: #f8fafc; }
            .section-title { font-size: 14px; font-weight: bold; color: #0e7490; margin: 18px 0 6px 0; }
            .data-table { width: 100%; border-collapse: collapse; margin-bottom: 12px; }
            .data-table th, .data-table td { border: 1px solid #b6c2d1; padding: 5px 7px; font-size: 11px; }
            .data-table th { background: #e0f2fe; color: #0e7490; }
            .data-table td { background: #fff; }
            .summary-table { width: 60%; margin-top: 10px; border-collapse: collapse; }
            .summary-table th, .summary-table td { padding: 6px 8px; font-size: 12px; }
            .summary-table th { text-align: left; background: #f0f9ff; color: #0e7490; }
            .summary-table td { background: #f8fafc; }
            .footer { margin-top: 32px; text-align: right; font-size: 12px; }
            .ttd { margin-top: 48px; text-align: right; font-size: 12px; }
        </style>
    </head>
    <body>
        <div class="header">
            {{-- <img src="{{ public_path('logo.png') }}" class="logo"> --}}
            <div class="clinic-title">{{ $klinik_nama }}</div>
            <div class="clinic-info">{{ $klinik_alamat }} | Telp: {{ $klinik_telp }}</div>
            <div class="divider"></div>
            <div style="font-size:16px; font-weight:bold; margin-bottom:2px; color:#0e7490;">BUKTI PEMBAYARAN</div>
            <div style="font-size:13px;">No. Pembayaran: <strong>{{ $pembayaran->no_pembayaran }}</strong></div>
            <div style="font-size:12px;">Tanggal: {{ $pembayaran->tanggal_pembayaran->format('d/m/Y H:i') }}</div>
        </div>
        <table class="main-table">
            <tr><th>Nama Pasien</th><td>{{ $pasien->nama }}</td></tr>
            <tr><th>Tanggal Kunjungan</th><td>{{ $kunjungan->tanggal_kunjungan->format('d/m/Y H:i') }}</td></tr>
            <tr><th>Kasir</th><td>{{ $pembayaran->kasir->nama }}</td></tr>
            <tr><th>Metode Pembayaran</th><td>{{ ucfirst($pembayaran->metode_pembayaran) }}</td></tr>
            <tr><th>Status</th><td>{{ ucfirst($pembayaran->status) }}</td></tr>
        </table>

        <div class="section-title">Detail Tindakan</div>
        <table class="data-table">
            <thead>
                <tr><th>Nama Tindakan</th><th>Jumlah</th><th>Subtotal</th></tr>
            </thead>
            <tbody>
            @forelse($kunjungan->kunjunganTindakan as $item)
                <tr>
                    <td>{{ $item->tindakan->nama_tindakan }}</td>
                    <td style="text-align:center">{{ $item->jumlah }}</td>
                    <td style="text-align:right">Rp {{ number_format($item->subtotal,0,',','.') }}</td>
                </tr>
            @empty
                <tr><td colspan="3" style="text-align:center">-</td></tr>
            @endforelse
            </tbody>
        </table>

        <div class="section-title">Detail Obat</div>
        <table class="data-table">
            <thead>
                <tr><th>Nama Obat</th><th>Jumlah</th><th>Subtotal</th></tr>
            </thead>
            <tbody>
            @forelse($kunjungan->kunjunganObat as $item)
                <tr>
                    <td>{{ $item->obat->nama_obat }}</td>
                    <td style="text-align:center">{{ $item->jumlah }}</td>
                    <td style="text-align:right">Rp {{ number_format($item->subtotal,0,',','.') }}</td>
                </tr>
            @empty
                <tr><td colspan="3" style="text-align:center">-</td></tr>
            @endforelse
            </tbody>
        </table>

        <table class="summary-table">
            <tr><th>Total Tagihan</th><td style="text-align:right">Rp {{ number_format($pembayaran->total_tagihan,0,',','.') }}</td></tr>
            <tr><th>Jumlah Dibayar</th><td style="text-align:right">Rp {{ number_format($pembayaran->jumlah_dibayar,0,',','.') }}</td></tr>
            <tr><th>Kembalian</th><td style="text-align:right">Rp {{ number_format($pembayaran->kembalian,0,',','.') }}</td></tr>
        </table>

        @if($pembayaran->catatan)
            <div style="margin-top:10px; font-size:12px;"><strong>Catatan:</strong> {{ $pembayaran->catatan }}</div>
        @endif

        <div class="footer">
            <div>Kota Bandung, {{ $pembayaran->tanggal_pembayaran->format('d F Y') }}</div>
        </div>
        <div class="ttd">
            <div>Kasir,</div>
            <div style="margin-top:48px; font-weight:bold;">{{ $pembayaran->kasir->nama }}</div>
        </div>
    </body>
    </html>
