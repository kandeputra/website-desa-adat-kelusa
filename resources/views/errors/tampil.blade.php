@extends('layouts.situs', ['judul' => $kode.' · '.$judulGalat])
@section('isi')
<div class="phead"><div class="wrap"><p class="crumb">Galat {{ $kode }}</p><h1>{{ $judulGalat }}</h1><p>{{ $pesan }}</p></div><div class="tumpal" aria-hidden="true"></div></div>
<div class="wrap pbody" style="display:flex;gap:12px;flex-wrap:wrap"><a class="btn primary" href="{{ route('home') }}">Ke beranda</a><a class="btn line" href="{{ route('cari') }}">Cari informasi</a></div>
@endsection
