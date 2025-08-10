<html>
<head>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #222; }
        .header { text-align: center; margin-bottom: 20px; }
        .clinic-title { font-size: 18px; font-weight: bold; letter-spacing: 1px; }
        .clinic-info { font-size: 12px; color: #555; margin-bottom: 8px; }
        .divider { border-bottom: 2px solid #0e7490; margin: 10px 0 18px 0; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .table th, .table td { border: 1px solid #b6c2d1; padding: 5px 7px; font-size: 10.5px; }
        .table th { background: #e0f2fe; color: #0e7490; }
        .table td { background: #fff; }
    </style>
</head>
<body>
    <div class="header">
        <div class="clinic-title">KLINIK SEHAT</div>
        <div class="clinic-info">Jl. Braga, No 100, Kota Bandung | Telp: (021) 12345678</div>
        <div class="divider"></div>
        <div style="font-size:15px; font-weight:bold; color:#0e7490;">DAFTAR PEMBAYARAN PASIEN</div>
        <div style="font-size:12px;">Dicetak: {{ now()->format('d/m/Y H:i') }}</div>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>No. Pembayaran</th>
                <th>Tanggal</th>
                <th>Pasien</th>
                <th>Kasir</th>
                <th>Total Tagihan</th>
                <th>Dibayar</th>
                <th>Kembalian</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
        @foreach($pembayarans as $i => $p)
            <tr>
                <td style="text-align:center">{{ $i+1 }}</td>
                <td>{{ $p->no_pembayaran }}</td>
                <td>{{ $p->tanggal_pembayaran ? $p->tanggal_pembayaran->format('d/m/Y H:i') : '-' }}</td>
                <td>{{ $p->kunjungan->pasien->nama ?? '-' }}</td>
                <td>{{ $p->kasir->nama ?? '-' }}</td>
                <td style="text-align:right">Rp {{ number_format($p->total_tagihan,0,',','.') }}</td>
                <td style="text-align:right">Rp {{ number_format($p->jumlah_dibayar,0,',','.') }}</td>
                <td style="text-align:right">Rp {{ number_format($p->kembalian,0,',','.') }}</td>
                <td style="text-align:center">{{ ucfirst($p->status) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>
