@extends('layouts.situs', ['judul' => 'Objek Wisata'])
@section('isi')
@include('situs.partials.phead', ['crumb' => 'Pariwisata', 'h1' => 'Objek Wisata', 'sub' => 'Wisata spiritual, alam, dan budaya di wewidangan Kelusa.'])
<div class="wrap pbody" style="display:grid;gap:24px">
  <p class="lead">Pengunjung mohon mengikuti <a href="{{ route('berkunjung') }}">panduan berkunjung</a> demi menjaga kesucian pura dan kenyamanan krama.</p>
  @if($wisata->isEmpty())<p class="kosong">Belum ada objek wisata.</p>@else
  <div class="grid3">@foreach($wisata as $w)@include('situs.partials.kartu-wisata')@endforeach</div>@endif
</div>
@endsection
