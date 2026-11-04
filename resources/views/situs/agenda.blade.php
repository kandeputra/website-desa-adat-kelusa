@extends('layouts.situs', ['judul' => 'Agenda Desa'])
@section('isi')
@include('situs.partials.phead', ['crumb' => 'Informasi', 'h1' => 'Agenda Desa', 'sub' => 'Paruman, upacara, dan kegiatan krama.'])
<div class="wrap pbody grid2">
  <div><div class="sechead"><h2>Mendatang</h2></div>@include('situs.partials.agenda', ['agenda' => $mendatang])</div>
  <div><div class="sechead"><h2>Telah berlangsung</h2></div>@include('situs.partials.agenda', ['agenda' => $lalu])</div>
</div>
@endsection
