@php $label = \App\Models\Post::TYPES[$post->type]; $idx = ['berita' => 'berita.index', 'pengumuman' => 'pengumuman.index', 'artikel' => 'artikel.index'][$post->type]; @endphp
@extends('layouts.situs', ['judul' => $post->title, 'deskripsi' => $post->ringkasan(160), 'ogImage' => $post->cover ? unggahan($post->cover) : null])
@section('isi')
@include('situs.partials.phead', ['crumb' => '<a href="'.route($idx).'">'.e($post->type === 'artikel' ? 'Budaya & Tradisi' : $label).'</a>', 'h1' => $post->title, 'sub' => $post->excerpt])
<div class="wrap pbody artikel">
  <article>
    <div class="meta">
      @if($post->kategori)<span class="tagk">{{ $post->kategori }}</span>@endif
      <span>{{ tgl($post->published_at, true) }}</span>
      @if($post->penulis)<span>Oleh {{ $post->penulis->name }}</span>@endif
      <span>{{ $post->menitBaca() }} menit baca</span>
      <span>Dibaca {{ number_format($post->views, 0, ',', '.') }} kali</span>
    </div>
    @if($post->cover)<img class="cover-besar" src="{{ unggahan($post->cover) }}" alt="">@endif
    <div class="konten">{!! $post->isiHtml() !!}</div>
    <div class="bagikan">
      <span class="tagk" style="margin-right:6px">Bagikan</span>
      <a href="https://wa.me/?text={{ urlencode($post->title.' — '.url()->current()) }}" target="_blank" rel="noopener">WhatsApp</a>
      <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" rel="noopener">Facebook</a>
      <button type="button" data-salin="{{ url()->current() }}">Salin tautan</button>
    </div>
  </article>
  <aside class="samping">
    @if($terkait->isNotEmpty())
      <div><h3>{{ $label }} lainnya</h3>
        <div class="side-list">@foreach($terkait as $b)<a href="{{ $b->url() }}" style="grid-template-columns:1fr"><span><b style="font-size:18px">{{ $b->title }}</b><time>{{ tgl($b->published_at) }}</time></span></a>@endforeach</div></div>
    @endif
    <div><h3>Agenda Desa</h3>@include('situs.partials.agenda')</div>
  </aside>
</div>
@endsection
