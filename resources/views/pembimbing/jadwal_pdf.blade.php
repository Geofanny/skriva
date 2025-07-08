<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; text-align: center; padding: 6px; font-size: 12px; }
        th { background-color: #0e7490; color: white; }
        .bimbingan { background-color: #bbf7d0; } /* Warna hijau muda */
    </style>
</head>
<body>

    <h2 style="text-align:center">
        Jadwal Bimbingan Bulan {{ \Carbon\Carbon::create($tahun, $bulan, 1)->locale('id')->isoFormat('MMMM') }} Tahun {{ $tahun }}
    </h2>    

    @php
        $hariDalamBulan = \Carbon\Carbon::create($tahun, $bulan, 1)->daysInMonth;

        // Kelompokkan data berdasarkan mahasiswa dan tanggal
        $dataBimbingan = [];
        foreach ($jadwal as $item) {
            $tanggal = \Carbon\Carbon::parse($item->tgl_ajuan)->format('j'); // tanpa leading zero
            $dataBimbingan[$item->nama_mahasiswa][$tanggal] = \Carbon\Carbon::parse($item->waktu_mulai)->format('H:i') . ' - ' . \Carbon\Carbon::parse($item->waktu_selesai)->format('H:i');
        }
    @endphp

    <table>
        <thead>
            <tr>
                <th>Nama Mahasiswa</th>
                @for($i = 1; $i <= $hariDalamBulan; $i++)
                    <th>{{ $i }}</th>
                @endfor
            </tr>
        </thead>
        <tbody>
            @foreach($dataBimbingan as $nama => $bimbingan)
                <tr>
                    <td style="text-align: left;">{{ $nama }}</td>
                    @for($i = 1; $i <= $hariDalamBulan; $i++)
                        @php $ada = isset($bimbingan[$i]); @endphp
                        <td class="{{ $ada ? 'bimbingan' : '' }}">
                            {{ $bimbingan[$i] ?? '' }}
                        </td>
                    @endfor
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
