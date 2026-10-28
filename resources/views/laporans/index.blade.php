@extends('layouts.app')
@section('title', 'Daftar Laporan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Daftar Laporan Banjir</h4>
    <span class="text-muted small">Total {{ $laporans->total() }} laporan</span>
</div>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Foto</th>
                    <th>Pelapor</th>
                    <th>Lokasi</th>
                    <th>Tinggi Air</th>
                    <th>Status</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse($laporans as $laporan)
                <tr>
                    <td>{{ $laporans->firstItem() + $loop->index }}</td>
                    <td>
                        @if($laporan->foto)
                            <img src="{{ asset('storage/' . $laporan->foto) }}" alt="Foto"
                                 class="rounded" style="width:64px;height:64px;object-fit:cover;">
                        @else
                            <div class="bg-secondary-subtle text-muted small rounded d-flex align-items-center justify-content-center"
                                 style="width:64px;height:64px;">Tanpa foto</div>
                        @endif
                    </td>
                    <td>{{ $laporan->nama_pelapor }}<br><small class="text-muted">{{ $laporan->no_hp }}</small></td>
                    <td>{{ $laporan->lokasi }}<br><small class="text-muted">Kec. {{ $laporan->kecamatan }}</small></td>
                    <td>{{ $laporan->tinggi_air }} cm</td>
                    <td><span class="badge {{ $laporan->badgeClass() }}">{{ $laporan->status }}</span></td>
                    <td class="text-end text-nowrap">
                        <a href="{{ route('laporans.show', $laporan) }}" class="btn btn-sm btn-info">Detail</a>
                        <a href="{{ route('laporans.edit', $laporan) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('laporans.destroy', $laporan) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Hapus laporan ini beserta fotonya?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center text-muted py-4">Belum ada laporan.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $laporans->links() }}</div>
@endsection
