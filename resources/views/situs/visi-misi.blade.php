@extends('layouts.situs', ['judul' => 'Visi Misi'])
@section('isi')
@include('situs.partials.phead', ['crumb' => 'Tentang Desa', 'h1' => 'Visi Misi', 'sub' => 'Arah pembangunan desa adat berlandaskan Tri Hita Karana.'])
<div class="wrap pbody" style="display:grid;gap:48px">
  <div><p class="eyebrow" style="margin-bottom:12px">Visi</p><p class="visi">{{ situs('visi') }}</p></div>
  <div class="grid2">
    <div><p class="eyebrow" style="margin-bottom:12px">Misi</p>
      <ol class="misi">@foreach(array_filter(preg_split('/\R/', (string) situs('misi'))) as $m)<li>{{ $m }}</li>@endforeach</ol></div>
    <div><p class="eyebrow" style="margin-bottom:12px">Landasan</p>
      <div class="thk" style="grid-template-columns:1fr">
        <div style="border-left:0;padding-left:0"><em>Hubungan dengan Tuhan</em><b>Parahyangan</b><span>Pura, upacara, dan tradisi suci.</span></div>
        <div style="border-left:0;padding-left:0;border-top:1px solid var(--line)"><em>Hubungan antarmanusia</em><b>Pawongan</b><span>Prajuru, banjar, sekaa, dan krama.</span></div>
        <div style="border-left:0;padding-left:0;border-top:1px solid var(--line)"><em>Hubungan dengan alam</em><b>Palemahan</b><span>Wewidangan, sawah, dan lingkungan.</span></div>
      </div></div>
  </div>
</div>
@endsection
