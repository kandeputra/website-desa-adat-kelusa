@php
  $info = ['berita' => ['Berita', 'Informasi', 'Kabar kegiatan desa adat.'], 'pengumuman' => ['Pengumuman', 'Informasi', 'Pengumuman resmi prajuru untuk krama.'], 'artikel' => ['Budaya & Tradisi', 'Keagamaan', 'Tulisan tentang sejarah, pura, dan tradisi '.situs('nama_situs').'.']][$type];
@endphp
@extends('layouts.situs', ['judul' => $info[0]])
@section('isi')
@include('situs.partials.phead', ['crumb' => $info[1], 'h1' => $info[0], 'sub' => $info[2]])
<div class="wrap pbody">
  @if($kategori->count() > 1)
    <nav class="filter" aria-label="Kategori">
      <a href="{{ url()->current() }}" class="{{ request('kategori') ? '' : 'aktif' }}">Semua</a>
      @foreach($kategori as $k)<a href="?kategori={{ urlencode($k) }}" class="{{ request('kategori') === $k ? 'aktif' : '' }}">{{ $k }}</a>@endforeach
    </nav>
  @endif
  @if($posts->isEmpty())
    <p class="kosong">Belum ada {{ strtolower($info[0]) }} yang diterbitkan.</p>
  @elseif($type === 'pengumuman')
    <div class="rows">@foreach($posts as $p)@include('situs.partials.baris-post')@endforeach</div>
  @else
    <div class="grid3">@foreach($posts as $p)@include('situs.partials.kartu-post')@endforeach</div>
  @endif
  {{ $posts->links() }}
</div>
@endsection
