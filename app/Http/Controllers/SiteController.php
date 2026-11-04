<?php

namespace App\Http\Controllers;

use App\Models\{Agenda, Banjar, Dokumen, Faq, Galeri, LaporanKeuangan, Lembaga, Pengaduan, Post, Prajuru, Prestasi, ProdukHukum, Program, Wisata};
use App\Support\Pawukon;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function home()
    {
        $berita = Post::terbit()->jenis('berita')->orderByDesc('unggulan')->latest('published_at')->take(5)->get();
        return view('situs.home', [
            'utama' => $berita->first(),
            'berita' => $berita->slice(1),
            'pengumuman' => Post::terbit()->jenis('pengumuman')->latest('published_at')->take(5)->get(),
            'hukum' => ProdukHukum::orderByRaw("jenis = 'Awig-awig' desc")->latest()->take(5)->get(),
            'wisata' => Wisata::orderBy('urutan')->take(3)->get(),
            'agenda' => Agenda::where('mulai', '>=', now()->startOfDay())->orderBy('mulai')->take(4)->get(),
            'rerahinan' => Pawukon::mendatang(3),
            'faq' => Faq::orderBy('urutan')->take(4)->get(),
            'foto' => Galeri::where('jenis', 'foto')->latest()->take(4)->get(),
        ]);
    }

    // ---------- Tentang desa ----------
    public function sejarah() { return view('situs.sejarah'); }
    public function visiMisi() { return view('situs.visi-misi'); }
    public function demografi() { return view('situs.demografi', ['banjar' => Banjar::orderBy('urutan')->get()]); }
    public function prajuru() { return view('situs.prajuru', ['prajuru' => Prajuru::orderBy('urutan')->get()]); }
    public function banjar() { return view('situs.banjar', ['banjar' => Banjar::orderBy('urutan')->get()]); }
    public function prestasi() { return view('situs.prestasi', ['prestasi' => Prestasi::orderByDesc('tahun')->latest()->get()]); }

    // ---------- Lembaga ----------
    public function lembagaIndex() { return view('situs.lembaga-index', ['lembaga' => Lembaga::orderBy('urutan')->get()]); }
    public function lembagaShow(Lembaga $lembaga) { return view('situs.lembaga-show', compact('lembaga')); }

    // ---------- Keagamaan ----------
    public function pura() { return view('situs.pura'); }
    public function kalender() { return view('situs.kalender', ['rerahinan' => Pawukon::mendatang(9), 'agenda' => Agenda::where('mulai', '>=', now()->startOfDay())->orderBy('mulai')->take(8)->get()]); }

    // ---------- Tulisan: berita / pengumuman / artikel ----------
    protected function daftar(string $type, Request $r)
    {
        $q = Post::terbit()->jenis($type)->latest('published_at');
        if ($k = $r->query('kategori')) $q->where('kategori', $k);
        return view('situs.posts', [
            'type' => $type,
            'posts' => $q->paginate(9)->withQueryString(),
            'kategori' => Post::terbit()->jenis($type)->whereNotNull('kategori')->distinct()->orderBy('kategori')->pluck('kategori'),
        ]);
    }

    protected function tampil(string $type, Post $post)
    {
        abort_unless($post->type === $type && $post->status === 'terbit' && (! $post->published_at || $post->published_at <= now()), 404);
        $post->increment('views');
        return view('situs.post', [
            'post' => $post,
            'terkait' => Post::terbit()->jenis($type)->whereKeyNot($post->id)->latest('published_at')->take(4)->get(),
            'agenda' => Agenda::where('mulai', '>=', now()->startOfDay())->orderBy('mulai')->take(3)->get(),
        ]);
    }

    public function beritaIndex(Request $r) { return $this->daftar('berita', $r); }
    public function beritaShow(Post $post) { return $this->tampil('berita', $post); }
    public function pengumumanIndex(Request $r) { return $this->daftar('pengumuman', $r); }
    public function pengumumanShow(Post $post) { return $this->tampil('pengumuman', $post); }
    public function artikelIndex(Request $r) { return $this->daftar('artikel', $r); }
    public function artikelShow(Post $post) { return $this->tampil('artikel', $post); }

    public function cari(Request $r)
    {
        $q = trim((string) $r->query('q'));
        $hasil = $q === '' ? collect() : Post::terbit()->where(fn ($w) => $w->where('title', 'like', "%$q%")->orWhere('body', 'like', "%$q%")->orWhere('excerpt', 'like', "%$q%"))
            ->latest('published_at')->paginate(10)->withQueryString();
        return view('situs.cari', compact('q', 'hasil'));
    }

    // ---------- Pariwisata ----------
    public function wisataIndex() { return view('situs.wisata-index', ['wisata' => Wisata::orderBy('urutan')->get()]); }
    public function wisataShow(Wisata $wisata) { return view('situs.wisata-show', ['wisata' => $wisata, 'lain' => Wisata::whereKeyNot($wisata->id)->orderBy('urutan')->take(3)->get()]); }
    public function berkunjung() { return view('situs.berkunjung'); }

    // ---------- Laporan ----------
    public function laporanKeuangan(Request $r)
    {
        $tahunList = LaporanKeuangan::distinct()->orderByDesc('tahun')->pluck('tahun');
        $tahun = (int) ($r->query('tahun') ?: $tahunList->first() ?: now()->year);
        $baris = LaporanKeuangan::where('tahun', $tahun)->orderBy('urutan')->get()->groupBy('kelompok');
        return view('situs.laporan-keuangan', compact('tahun', 'tahunList', 'baris'));
    }
    public function laporanPerencanaan() { return view('situs.program', ['jenis' => 'perencanaan', 'program' => Program::where('jenis', 'perencanaan')->orderByDesc('tahun')->orderBy('bidang')->get()]); }
    public function laporanPembangunan() { return view('situs.program', ['jenis' => 'pembangunan', 'program' => Program::where('jenis', 'pembangunan')->orderByDesc('tahun')->orderBy('bidang')->get()]); }

    // ---------- Informasi ----------
    public function produkHukum() { return view('situs.produk-hukum', ['hukum' => ProdukHukum::orderByRaw("jenis = 'Awig-awig' desc")->orderBy('jenis')->orderByDesc('tahun')->get()]); }
    public function perpustakaan() { return view('situs.perpustakaan', ['dokumen' => Dokumen::orderByDesc('tahun')->latest()->get()]); }
    public function galeriFoto() { return view('situs.galeri', ['jenis' => 'foto', 'item' => Galeri::where('jenis', 'foto')->latest('tanggal')->latest()->paginate(16)]); }
    public function galeriVideo() { return view('situs.galeri', ['jenis' => 'video', 'item' => Galeri::where('jenis', 'video')->latest('tanggal')->latest()->paginate(8)]); }
    public function agenda() { return view('situs.agenda', ['mendatang' => Agenda::where('mulai', '>=', now()->startOfDay())->orderBy('mulai')->get(), 'lalu' => Agenda::where('mulai', '<', now()->startOfDay())->latest('mulai')->take(10)->get()]); }

    // ---------- Layanan ----------
    public function faq() { return view('situs.faq', ['faq' => Faq::orderBy('urutan')->get()]); }
    public function kontak() { return view('situs.kontak'); }

    public function pengaduanCreate(Request $r)
    {
        $tiket = $r->filled('kode') ? Pengaduan::where('kode', strtoupper(trim($r->query('kode'))))->first() : null;
        return view('situs.pengaduan', ['banjar' => Banjar::orderBy('urutan')->pluck('nama'), 'tiket' => $tiket, 'dicari' => $r->filled('kode')]);
    }

    public function pengaduanStore(Request $r)
    {
        if ($r->filled('situs_web')) return back(); // jebakan bot
        $data = $r->validate([
            'nama' => 'required|string|max:120',
            'banjar' => 'nullable|string|max:80',
            'kontak' => 'nullable|string|max:120',
            'jenis' => 'required|in:Pengaduan,Masukan / saran,Permohonan informasi',
            'isi' => 'required|string|min:10|max:5000',
        ], [], ['isi' => 'isi pengaduan']);
        $p = Pengaduan::create($data + ['kode' => Pengaduan::buatKode(), 'status' => 'baru']);
        return redirect()->route('pengaduan.create')->with('tiket_baru', $p->kode);
    }
}
