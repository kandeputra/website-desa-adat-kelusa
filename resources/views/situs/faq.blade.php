@extends('layouts.situs', ['judul' => 'Tanya Jawab'])
@section('isi')
@include('situs.partials.phead', ['crumb' => 'Layanan', 'h1' => 'Tanya Jawab', 'sub' => 'Pertanyaan yang sering diajukan krama dan tamu.'])
<div class="wrap pbody">@include('situs.partials.faq')<p class="note">Pertanyaan Anda belum terjawab? <a href="{{ route('pengaduan.create') }}">Kirim permohonan informasi</a>.</p></div>
@endsection
