@extends('layouts.situs', ['judul' => 'Prestasi'])
@section('isi')
@include('situs.partials.phead', ['crumb' => 'Tentang Desa', 'h1' => 'Prestasi', 'sub' => 'Penghargaan dan capaian desa adat, sekaa, dan krama.'])
<div class="wrap pbody">
  @if($prestasi->isEmpty())<p class="kosong">Data prestasi belum ditambahkan.</p>@else
  <div class="rows">@foreach($prestasi as $p)<div class="row"><time>{{ $p->tahun }}</time><div><b>{{ $p->judul }}</b><span class="s">{{ $p->keterangan }}</span></div><span class="kode"></span></div>@endforeach</div>
  @endif
</div>
@endsection
