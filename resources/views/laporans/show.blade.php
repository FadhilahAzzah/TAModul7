@extends('layouts.app')
@section('title', 'Detail Laporan')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-9">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Detail Laporan #{{ $laporan->id }}</span>
                <span class="badge {{ $laporan->badgeClass() }}">{{ $laporan->status }}</span>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        @if($laporan->foto)
                            <img src="{{ asset('storage/' . $laporan->foto) }}" alt="Foto bukti" class="img-fluid rounded">
                        @else
                            <div class="bg-secondary-subtle text-muted rounded d-flex align-items-center justify-content-center"
                                 style="height:200px;">Tidak ada foto</div>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <table class="table table-sm">
                            <tr><th style="width:40%">Pelapor</th><td>{{ $laporan->nama_pelapor }}</td></tr>
                            <tr><th>No. HP</th><td>{{ $laporan->no_hp }}</td></tr>
                            <tr><th>Lokasi</th><td>{{ $laporan->lokasi }}</td></tr>
                            <tr><th>Kecamatan</th><td>{{ $laporan->kecamatan }}</td></tr>
                            <tr><th>Tinggi air</th><td>{{ $laporan->tinggi_air }} cm</td></tr>
                            <tr><th>Keterangan</th><td>{{ $laporan->keterangan ?? '-' }}</td></tr>
                            <tr><th>Dilaporkan</th><td>{{ $laporan->created_at->format('d M Y, H:i') }}</td></tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('laporans.index') }}" class="btn btn-secondary">Kembali</a>
                <a href="{{ route('laporans.edit', $laporan) }}" class="btn btn-warning">Edit</a>
            </div>
        </div>
    </div>
</div>
@endsection
