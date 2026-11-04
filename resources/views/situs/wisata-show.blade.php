@extends('layouts.situs', ['judul' => $wisata->nama, 'deskripsi' => $wisata->ringkasan, 'ogImage' => $wisata->gambar ? unggahan($wisata->gambar) : null])
@section('isi')
@include('situs.partials.phead', ['crumb' => '<a href="'.route('wisata.index').'">Objek Wisata</a>', 'h1' => $wisata->nama, 'sub' => $wisata->kategori])
<div class="wrap pbody artikel">
  <article>
    @if($wisata->gambar)<img class="cover-besar" src="{{ unggahan($wisata->gambar) }}" alt="{{ $wisata->nama }}">@endif
    <div class="konten">{!! \Illuminate\Support\Str::markdown((string) ($wisata->deskripsi ?: $wisata->ringkasan), ['html_input' => 'strip']) !!}</div>
    <div class="bagikan"><a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($wisata->nama.' Kelusa Payangan') }}" target="_blank" rel="noopener">Buka di Google Maps ↗</a><a href="{{ route('berkunjung') }}">Panduan berkunjung</a></div>
  </article>
  <aside class="samping"><div><h3>Wisata lainnya</h3><div class="side-list">@foreach($lain as $w)<a href="{{ route('wisata.show', $w) }}" style="grid-template-columns:1fr"><span><span class="tagk">{{ $w->kategori }}</span><b style="font-size:19px">{{ $w->nama }}</b></span></a>@endforeach</div></div></aside>
</div>
@endsection
