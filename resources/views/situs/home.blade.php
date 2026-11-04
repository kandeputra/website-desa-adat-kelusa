@extends('layouts.situs')
@section('isi')
@php $heroImg = unggahan(situs('hero_gambar')); @endphp
<section class="hero {{ $heroImg ? 'berfoto' : '' }}" aria-label="{{ situs('nama_situs') }}"
  @if($heroImg) style="background-image:linear-gradient(90deg,rgba(23,15,11,.92) 0%,rgba(23,15,11,.7) 55%,rgba(23,15,11,.35) 100%),url('{{ $heroImg }}')" @endif>
  <div class="wrap">
    <div>
      <p class="salam">Om Swastyastu</p>
      <h1>{{ situs('hero_judul', situs('nama_situs')) }}</h1>
      <div class="orn" aria-hidden="true"></div>
      <p class="tag">{{ situs('hero_tagline') }}</p>
      <div class="cta"><a class="btn primary" href="{{ route('sejarah') }}">Sejarah Desa</a><a class="btn ghost" href="{{ route('pura') }}">Pura Hyang Api</a></div>
    </div>
    @include('situs.partials.gapura')
  </div>
  <div class="tumpal" aria-hidden="true"></div>
</section>

@if($pengumuman->isNotEmpty())
<div class="infostrip"><div class="wrap">
  <span class="lbl">PENGUMUMAN</span>
  <a class="judul" href="{{ $pengumuman->first()->url() }}">{{ $pengumuman->first()->title }}{{ $pengumuman->first()->excerpt ? ' — '.$pengumuman->first()->excerpt : '' }}</a>
  <a class="more" href="{{ route('pengumuman.index') }}">Lihat semua →</a>
</div></div>
@endif

