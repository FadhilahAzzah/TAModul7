<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class LaporanController extends Controller
{
    /** Aturan validasi untuk data utama laporan. */
    private function aturanDasar(): array
    {
        return [
            'nama_pelapor' => 'required|string|max:255',
            'no_hp'        => 'required|string|max:20',
            'lokasi'       => 'required|string|max:255',
            'kecamatan'    => ['required', Rule::in(Laporan::KECAMATAN)],
            'tinggi_air'   => 'required|integer|min:1|max:1000',
            'keterangan'   => 'nullable|string|max:1000',
        ];
    }

    private function pesan(): array
    {
        return [
            'foto.required' => 'Foto bukti wajib diunggah.',
            'foto.image'    => 'File harus berupa gambar.',
            'foto.mimes'    => 'Foto harus berformat jpg, jpeg, atau png.',
            'foto.max'      => 'Ukuran foto maksimal 2 MB.',
            'foto.uploaded' => 'Foto gagal diunggah. Pastikan ukurannya maksimal 2 MB.',
        ];
    }

    /** [PETUGAS] Daftar laporan + thumbnail + pagination. */
    public function index(): View
    {
        $laporans = Laporan::latest()->paginate(5);

        return view('laporans.index', compact('laporans'));
    }

    /** [PUBLIK] Form pelaporan warga. */
    public function create(): View
    {
        return view('laporans.create');
    }

    /** [PUBLIK] Simpan laporan baru beserta foto. */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate(
            $this->aturanDasar() + ['foto' => 'required|image|mimes:jpg,jpeg,png|max:2048'],
            $this->pesan()
        );

        // Simpan file ke storage/app/public/foto_laporan, database hanya menyimpan path-nya
        $validated['foto'] = $request->file('foto')->store('foto_laporan', 'public');

        Laporan::create($validated); // status otomatis "Menunggu" (default migration)

        $tujuan = Auth::check() ? 'laporans.index' : 'laporans.create';

        return redirect()->route($tujuan)
            ->with('success', 'Laporan berhasil dikirim. Terima kasih, petugas BPBD akan segera menindaklanjuti.');
    }

    /** [PETUGAS] Detail laporan. */
    public function show(Laporan $laporan): View
    {
        return view('laporans.show', compact('laporan'));
    }

    /** [PETUGAS] Form edit. */
    public function edit(Laporan $laporan): View
    {
        return view('laporans.edit', compact('laporan'));
    }

    /** [PETUGAS] Simpan perubahan; foto lama dihapus jika diganti. */
    public function update(Request $request, Laporan $laporan): RedirectResponse
    {
        $validated = $request->validate(
            $this->aturanDasar() + [
                'status' => ['required', Rule::in(Laporan::STATUS)],
                'foto'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ],
            $this->pesan()
        );

        if ($request->hasFile('foto')) {
            if ($laporan->foto) {
                Storage::disk('public')->delete($laporan->foto); // hapus foto lama
            }
            $validated['foto'] = $request->file('foto')->store('foto_laporan', 'public');
        } else {
            unset($validated['foto']); // tidak ada foto baru, pertahankan yang lama
        }

        $laporan->update($validated);

        return redirect()->route('laporans.show', $laporan)
            ->with('success', 'Laporan berhasil diperbarui.');
    }

    /** [PETUGAS] Hapus laporan beserta fotonya. */
    public function destroy(Laporan $laporan): RedirectResponse
    {
        if ($laporan->foto) {
            Storage::disk('public')->delete($laporan->foto);
        }

        $laporan->delete();

        return redirect()->route('laporans.index')
            ->with('success', 'Laporan beserta foto buktinya berhasil dihapus.');
    }
}
