<table class="min-w-full divide-y divide-gray-200 text-sm print:text-xs print:table-fixed">
    <thead class="bg-cyan-700 text-white">
        <tr>
            <th class="px-4 py-3 text-left font-semibold">Tanggal</th>
            <th class="px-4 py-3 text-left font-semibold">Prodi</th>
            <th class="px-4 py-3 text-left font-semibold">Mahasiswa</th>
            <th class="px-4 py-3 text-left font-semibold">Pembimbing</th>
            <th class="px-4 py-3 text-left font-semibold">Topik Bimbingan</th>
            <th class="px-4 py-3 text-left font-semibold">Jam</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-100 print:divide-gray-300">
        @forelse ($results as $sesi)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3">{{ \Carbon\Carbon::parse($sesi->tgl_ajuan)->format('Y-m-d') }}</td>
                <td class="px-4 py-3">{{ $sesi->nama_prodi ?? '-' }}</td>
                <td class="px-4 py-3">{{ $sesi->nama }}<br><span class="text-xs text-gray-500">{{ $sesi->npm }}</span></td>
                <td class="px-4 py-3">{{ $sesi->nama_pembimbing ?? '-' }}</td>
                <td class="px-4 py-3">{{ $sesi->topik }}</td>
                <td class="px-4 py-3 space-x-1">
                    <span class="inline-block bg-green-100 text-green-700 text-xs font-semibold px-2 py-1 rounded">
                        {{ \Carbon\Carbon::parse($sesi->waktu_mulai)->format('H:i') }}
                    </span>
                    <span class="inline-block bg-red-100 text-red-700 text-xs font-semibold px-2 py-1 rounded">
                        {{ \Carbon\Carbon::parse($sesi->waktu_selesai)->format('H:i') }}
                    </span>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center text-gray-500 py-4">Tidak ada data bimbingan.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="mt-4">
    {{ $results->links() }}
</div>
