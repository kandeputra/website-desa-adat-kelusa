@extends('layouts.situs', ['judul' => 'Lembaga Adat'])
@section('isi')
@include('situs.partials.phead', ['crumb' => 'Lembaga Adat', 'h1' => 'Lembaga Adat', 'sub' => 'Lembaga dan sekaa yang menjalankan kehidupan adat '.situs('nama_situs').'.'])
<div class="wrap pbody"><div class="lgrid">
  @foreach($lembaga as $l)<a class="lcard" href="{{ route('lembaga.show', $l) }}"><b>{{ $l->nama }}</b><span>{{ $l->nama_lengkap }}</span></a>@endforeach
</div></div>
@endsection
