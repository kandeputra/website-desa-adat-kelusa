@php $j = $jenis === 'perencanaan' ? 'Laporan Perencanaan' : 'Laporan Pembangunan'; @endphp
@extends('layouts.situs', ['judul' => $j])
@section('isi')
@include('situs.partials.phead', ['crumb' => 'Laporan', 'h1' => $j, 'sub' => $jenis === 'perencanaan' ? 'Rencana kerja desa adat yang disepakati dalam paruman.' : 'Program fisik dan non-fisik desa adat beserta statusnya.'])
<div class="wrap pbody">
  @if($program->isEmpty())<p class="kosong">Belum ada data.</p>@else
  <div class="rows">
    @foreach($program as $p)
      <div class="row"><time>{{ $p->bidang }}</time><div><b>{{ $p->judul }}</b><span class="s">{{ $p->keterangan }}{{ $p->tahun ? ' · '.$p->tahun : '' }}{{ $p->anggaran ? ' · '.rupiah($p->anggaran) : '' }}</span></div><span class="kode">{{ $p->status }}</span></div>
    @endforeach
  </div>@endif
</div>
@endsection
