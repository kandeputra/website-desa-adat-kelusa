@extends('layouts.situs', ['judul' => $jenis === 'foto' ? 'Galeri Foto' : 'Galeri Video'])
@section('isi')
@include('situs.partials.phead', ['crumb' => 'Informasi', 'h1' => $jenis === 'foto' ? 'Galeri Foto' : 'Galeri Video', 'sub' => 'Dokumentasi kegiatan dan wewidangan desa.'])
<div class="wrap pbody">
  @if($item->isEmpty())<p class="kosong">Belum ada {{ $jenis }} di galeri.</p>
  @elseif($jenis === 'foto')
    <div class="galeri">@foreach($item as $g)<figure><a href="{{ unggahan($g->gambar) }}" target="_blank" rel="noopener"><img class="ph" src="{{ unggahan($g->gambar) }}" alt="{{ $g->judul }}" loading="lazy"></a><figcaption>{{ $g->judul }}{{ $g->tanggal ? ' · '.tgl($g->tanggal) : '' }}</figcaption></figure>@endforeach</div>
  @else
    <div class="grid2">@foreach($item as $g)<figure style="margin:0;display:grid;gap:8px">
      @if($g->youtubeId())<div class="embed"><iframe src="https://www.youtube-nocookie.com/embed/{{ $g->youtubeId() }}" title="{{ $g->judul }}" loading="lazy" allowfullscreen></iframe></div>
      @else<a class="video" href="{{ $g->url_video }}" target="_blank" rel="noopener">Tonton video ↗</a>@endif
      <figcaption class="note" style="margin:0">{{ $g->judul }}</figcaption></figure>@endforeach</div>
  @endif
  {{ $item->links() }}
</div>
@endsection
