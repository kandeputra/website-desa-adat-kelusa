@php
  $grup = match (true) {
    request()->routeIs('home') => 'beranda',
    request()->routeIs('sejarah','visi-misi','demografi','prajuru','banjar','prestasi') => 'profil',
    request()->routeIs('lembaga.*') => 'lembaga',
    request()->routeIs('pura','kalender','artikel.*') => 'keagamaan',
    request()->routeIs('wisata.*','berkunjung') => 'pariwisata',
    request()->routeIs('laporan.*') => 'laporan',
    request()->routeIs('berita.*','pengumuman.*','produk-hukum','perpustakaan','galeri.*','agenda','cari') => 'informasi',
    request()->routeIs('faq','pengaduan.*','kontak') => 'layanan',
    default => '',
  };
  $nama = situs('nama_situs', 'Desa Adat Kelusa');
@endphp
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<title>{{ isset($judul) ? $judul.' · ' : '' }}{{ $nama }}</title>
<meta name="description" content="{{ $deskripsi ?? 'Website resmi '.$nama.', '.situs('wilayah') }}">
<meta property="og:title" content="{{ $judul ?? $nama }}">
<meta property="og:description" content="{{ $deskripsi ?? 'Website resmi '.$nama }}">
@isset($ogImage)<meta property="og:image" content="{{ $ogImage }}">@endisset
<meta name="theme-color" content="#170F0B">
<link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700&family=Cormorant+Garamond:ital,wght@0,500;0,600;0,700;1,500;1,600&family=Source+Sans+3:ital,wght@0,400;0,600;0,700;1,400&display=swap">
<link rel="stylesheet" href="{{ asset('css/situs.css') }}?v={{ filemtime(public_path('css/situs.css')) }}">
<style>:root{padding-top:env(safe-area-inset-top);padding-bottom:env(safe-area-inset-bottom)}body{margin:0}</style>
</head>
<body>
@include('situs.partials.lambang')

<div class="utility">
  <div class="wrap">
    <div class="kiri"><b>Om Swastyastu</b><span>{{ $tanggalBali }}</span></div>
    <div class="kanan">
      @if(situs('telepon_kantor_desa'))<span>Kantor Desa {{ situs('telepon_kantor_desa') }}</span>@endif
      @if(situs('email_kantor_desa'))<span class="sep">|</span><span>{{ situs('email_kantor_desa') }}</span>@endif
    </div>
  </div>
</div>

<header class="masthead">
  <div class="wrap">
    <a href="{{ route('home') }}" aria-label="{{ $nama }}, beranda" style="display:flex"><svg class="lambang" aria-hidden="true"><use href="#lambang"/></svg></a>
    <div class="kop">
      <small>Website Resmi</small>
      <b>{{ mb_strtoupper($nama) }}</b>
      <span>{{ situs('wilayah') }}</span>
    </div>
    <div class="kop-cta">
      <form class="cari" action="{{ route('cari') }}" method="get" role="search">
        <input type="search" name="q" id="cari-q" placeholder="Cari berita, artikel…" value="{{ request('q') }}" aria-label="Cari">
        <button type="submit" aria-label="Cari"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="11" cy="11" r="7"/><path d="m20 20-4-4"/></svg></button>
      </form>
      <a class="utama" href="{{ route('pengaduan.create') }}">Pengaduan Krama</a>
    </div>
  </div>
</header>

