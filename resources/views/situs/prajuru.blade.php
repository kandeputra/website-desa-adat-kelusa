@extends('layouts.situs', ['judul' => 'Struktur Prajuru'])
@section('isi')
@include('situs.partials.phead', ['crumb' => 'Tentang Desa', 'h1' => 'Struktur Prajuru', 'sub' => 'Susunan kelembagaan mengikuti Perda Provinsi Bali No. 4 Tahun 2019 tentang Desa Adat.'])
<div class="wrap pbody grid2">
  <div class="prajuru" aria-label="Struktur prajuru">
    @foreach($prajuru as $p)
      <div><span class="org">@if($p->foto)<img src="{{ unggahan($p->foto) }}" alt="">@endif<span><b>{{ $p->jabatan }}</b><small>{{ $p->keterangan }}</small></span></span><span>{{ $p->nama ?: 'Belum diisi' }}</span></div>
    @endforeach
    <div><span><b>Kelian Banjar Adat</b><small>Empat banjar adat</small></span><a href="{{ route('banjar') }}">Lihat banjar →</a></div>
  </div>
  <div class="prose">
    <h2 style="font-size:30px">Tugas prajuru</h2>
    <p>Prajuru desa adat memimpin pelaksanaan awig-awig, mengatur upacara di kahyangan desa, mengelola padruwen (harta milik) desa adat, serta menyelesaikan wicara adat melalui musyawarah.</p>
    <p>Prajuru dipilih atau ditetapkan melalui paruman sesuai awig-awig untuk masa bakti tertentu.</p>
  </div>
</div>
@endsection
