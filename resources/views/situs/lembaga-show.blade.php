@extends('layouts.situs', ['judul' => $lembaga->nama, 'deskripsi' => $lembaga->deskripsi])
@section('isi')
@include('situs.partials.phead', ['crumb' => '<a href="'.route('lembaga.index').'">Lembaga Adat</a>', 'h1' => $lembaga->nama, 'sub' => $lembaga->nama_lengkap])
<div class="wrap pbody ldetail">
  <div class="prose">
    @if($lembaga->foto)<img src="{{ unggahan($lembaga->foto) }}" alt="{{ $lembaga->nama }}" style="border:1px solid var(--line)">@endif
    <p>{{ $lembaga->deskripsi }}</p>
    @if($lembaga->tugasList())<h2 style="font-size:28px">Tugas &amp; kegiatan</h2>
      <ul class="tugas">@foreach($lembaga->tugasList() as $t)<li>{{ $t }}</li>@endforeach</ul>@endif
  </div>
  <dl class="fakta-l">
    <div><dt>Ketua</dt><dd>{{ $lembaga->ketua ?: 'Belum diisi' }}</dd></div>
    <div><dt>Sekretariat</dt><dd>{{ $lembaga->sekretariat ?: 'Belum diisi' }}</dd></div>
    <div><dt>Kontak</dt><dd>{{ $lembaga->kontak ?: 'Belum diisi' }}</dd></div>
    <div><dt>Dasar</dt><dd>Awig-awig &amp; pararem</dd></div>
  </dl>
</div>
@endsection
