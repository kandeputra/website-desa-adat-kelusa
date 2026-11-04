@extends('layouts.situs', ['judul' => 'Panduan Berkunjung'])
@section('isi')
@include('situs.partials.phead', ['crumb' => 'Pariwisata', 'h1' => 'Berkunjung ke Kelusa', 'sub' => 'Tamu dan pemedek disambut hangat. Mohon ikuti tata krama berikut selama di wewidangan desa adat.'])
<div class="wrap pbody grid2">
  <ol class="etika">
    <li><div><b>Berpakaian adat ke pura</b><span>Kamen, selendang, dan pakaian sopan.</span></div></li>
    <li><div><b>Hormati kesucian pura</b><span>Perempuan yang sedang haid dan orang dalam masa cuntaka tidak memasuki area pura.</span></div></li>
    <li><div><b>Jangan memotong jalan prosesi</b><span>Saat ada upacara, menepilah sampai iring-iringan lewat.</span></div></li>
    <li><div><b>Minta izin sebelum memotret</b><span>Terutama saat persembahyangan dan di Utama Mandala.</span></div></li>
    <li><div><b>Bawa pulang sampahmu</b><span>Bantu kami menjaga desa tetap bersih dan asri.</span></div></li>
  </ol>
  <div style="display:grid;gap:14px;align-content:start">
    <p class="eyebrow">Akses</p>
    <p>Kelusa terletak di jalur Jalan Raya Kelusa, Payangan, di utara Ubud. Pura Hyang Api berada di tepi jalan raya sehingga mudah dicapai.</p>
    <div class="peta"><iframe src="https://maps.google.com/maps?q={{ urlencode(situs('peta_query', 'Pura Hyang Api Kelusa')) }}&z=14&output=embed" loading="lazy" title="Peta lokasi" referrerpolicy="no-referrer-when-downgrade"></iframe></div>
    <div class="jarak"><div><span>Pusat Ubud</span><span>± 7 km</span></div><div><span>Tegallalang</span><span>± 6 km</span></div></div>
  </div>
</div>
@endsection
