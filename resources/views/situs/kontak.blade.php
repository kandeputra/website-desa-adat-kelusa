@extends('layouts.situs', ['judul' => 'Kontak Kami'])
@section('isi')
@include('situs.partials.phead', ['crumb' => 'Layanan', 'h1' => 'Kontak Kami', 'sub' => 'Urusan adat ke sekretariat desa adat. Administrasi kependudukan ke Kantor Desa (dinas) Kelusa.'])
<div class="wrap pbody" style="display:grid;gap:40px">
  <div class="grid2">
    <div><h2 style="font-size:28px;margin-bottom:14px">Sekretariat Desa Adat</h2>
      <dl class="kontakl">
        <div><dt>Alamat</dt><dd>{{ situs('alamat_sekretariat', 'Belum diisi') }}</dd></div>
        <div><dt>Telepon / WA</dt><dd>{{ situs('telepon_sekretariat', 'Belum diisi') }}</dd></div>
        <div><dt>Email</dt><dd>{{ situs('email_sekretariat', 'Belum diisi') }}</dd></div>
        <div><dt>Jam layanan</dt><dd>{{ situs('jam_layanan', 'Belum diisi') }}</dd></div>
      </dl></div>
    <div><h2 style="font-size:28px;margin-bottom:14px">Kantor Desa Kelusa</h2>
      <dl class="kontakl">
        <div><dt>Alamat</dt><dd>{{ situs('alamat_kantor_desa') }}</dd></div>
        <div><dt>Telepon</dt><dd>{{ situs('telepon_kantor_desa') }}</dd></div>
        <div><dt>Email</dt><dd>{{ situs('email_kantor_desa') }}</dd></div>
      </dl></div>
  </div>
  <div class="peta"><iframe src="https://maps.google.com/maps?q={{ urlencode(situs('peta_query', 'Pura Hyang Api Kelusa')) }}&z=14&output=embed" loading="lazy" title="Peta lokasi" referrerpolicy="no-referrer-when-downgrade"></iframe></div>
</div>
@endsection