<div class="wrap">
  <nav class="cepat" aria-label="Layanan cepat">
    <a href="{{ route('sejarah') }}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true"><rect x="3" y="5" width="18" height="3" rx="1.5"/><rect x="3" y="10.5" width="18" height="3" rx="1.5"/><rect x="3" y="16" width="18" height="3" rx="1.5"/><path d="M12 3v18"/></svg><b>Sejarah</b><span>Asal-usul dan purana desa</span></a>
    <a href="{{ route('produk-hukum') }}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true"><path d="M5 4h11a3 3 0 0 1 3 3v13H8a3 3 0 0 1-3-3Z"/><path d="M5 17a3 3 0 0 1 3-3h11"/></svg><b>Produk Hukum</b><span>Awig-awig dan pararem</span></a>
    <a href="{{ route('lembaga.index') }}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true"><circle cx="9" cy="8" r="3"/><circle cx="17" cy="9" r="2.4"/><path d="M3 20c0-3.3 2.7-6 6-6s6 2.7 6 6M15.5 14.5c3 0 5.5 2 5.5 5.5"/></svg><b>Lembaga Adat</b><span>Prajuru, sekaa, dan LPD</span></a>
    <a href="{{ route('kalender') }}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true"><rect x="3" y="5" width="18" height="16" rx="1"/><path d="M3 10h18M8 3v4M16 3v4"/></svg><b>Kalender</b><span>Rerahinan dan agenda</span></a>
    <a href="{{ route('wisata.index') }}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true"><path d="M12 21s-7-6.2-7-11a7 7 0 0 1 14 0c0 4.8-7 11-7 11Z"/><circle cx="12" cy="10" r="2.5"/></svg><b>Objek Wisata</b><span>Pura, air suci, sawah</span></a>
    <a href="{{ route('pengaduan.create') }}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true"><path d="M4 5h16v11H9l-5 4Z"/><path d="M8 9h8M8 12h5"/></svg><b>Pengaduan</b><span>Kirim &amp; cek status</span></a>
  </nav>

  <section class="sec">
    <div class="sambutan">
      <div class="potret">
        <div class="foto {{ situs('bendesa_foto') ? 'ada' : '' }}">
          @if(situs('bendesa_foto'))<img src="{{ unggahan(situs('bendesa_foto')) }}" alt="Foto {{ situs('bendesa_nama', 'Bendesa Adat') }}">@else Foto Bendesa Adat @endif
        </div>
        <p class="nama">{{ situs('bendesa_nama', 'Bendesa Adat Kelusa') }}</p>
        <p class="jab">{{ situs('bendesa_nama') ? 'Bendesa Adat' : '' }}{{ situs('bendesa_masa_bakti') ? ' · Masa bakti '.situs('bendesa_masa_bakti') : '' }}</p>
      </div>
      <div class="prose">
        <p class="eyebrow">Sambutan Bendesa Adat</p>
        <p class="om">Om Swastyastu</p>
        <h2 style="font-size:clamp(30px,3.8vw,44px)">Selamat datang di website {{ situs('nama_situs') }}</h2>
        @foreach(preg_split('/\R{2,}/', trim((string) situs('sambutan'))) as $par)<p>{{ $par }}</p>@endforeach
        <p class="om" style="font-size:24px">Om Shanti Shanti Shanti Om</p>
        @php $desa = preg_replace('/^Desa Adat\s+/i', '', situs('nama_situs', 'Kelusa')); @endphp
        <div class="ttd"><b>{{ situs('bendesa_nama', 'Bendesa Adat '.$desa) }}</b>@if(situs('bendesa_nama'))<span>Bendesa Adat {{ $desa }}</span>@endif</div>
      </div>
    </div>
  </section>

  @if($utama)
  <section class="sec">
    <div class="sechead"><div><p class="eyebrow">Kabar Kelusa</p><h2>Berita Terbaru</h2></div><a class="more" href="{{ route('berita.index') }}">Semua Berita →</a></div>
    <div class="berita-utama">
      <a class="lead-story" href="{{ $utama->url() }}">
        @if($utama->cover)<img class="cover" src="{{ unggahan($utama->cover) }}" alt="">@else<div class="cover ph-api" aria-hidden="true"></div>@endif
        <div class="isi-kartu">
          <span class="tagk">{{ $utama->kategori ?: 'Berita' }}</span>
          <h3>{{ $utama->title }}</h3>
          <time style="font-size:13.5px;color:var(--muted)">{{ tgl($utama->published_at, true) }}</time>
          <p style="color:var(--muted)">{{ $utama->ringkasan(220) }}</p>
        </div>
      </a>
      <div class="side-list">
        @foreach($berita as $b)
          <a href="{{ $b->url() }}">
            @if($b->cover)<img class="thumb" src="{{ unggahan($b->cover) }}" alt="" loading="lazy">@else<span class="thumb ph-api" aria-hidden="true"></span>@endif
            <span><span class="tagk">{{ $b->kategori ?: 'Berita' }}</span><b>{{ $b->title }}</b><time>{{ tgl($b->published_at) }}</time></span>
          </a>
        @endforeach
      </div>
    </div>
  </section>
  @endif

  <section class="sec">
    <div class="duo">
      <a class="band b-budaya" href="{{ route('artikel.index') }}"><span class="eyebrow">Budaya &amp; Tradisi</span><h2>Menjaga warisan leluhur</h2><p>Pura Hyang Api, Aci Keburan, dan rerahinan yang dijalankan krama dari generasi ke generasi.</p><span class="more">Jelajahi tradisi →</span></a>
      <a class="band b-wisata" href="{{ route('wisata.index') }}"><span class="eyebrow">Wisata Kelusa</span><h2>Pura bersejarah &amp; alam Payangan</h2><p>Wisata spiritual, sumber air suci, dan sawah hijau di utara Ubud.</p><span class="more">Lihat objek wisata →</span></a>
    </div>
  </section>

  <section class="sec">
    <div class="grid2">
      <div class="panel">
        <div class="sechead"><h2>Pengumuman</h2><a class="more" href="{{ route('pengumuman.index') }}">Lihat Semua →</a></div>
        <div class="rows">@forelse($pengumuman as $p)@include('situs.partials.baris-post')@empty<p class="kosong">Belum ada pengumuman.</p>@endforelse</div>
      </div>
      <div class="panel">
        <div class="sechead"><h2>Produk Hukum</h2><a class="more" href="{{ route('produk-hukum') }}">Lihat Semua →</a></div>
        <div class="rows">
          @foreach($hukum as $h)
            <a class="row" href="{{ $h->file ? unggahan($h->file) : route('produk-hukum') }}"><time>{{ $h->tahun ?: '—' }}</time><div><b>{{ $h->judul }}</b><span class="s">{{ $h->keterangan }}</span></div><span class="kode">{{ $h->jenis }}</span></a>
          @endforeach
        </div>
      </div>
    </div>
  </section>

  <section class="sec">
    <div class="grid2">
      <div>
        <div class="sechead"><div><p class="eyebrow">Agenda Desa</p><h2>Kegiatan Mendatang</h2></div><a class="more" href="{{ route('agenda') }}">Semua agenda →</a></div>
        @include('situs.partials.agenda')
      </div>
      <div>
        <div class="sechead"><div><p class="eyebrow">Kalender Rerahinan</p><h2>Hari Suci Terdekat</h2></div><a class="more" href="{{ route('kalender') }}">Kalender →</a></div>
        <div class="kal" style="grid-template-columns:1fr">
          @foreach($rerahinan as $r)
            <div class="{{ $r['api'] ? 'api' : '' }}"><span class="tgl">{{ \App\Support\Pawukon::tanggalMasehi($r['tanggal']) }}</span><b>{{ $r['nama'] }}</b><span class="hari">{{ $r['sisa'] === 0 ? 'Hari ini' : ($r['sisa'] === 1 ? 'Besok' : $r['sisa'].' hari lagi') }}</span></div>
          @endforeach
        </div>
      </div>
    </div>
  </section>

  @if($wisata->isNotEmpty())
  <section class="sec">
    <div class="sechead"><div><p class="eyebrow">Beragam Kawasan Wisata</p><h2>Setiap sudut punya cerita</h2></div><a class="more" href="{{ route('wisata.index') }}">Semua objek wisata →</a></div>
    <div class="grid3">@foreach($wisata as $w)@include('situs.partials.kartu-wisata')@endforeach</div>
  </section>
  @endif

  @if($foto->isNotEmpty())
  <section class="sec">
    <div class="sechead"><div><p class="eyebrow">Galeri</p><h2>Dokumentasi Desa</h2></div><a class="more" href="{{ route('galeri.foto') }}">Semua foto →</a></div>
    <div class="galeri">@foreach($foto as $g)<figure><a href="{{ unggahan($g->gambar) }}" target="_blank" rel="noopener"><img class="ph" src="{{ unggahan($g->gambar) }}" alt="{{ $g->judul }}" loading="lazy"></a><figcaption>{{ $g->judul }}</figcaption></figure>@endforeach</div>
  </section>
  @endif

  <section class="sec" style="padding-bottom:96px">
    <div class="sechead"><div><p class="eyebrow">Tanya Jawab</p><h2>Pertanyaan seputar {{ situs('nama_situs') }}</h2></div><a class="more" href="{{ route('faq') }}">Semua pertanyaan →</a></div>
    @include('situs.partials.faq')
  </section>
</div>
@endsection
