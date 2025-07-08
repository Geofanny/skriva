<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Monitoring Bimbingan</title>
    <style>
        body {
            font-family: "Times New Roman", serif;
            font-size: 14px;
            margin: 40px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
            font-size: 20px;
        }
        .header p {
            margin: 2px 0;
        }
        .line {
            border-bottom: 2px solid black;
            margin-top: 8px;
            margin-bottom: 16px;
        }
        .subinfo {
            display: flex;
            justify-content: center;
            gap: 60px;
            margin-top: 10px;
            font-weight: bold;
            font-size: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #e4e4e4;
        }
        .footer {
            margin-top: 60px;
            width: 100%;
        }
        .ttd {
            float: right;
            text-align: center;
            margin-top: 40px;
            font-size: 14px;
        }
    </style>
</head>
<body>

    {{-- HEADER UNIVERSITAS --}}
    <div class="header">
        <h2>UNIVERSITAS TEKNOLOGI NUSANTARA</h2>
        <p class="capitalize">Fakultas {{ $koordinasi->fakultas }}</p>
        <p>Jl. Pendidikan No. 123, Kota Ilmu, Indonesia</p>
        <div class="line"></div>
        <h3 style="margin-top: 20px;">LAPORAN MONITORING BIMBINGAN SKRIPSI</h3>

        @php
            switch ($bulan) {
                case '01': $namaBulan = 'Januari'; break;
                case '02': $namaBulan = 'Februari'; break;
                case '03': $namaBulan = 'Maret'; break;
                case '04': $namaBulan = 'April'; break;
                case '05': $namaBulan = 'Mei'; break;
                case '06': $namaBulan = 'Juni'; break;
                case '07': $namaBulan = 'Juli'; break;
                case '08': $namaBulan = 'Agustus'; break;
                case '09': $namaBulan = 'September'; break;
                case '10': $namaBulan = 'Oktober'; break;
                case '11': $namaBulan = 'November'; break;
                case '12': $namaBulan = 'Desember'; break;
                default: $namaBulan = 'Tidak diketahui'; break;
            }
        @endphp


        {{-- Informasi Bulan & Tahun --}}
        <div class="subinfo">
            <span>Bulan: {{ $namaBulan }}</span>
            <span>Tahun: {{ $tahun }}</span>
        </div>
    </div>

    {{-- TABEL DATA --}}
    <table>
        <thead>
            <tr>
                <th style="width: 12%;">Tanggal</th>
                <th style="width: 18%;">Program Studi</th>
                <th style="width: 22%;">Mahasiswa</th>
                <th style="width: 20%;">Pembimbing</th>
                <th style="width: 18%;">Topik</th>
                <th style="width: 10%;">Jam</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($sesiBimbingan as $sesi)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($sesi->tgl_ajuan)->format('d-m-Y') }}</td>
                    <td>{{ $sesi->nama_prodi }}</td>
                    <td>{{ $sesi->nama }}<br><small>({{ $sesi->npm }})</small></td>
                    <td>{{ $sesi->nama_pembimbing ?? '-' }}</td>
                    <td>{{ $sesi->topik }}</td>
                    <td>{{ \Carbon\Carbon::parse($sesi->waktu_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($sesi->waktu_selesai)->format('H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">Tidak ada data bimbingan</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- TANDA TANGAN --}}
    <div class="footer">
        <div class="ttd">
            <p>Koordinator Bimbingan</p>
            <br><br><br>
            <p class="capitalize"><strong><u>{{ $koordinasi->nama }}</u></strong></p>
            <p>NIP. {{ $koordinasi->nip }}</p>
        </div>
    </div>

</body>
</html>
