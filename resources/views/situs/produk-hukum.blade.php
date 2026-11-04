@extends('layouts.situs', ['judul' => 'Produk Hukum'])
@section('isi')
@include('situs.partials.phead', ['crumb' => 'Informasi', 'h1' => 'Produk Hukum', 'sub' => 'Awig-awig, pararem, dan keputusan prajuru. Salinan lengkap dapat dibaca di sekretariat desa adat.'])
<div class="wrap pbody">
  <div class="rows">
    @forelse($hukum as $h)
      <div class="row"><time>{{ $h->tahun ?: '—' }}</time><div><b>{{ $h->judul }}</b><span class="s">{{ $h->keterangan }}</span></div>
        <span class="kode">@if($h->file)<a href="{{ unggahan($h->file) }}" target="_blank" rel="noopener">Unduh {{ $h->jenis }} ↓</a>@else{{ $h->jenis }}@endif</span></div>
    @empty<p class="kosong">Belum ada produk hukum.</p>@endforelse
  </div>
</div>
@endsection
