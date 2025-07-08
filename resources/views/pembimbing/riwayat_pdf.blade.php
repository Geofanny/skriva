<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: center; }
        th { background-color: #ddd; }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Laporan Riwayat Ajuan Bimbingan</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Topik</th>
                <th>Mahasiswa</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Komentar</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bimbingan as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->topik }}</td>
                <td>{{ $item->nama_mahasiswa }}</td>
                <td>{{ $item->tgl_ajuan }}</td>
                <td>{{ $item->status }}</td>
                <td>{{ $item->komentar_penolakan }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
