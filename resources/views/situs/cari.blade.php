@extends('layouts.situs', ['judul' => 'Pencarian'])
@section('isi')
@include('situs.partials.phead', ['crumb' => 'Informasi', 'h1' => 'Pencarian', 'sub' => $q !== '' ? 'Hasil untuk "'.$q.'"' : 'Cari berita, pengumuman, dan artikel.'])
<div class="wrap pbody" style="display:grid;gap:24px">
  <form class="form" action="{{ route('cari') }}" method="get" role="search" style="grid-template-columns:1fr auto;align-items:end">
    <label for="q">Kata kunci<input type="search" id="q" name="q" value="{{ $q }}" placeholder="mis. piodalan, paruman, LPD"></label>
    <button class="btn primary" type="submit">Cari</button>
  </form>
  @if($q !== '')
    @if($hasil->isEmpty())<p class="kosong">Tidak ada hasil untuk "{{ $q }}". Coba kata kunci lain.</p>
    @else<div class="rows">@foreach($hasil as $p)@include('situs.partials.baris-post')@endforeach</div>{{ $hasil->links() }}@endif
  @endif
</div>
@endsection
