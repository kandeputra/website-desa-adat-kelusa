@extends('layouts.situs', ['judul' => 'Perpustakaan Digital'])
@section('isi')
@include('situs.partials.phead', ['crumb' => 'Informasi', 'h1' => 'Perpustakaan Digital', 'sub' => 'Kajian ilmiah dan dokumen tentang '.situs('nama_situs').'.'])
<div class="wrap pbody"><div class="rows">
  @forelse($dokumen as $d)
    @php $href = $d->file ? unggahan($d->file) : $d->url; @endphp
    <a class="row" @if($href) href="{{ $href }}" target="_blank" rel="noopener" @endif><time>{{ $d->tahun ?: '—' }}</time><div><b>{{ $d->judul }}</b><span class="s">{{ $d->sumber }}</span></div><span class="kode">{{ $d->file ? 'Unduh ↓' : ($d->url ? 'Baca ↗' : '') }}</span></a>
  @empty<p class="kosong">Belum ada dokumen.</p>@endforelse
</div></div>
@endsection
