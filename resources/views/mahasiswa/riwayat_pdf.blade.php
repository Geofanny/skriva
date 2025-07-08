<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Riwayat Bimbingan</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 14px;
            padding: 20px;
        }
        .biodata-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        .biodata-text p {
            margin: 4px 0;
        }
        .foto {
            width: 120px;
            height: 130px;
            border: 1px solid #000;
            overflow: hidden;
            margin-bottom: 7px;
        }
        .foto img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .line {
            border-top: 2px solid #000;
            margin: 15px 0;
        }
        h3 {
            margin: 15px 0 10px 0;
            font-size: 16px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
            font-size: 12px;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }
        th {
            background-color: #0e7490;
            color: white;
        }
    </style>
</head>
<body>

    <div class="biodata-container">
        <div class="foto">
            <img src="{{ $mahasiswa->foto ? asset('storage/fotoProfil/' . $mahasiswa->foto) : 'https://www.gravatar.com/avatar/?d=mp&s=100' }}" alt="Foto Mahasiswa">
        </div>
        <div class="biodata-text">
            <p><strong>Nama:</strong> {{ $mahasiswa->nama }}</p>
            <p><strong>NPM:</strong> {{ $mahasiswa->npm }}</p>
            <p><strong>Program Studi:</strong> {{ $mahasiswa->nama_prodi }}</p>
        </div>
    </div>

    <div class="line"></div>

    <h3>Riwayat Ajuan Bimbingan</h3>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Topik</th>
                <th>Pembimbing</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Komentar</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($riwayat as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->topik }}</td>
                    <td>{{ $item->nama_pembimbing }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tgl_ajuan)->translatedFormat('d F Y') }}</td>
                    <td>{{ ucfirst($item->status) }}</td>
                    <td>{{ $item->komentar_penolakan ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
