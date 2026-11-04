@extends('layouts.situs', ['judul' => 'Pura'])
@section('isi')
@include('situs.partials.phead', ['crumb' => 'Keagamaan', 'h1' => 'Pura', 'sub' => 'Kahyangan yang diempon krama '.situs('nama_situs').'.'])
<div class="wrap pbody" style="display:grid;gap:28px">
  <div class="pura">
    <div class="kiri">
      <p class="eyebrow" style="color:var(--merah)">Dang Kahyangan</p>
      <h3>Pura Hyang Api</h3>
      <div class="prose">{!! \Illuminate\Support\Str::markdown((string) situs('pura_deskripsi'), ['html_input' => 'strip']) !!}</div>
      <div class="chips"><span class="chip">Dewa Agni</span><span class="chip">Tumpek Kandang</span><span class="chip">Aci Keburan</span><span class="chip">Tri Mandala</span></div>
    </div>
    <div class="kanan">
      <p class="eyebrow" style="margin-bottom:8px">Tata ruang · Tri Mandala</p>
      <div class="mandala">
        <div><b>Utama Mandala</b><span>Jeroan, area tersuci tempat pelinggih utama.</span></div>
        <div><b>Madya Mandala</b><span>Jaba tengah, tempat persiapan upacara dan kesenian pengiring.</span></div>
        <div><b>Nista Mandala</b><span>Jaba sisi, halaman luar tempat umat berkumpul.</span></div>
      </div>
    </div>
  </div>
  <div class="grid3">
    <div class="post"><div class="isi-kartu"><span class="tagk">Kahyangan Tiga</span><h3>Pura Puseh</h3><p>Pemujaan Dewa Wisnu sebagai pemelihara.</p></div></div>
    <div class="post"><div class="isi-kartu"><span class="tagk">Kahyangan Tiga</span><h3>Pura Desa / Bale Agung</h3><p>Pemujaan Dewa Brahma, pusat paruman desa.</p></div></div>
    <div class="post"><div class="isi-kartu"><span class="tagk">Kahyangan Tiga</span><h3>Pura Dalem</h3><p>Pemujaan Dewa Siwa sebagai pelebur.</p></div></div>
  </div>
</div>
@endsection