<nav class="navbar" id="top" aria-label="Menu utama">
  <div class="wrap">
    <a class="nav-name" href="{{ route('home') }}">{{ $nama }}</a>
    <button class="burger" type="button" id="burger" aria-expanded="false" aria-controls="menu">MENU</button>
    <ul class="menu" id="menu">
      <li class="{{ $grup==='beranda'?'on':'' }}"><a href="{{ route('home') }}">Beranda</a></li>
      <li class="{{ $grup==='profil'?'on':'' }}"><button type="button" aria-expanded="false">Tentang Desa</button>
        <ul class="sub">
          <li><a href="{{ route('sejarah') }}">Sejarah Desa Adat</a></li>
          <li><a href="{{ route('visi-misi') }}">Visi Misi</a></li>
          <li><a href="{{ route('demografi') }}">Demografi</a></li>
          <li><a href="{{ route('prajuru') }}">Struktur Prajuru</a></li>
          <li><a href="{{ route('banjar') }}">Banjar Adat</a></li>
          <li><a href="{{ route('prestasi') }}">Prestasi</a></li>
        </ul></li>
      <li class="{{ $grup==='lembaga'?'on':'' }}"><button type="button" aria-expanded="false">Lembaga Adat</button>
        <ul class="sub">
          <li><a href="{{ route('lembaga.index') }}">Semua Lembaga</a></li>
          @foreach($menuLembaga as $l)<li><a href="{{ route('lembaga.show', $l) }}">{{ $l->nama }}</a></li>@endforeach
        </ul></li>
      <li class="{{ $grup==='keagamaan'?'on':'' }}"><button type="button" aria-expanded="false">Keagamaan</button>
        <ul class="sub">
          <li><a href="{{ route('pura') }}">Pura</a></li>
          <li><a href="{{ route('kalender') }}">Kalender Rerahinan</a></li>
          <li><a href="{{ route('artikel.index') }}">Budaya &amp; Tradisi</a></li>
        </ul></li>
      <li class="{{ $grup==='pariwisata'?'on':'' }}"><button type="button" aria-expanded="false">Pariwisata</button>
        <ul class="sub">
          <li><a href="{{ route('wisata.index') }}">Objek Wisata</a></li>
          <li><a href="{{ route('berkunjung') }}">Panduan Berkunjung</a></li>
        </ul></li>
      <li class="{{ $grup==='laporan'?'on':'' }}"><button type="button" aria-expanded="false">Laporan</button>
        <ul class="sub">
          <li><a href="{{ route('laporan.keuangan') }}">Laporan Keuangan</a></li>
          <li><a href="{{ route('laporan.perencanaan') }}">Laporan Perencanaan</a></li>
          <li><a href="{{ route('laporan.pembangunan') }}">Laporan Pembangunan</a></li>
        </ul></li>
      <li class="{{ $grup==='informasi'?'on':'' }}"><button type="button" aria-expanded="false">Informasi</button>
        <ul class="sub">
          <li><a href="{{ route('berita.index') }}">Berita</a></li>
          <li><a href="{{ route('pengumuman.index') }}">Pengumuman</a></li>
          <li><a href="{{ route('agenda') }}">Agenda Desa</a></li>
          <li><a href="{{ route('produk-hukum') }}">Produk Hukum</a></li>
          <li><a href="{{ route('perpustakaan') }}">Perpustakaan Digital</a></li>
          <li><a href="{{ route('galeri.foto') }}">Galeri Foto</a></li>
          <li><a href="{{ route('galeri.video') }}">Galeri Video</a></li>
        </ul></li>
      <li class="{{ $grup==='layanan'?'on':'' }}"><button type="button" aria-expanded="false">Layanan</button>
        <ul class="sub">
          <li><a href="{{ route('pengaduan.create') }}">Pengaduan &amp; Cek Status</a></li>
          <li><a href="{{ route('faq') }}">Tanya Jawab (FAQ)</a></li>
          <li><a href="{{ route('kontak') }}">Kontak Kami</a></li>
        </ul></li>
      <li class="m-cari"><form action="{{ route('cari') }}" method="get" role="search"><input type="search" name="q" id="m-cari-q" placeholder="Cari berita, artikel…" aria-label="Cari"><button type="submit">Cari</button></form></li>
    </ul>
  </div>
</nav>

<main id="main">
@yield('isi')
</main>

<footer>
  <div class="tumpal" aria-hidden="true"></div>
  <div class="wrap cols">
    <div style="display:grid;gap:16px;align-content:start">
      <a class="fbrand" href="{{ route('home') }}"><svg aria-hidden="true"><use href="#lambang"/></svg><span><b>{{ mb_strtoupper($nama) }}</b><small>Payangan · Gianyar · Bali</small></span></a>
      <p>Website resmi {{ $nama }}, pengempon Pura Hyang Api. Dikelola oleh prajuru desa adat untuk krama dan masyarakat luas.</p>
      @php $sosmed = array_filter(['Facebook' => situs('facebook'), 'Instagram' => situs('instagram'), 'TikTok' => situs('tiktok'), 'YouTube' => situs('youtube')]); @endphp
      @if($sosmed)
        <div class="sosmed">@foreach($sosmed as $n => $u)<a href="{{ $u }}" target="_blank" rel="noopener"><span>{{ $n }}</span></a>@endforeach</div>
      @endif
    </div>
    <div><h3>Tautan</h3><ul>
      <li><a href="{{ route('sejarah') }}">Profil Desa</a></li><li><a href="{{ route('prajuru') }}">Struktur Prajuru</a></li>
      <li><a href="{{ route('demografi') }}">Demografi</a></li><li><a href="{{ route('pura') }}">Pura</a></li>
      <li><a href="{{ route('wisata.index') }}">Objek Wisata</a></li><li><a href="{{ route('produk-hukum') }}">Regulasi</a></li>
      <li><a href="{{ route('laporan.keuangan') }}">Laporan</a></li><li><a href="{{ route('perpustakaan') }}">Perpustakaan</a></li>
      <li><a href="{{ route('faq') }}">Tanya Jawab</a></li><li><a href="{{ route('pengaduan.create') }}">Pengaduan</a></li>
    </ul></div>
    <div><h3>Kontak</h3><ul>
      <li>Kantor Desa Kelusa</li>
      @if(situs('alamat_kantor_desa'))<li>{{ situs('alamat_kantor_desa') }}</li>@endif
      @if(situs('telepon_kantor_desa'))<li>Telp. {{ situs('telepon_kantor_desa') }}</li>@endif
      @if(situs('email_kantor_desa'))<li>{{ situs('email_kantor_desa') }}</li>@endif
      @if(situs('alamat_sekretariat'))<li>Sekretariat Desa Adat: {{ situs('alamat_sekretariat') }}</li>@endif
    </ul></div>
  </div>
  <div class="bawah"><div class="wrap"><span>© {{ now()->year }} {{ $nama }}. Hak cipta dilindungi.</span><em>Om Shanti Shanti Shanti Om</em></div></div>
</footer>
<script src="{{ asset('js/situs.js') }}?v={{ filemtime(public_path('js/situs.js')) }}" defer></script>
</body>
</html>
