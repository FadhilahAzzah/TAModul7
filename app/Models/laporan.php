<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $table = 'laporans';

    protected $fillable = [
        'nama_pelapor',
        'no_hp',
        'lokasi',
        'kecamatan',
        'tinggi_air',
        'keterangan',
        'foto',
        'status',
    ];

    public const STATUS = ['Menunggu', 'Diproses', 'Selesai'];

    public const KECAMATAN = [
        'Baleendah', 'Banjaran', 'Bojongsoang', 'Cileunyi', 'Dayeuhkolot',
        'Katapang', 'Majalaya', 'Margahayu', 'Pameungpeuk', 'Rancaekek',
    ];

    /** Warna badge Bootstrap berdasarkan status. */
    public function badgeClass(): string
    {
        return match ($this->status) {
            'Diproses' => 'bg-warning text-dark',
            'Selesai'  => 'bg-success',
            default    => 'bg-secondary',
        };
    }
}
