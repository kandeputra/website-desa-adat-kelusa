@extends('layouts.situs', ['judul' => 'Banjar Adat'])
@section('isi')
@include('situs.partials.phead', ['crumb' => 'Tentang Desa', 'h1' => 'Banjar Adat', 'sub' => 'Banjar adat di wewidangan '.situs('nama_situs').'.'])
<div class="wrap pbody" style="display:grid;gap:24px">
  <div class="banjar">
    @foreach($banjar as $b)
      <div><b>{{ $b->nama }}</b><span>Kelian: {{ $b->kelian ?: 'belum diisi' }}</span><span>Jumlah KK: {{ $b->jumlah_kk ?? '–' }}</span></div>
    @endforeach
  </div>
  <p class="lead">Krama tamiu dan tamiu yang tinggal di wewidangan desa adat wajib melapor kepada kelian banjar setempat. Lihat persyaratannya di halaman <a href="{{ route('lembaga.show', 'banjar-adat') }}">Banjar Adat (Lembaga)</a> atau <a href="{{ route('faq') }}">Tanya Jawab</a>.</p>
</div>
@endsection
