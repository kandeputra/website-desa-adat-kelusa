@extends('layouts.situs', ['judul' => 'Kalender Rerahinan'])
@section('isi')
@include('situs.partials.phead', ['crumb' => 'Keagamaan', 'h1' => 'Kalender Rerahinan', 'sub' => 'Hari suci berdasarkan siklus pawukon 210 hari, beserta agenda desa adat.'])
<div class="wrap pbody" style="display:grid;gap:48px">
  <div>@include('situs.partials.kalender')<p class="note">Tanggal dihitung otomatis dari siklus pawukon. Jadwal upacara resmi diumumkan prajuru.</p></div>
  <div><div class="sechead"><h2>Agenda Desa</h2><a class="more" href="{{ route('agenda') }}">Semua agenda →</a></div>@include('situs.partials.agenda')</div>
</div>
@endsection
