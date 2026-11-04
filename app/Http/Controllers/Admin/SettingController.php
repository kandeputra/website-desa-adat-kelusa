<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\Formulir;
use App\Support\Situs;
use Illuminate\Http\Request;

/** Pengaturan situs — hanya Super Admin. */
class SettingController extends Controller
{
    public const GRUP = [
        'Identitas & Beranda' => [
            ['nama' => 'nama_situs', 'label' => 'Nama desa adat', 'tipe' => 'text', 'wajib' => true, 'lebar' => 'setengah'],
            ['nama' => 'wilayah', 'label' => 'Baris wilayah di kop', 'tipe' => 'text', 'lebar' => 'setengah'],
            ['nama' => 'hero_judul', 'label' => 'Judul besar beranda', 'tipe' => 'text', 'lebar' => 'setengah'],
            ['nama' => 'hero_tagline', 'label' => 'Kalimat pembuka beranda', 'tipe' => 'textarea', 'baris' => 2],
            ['nama' => 'hero_gambar', 'label' => 'Foto latar beranda', 'tipe' => 'image', 'bantuan' => 'Opsional. Foto lanskap minimal 1600px, mis. Pura Hyang Api. Tanpa foto, beranda memakai motif patra dan gapura.'],
        ],
        'Bendesa & Sambutan' => [
            ['nama' => 'bendesa_nama', 'label' => 'Nama Bendesa Adat', 'tipe' => 'text', 'lebar' => 'setengah'],
            ['nama' => 'bendesa_masa_bakti', 'label' => 'Masa bakti', 'tipe' => 'text', 'lebar' => 'setengah', 'bantuan' => 'mis. 2024–2029'],
            ['nama' => 'bendesa_foto', 'label' => 'Foto Bendesa', 'tipe' => 'image'],
            ['nama' => 'sambutan', 'label' => 'Teks sambutan', 'tipe' => 'textarea', 'baris' => 6, 'bantuan' => 'Pisahkan paragraf dengan satu baris kosong.'],
        ],
        'Profil Desa' => [
            ['nama' => 'sejarah', 'label' => 'Sejarah desa adat', 'tipe' => 'markdown'],
            ['nama' => 'linimasa', 'label' => 'Linimasa sejarah', 'tipe' => 'textarea', 'baris' => 6, 'bantuan' => 'Satu baris per peristiwa, format: Tahun | Judul | Keterangan'],
            ['nama' => 'visi', 'label' => 'Visi', 'tipe' => 'textarea', 'baris' => 2],
            ['nama' => 'misi', 'label' => 'Misi', 'tipe' => 'textarea', 'baris' => 6, 'bantuan' => 'Satu misi per baris.'],
            ['nama' => 'pura_deskripsi', 'label' => 'Uraian Pura Hyang Api', 'tipe' => 'markdown'],
        ],
        'Demografi' => [
            ['nama' => 'luas_wilayah', 'label' => 'Luas wilayah (km²)', 'tipe' => 'text', 'lebar' => 'setengah'],
            ['nama' => 'jumlah_penduduk', 'label' => 'Jumlah penduduk (jiwa)', 'tipe' => 'text', 'lebar' => 'setengah'],
            ['nama' => 'tahun_penduduk', 'label' => 'Tahun data penduduk', 'tipe' => 'text', 'lebar' => 'setengah'],
        ],
        'Kontak & Peta' => [
            ['nama' => 'alamat_sekretariat', 'label' => 'Alamat sekretariat desa adat', 'tipe' => 'text'],
            ['nama' => 'telepon_sekretariat', 'label' => 'Telepon / WA sekretariat', 'tipe' => 'text', 'lebar' => 'setengah'],
            ['nama' => 'email_sekretariat', 'label' => 'Email sekretariat', 'tipe' => 'text', 'lebar' => 'setengah'],
            ['nama' => 'jam_layanan', 'label' => 'Jam layanan', 'tipe' => 'text', 'lebar' => 'setengah', 'bantuan' => 'mis. Senin–Jumat, 08.00–14.00 Wita'],
            ['nama' => 'alamat_kantor_desa', 'label' => 'Alamat Kantor Desa (dinas)', 'tipe' => 'text'],
            ['nama' => 'telepon_kantor_desa', 'label' => 'Telepon Kantor Desa', 'tipe' => 'text', 'lebar' => 'setengah'],
            ['nama' => 'email_kantor_desa', 'label' => 'Email Kantor Desa', 'tipe' => 'text', 'lebar' => 'setengah'],
            ['nama' => 'peta_query', 'label' => 'Lokasi peta (kata kunci Google Maps)', 'tipe' => 'text'],
        ],
        'Media Sosial' => [
            ['nama' => 'facebook', 'label' => 'Facebook', 'tipe' => 'url', 'lebar' => 'setengah'],
            ['nama' => 'instagram', 'label' => 'Instagram', 'tipe' => 'url', 'lebar' => 'setengah'],
            ['nama' => 'tiktok', 'label' => 'TikTok', 'tipe' => 'url', 'lebar' => 'setengah'],
            ['nama' => 'youtube', 'label' => 'YouTube', 'tipe' => 'url', 'lebar' => 'setengah'],
        ],
    ];

    protected function semua(): array { return array_merge(...array_values(self::GRUP)); }

    public function edit()
    {
        return view('admin.pengaturan', ['grup' => self::GRUP, 'nilai' => Situs::all()]);
    }

    public function update(Request $r)
    {
        $fields = $this->semua();
        $valid = $r->validate(Formulir::aturan($fields), [], Formulir::label($fields));
        Situs::set(Formulir::olah($r, $fields, $valid, Situs::all(), 'situs'));
        return back()->with('ok', 'Pengaturan situs tersimpan.');
    }
}
