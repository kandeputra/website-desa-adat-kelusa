@extends('admin.layout', ['judul' => 'Ringkasan'])
@section('isi')
@php $u = auth()->user(); $jam = (int) now()->format('H'); $sapa = $jam < 11 ? 'Rahajeng semeng' : ($jam < 15 ? 'Rahajeng tengai' : ($jam < 18 ? 'Rahajeng sanja' : 'Rahajeng wengi')); @endphp
<section class="sambut">
  <div>
    <p class="eyebrow">{{ \App\Support\Pawukon::tanggalMasehi(now()->toImmutable()) }} · {{ \App\Support\Pawukon::tanggalBali() }}</p>
    <h2>{{ $sapa }}, {{ \Illuminate\Support\Str::before($u->name, ' ') }}.</h2>
    <p>Anda masuk sebagai <b>{{ $u->roleLabel() }}</b>{{ $u->isSuperAdmin() ? ' dan dapat mengelola seluruh isi, data resmi, akun, serta pengaturan situs.' : ' dan dapat mengelola berita, pengumuman, agenda, galeri, dan pengaduan krama.' }}</p>
  </div>
  <div class="aksi-cepat">
    <a class="btn utama" href="{{ route('admin.r.create', 'berita') }}"><svg><use href="#i-tambah"/></svg>Tulis berita</a>
    <a class="btn" href="{{ route('admin.r.create', 'pengumuman') }}">Buat pengumuman</a>
    <a class="btn" href="{{ route('admin.r.create', 'agenda') }}">Tambah agenda</a>
  </div>
</section>

<section class="statistik">
  <a href="{{ route('admin.r.index', ['pengaduan', 'status' => 'baru']) }}" class="stat {{ $stat['aduanBaru'] ? 'perlu' : '' }}"><span>Pengaduan baru</span><b>{{ $stat['aduanBaru'] }}</b><small>{{ $stat['aduanProses'] }} sedang diproses</small></a>
  <a href="{{ route('admin.r.index', 'berita') }}" class="stat"><span>Berita terbit</span><b>{{ $stat['berita'] }}</b><small>{{ $stat['draf'] }} draf menunggu</small></a>
  <a href="{{ route('admin.r.index', 'agenda') }}" class="stat"><span>Agenda 30 hari</span><b>{{ $stat['agenda'] }}</b><small>kegiatan terjadwal</small></a>
  <div class="stat"><span>Total dibaca</span><b>{{ number_format($stat['dibaca'], 0, ',', '.') }}</b><small>kali, semua tulisan</small></div>
</section>

<div class="dua-kolom">
  <section class="kartu">
    <div class="kartu-kepala"><h3>Pengaduan terbaru</h3><a class="tautan" href="{{ route('admin.r.index', 'pengaduan') }}">Semua →</a></div>
    @forelse($aduan as $a)
      <a class="baris" href="{{ route('admin.r.edit', ['pengaduan', $a->id]) }}">
        <span><b>{{ $a->nama }}</b> · {{ $a->jenis }}<small>{{ \Illuminate\Support\Str::limit($a->isi, 90) }}</small></span>
        <span class="kanan"><span class="badge s-{{ $a->status }}">{{ ucfirst($a->status) }}</span><small>{{ $a->created_at->diffForHumans() }}</small></span>
      </a>
    @empty<p class="kosong-kecil">Belum ada pengaduan masuk.</p>@endforelse
  </section>
  <section class="kartu">
    <div class="kartu-kepala"><h3>Tulisan terakhir diubah</h3></div>
    @foreach($tulisan as $p)
      <a class="baris" href="{{ route('admin.r.edit', [$p->type, $p->id]) }}">
        <span><b>{{ \Illuminate\Support\Str::limit($p->title, 60) }}</b><small>{{ \App\Models\Post::TYPES[$p->type] }} · {{ $p->penulis?->name ?? '—' }} · {{ $p->updated_at->diffForHumans() }}</small></span>
        <span class="kanan"><span class="badge s-{{ $p->status }}">{{ ucfirst($p->status) }}</span></span>
      </a>
    @endforeach
  </section>
</div>

<div class="tiga-kolom">
  <section class="kartu">
    <div class="kartu-kepala"><h3>Agenda mendatang</h3><a class="tautan" href="{{ route('admin.r.index', 'agenda') }}">Kelola →</a></div>
    @forelse($agenda as $a)
      <div class="baris"><span><b>{{ $a->judul }}</b><small>{{ tgl($a->mulai, true) }}, {{ $a->mulai->format('H.i') }} · {{ $a->lokasi }}</small></span></div>
    @empty<p class="kosong-kecil">Tidak ada agenda terjadwal.</p>@endforelse
  </section>
  <section class="kartu">
    <div class="kartu-kepala"><h3>Rerahinan terdekat</h3></div>
    @foreach($rerahinan as $r)
      <div class="baris"><span><b class="{{ $r['api'] ? 'api' : '' }}">{{ $r['nama'] }}</b><small>{{ \App\Support\Pawukon::tanggalMasehi($r['tanggal']) }}</small></span><span class="kanan"><small>{{ $r['sisa'] === 0 ? 'Hari ini' : $r['sisa'].' hari lagi' }}</small></span></div>
    @endforeach
  </section>
  <section class="kartu">
    <div class="kartu-kepala"><h3>Paling banyak dibaca</h3></div>
    @foreach($populer as $p)
      <a class="baris" href="{{ $p->url() }}" target="_blank" rel="noopener"><span><b>{{ \Illuminate\Support\Str::limit($p->title, 52) }}</b></span><span class="kanan"><small>{{ number_format($p->views, 0, ',', '.') }}×</small></span></a>
    @endforeach
  </section>
</div>
@endsection
