@extends('layouts.app')
@section('title', 'Edit Laporan')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header">Edit Laporan #{{ $laporan->id }}</div>
            <div class="card-body">
                <form method="POST" action="{{ route('laporans.update', $laporan) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nama_pelapor" class="form-label">Nama Pelapor</label>
                            <input id="nama_pelapor" type="text" name="nama_pelapor"
                                   value="{{ old('nama_pelapor', $laporan->nama_pelapor) }}"
                                   class="form-control @error('nama_pelapor') is-invalid @enderror">
                            @error('nama_pelapor')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="no_hp" class="form-label">No. HP</label>
                            <input id="no_hp" type="text" name="no_hp" value="{{ old('no_hp', $laporan->no_hp) }}"
                                   class="form-control @error('no_hp') is-invalid @enderror">
                            @error('no_hp')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="lokasi" class="form-label">Lokasi</label>
                        <input id="lokasi" type="text" name="lokasi" value="{{ old('lokasi', $laporan->lokasi) }}"
                               class="form-control @error('lokasi') is-invalid @enderror">
                        @error('lokasi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="kecamatan" class="form-label">Kecamatan</label>
                            <select id="kecamatan" name="kecamatan"
                                    class="form-select @error('kecamatan') is-invalid @enderror">
                                @foreach(\App\Models\Laporan::KECAMATAN as $k)
                                    <option value="{{ $k }}" @selected(old('kecamatan', $laporan->kecamatan) === $k)>{{ $k }}</option>
                                @endforeach
                            </select>
                            @error('kecamatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tinggi_air" class="form-label">Tinggi Air (cm)</label>
                            <input id="tinggi_air" type="number" name="tinggi_air"
                                   value="{{ old('tinggi_air', $laporan->tinggi_air) }}"
                                   class="form-control @error('tinggi_air') is-invalid @enderror">
                            @error('tinggi_air')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea id="keterangan" name="keterangan" rows="3"
                                  class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan', $laporan->keterangan) }}</textarea>
                        @error('keterangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status Penanganan</label>
                        <select id="status" name="status" class="form-select @error('status') is-invalid @enderror">
                            @foreach(\App\Models\Laporan::STATUS as $s)
                                <option value="{{ $s }}" @selected(old('status', $laporan->status) === $s)>{{ $s }}</option>
                            @endforeach
                        </select>
                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label d-block">Foto saat ini</label>
                        @if($laporan->foto)
                            <img src="{{ asset('storage/' . $laporan->foto) }}" alt="Foto"
                                 class="rounded mb-2" style="max-height:160px;">
                        @else
                            <p class="text-muted">Belum ada foto.</p>
                        @endif
                        <label for="foto" class="form-label d-block">Ganti foto (opsional, jpg/jpeg/png, maks. 2 MB)</label>
                        <input id="foto" type="file" name="foto" accept=".jpg,.jpeg,.png"
                               class="form-control @error('foto') is-invalid @enderror">
                        @error('foto')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="{{ route('laporans.show', $laporan) }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
