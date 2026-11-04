@extends('layouts.situs', ['judul' => 'Demografi'])
@section('isi')
@include('situs.partials.phead', ['crumb' => 'Tentang Desa', 'h1' => 'Demografi', 'sub' => 'Gambaran wilayah dan penduduk berdasarkan data desa dan pendataan banjar.'])
@php $tot = fn($k) => $banjar->sum($k) ?: null; @endphp
<div class="wrap pbody" style="display:grid;gap:44px">
  <div>
    <p class="eyebrow" style="margin-bottom:12px">Desa Kelusa (dinas) · cakupan tiga desa adat</p>
    <dl class="stat">
      <div><dt>Luas wilayah</dt><dd>{{ situs('luas_wilayah', '–') }} <small>km²</small></dd></div>
      <div><dt>Penduduk{{ situs('tahun_penduduk') ? ' ('.situs('tahun_penduduk').')' : '' }}</dt><dd>{{ situs('jumlah_penduduk', '–') }} <small>jiwa</small></dd></div>
      <div><dt>Banjar adat</dt><dd>{{ $banjar->count() }} <small>{{ $banjar->pluck('nama')->map(fn($n) => str_replace('Banjar ', '', $n))->join(' · ') }}</small></dd></div>
      <div><dt>Kepala keluarga</dt><dd>{{ $tot('jumlah_kk') ? number_format($tot('jumlah_kk'), 0, ',', '.') : '–' }} <small>KK di desa adat</small></dd></div>
    </dl>
  </div>
  <div>
    <p class="eyebrow" style="margin-bottom:12px">{{ situs('nama_situs') }} · per banjar adat</p>
    <div class="tbl"><table>
      <thead><tr><th>Banjar adat</th><th>Kelian</th><th class="n">KK</th><th class="n">Krama desa</th><th class="n">Krama tamiu</th><th class="n">Tamiu</th></tr></thead>
      <tbody>
        @foreach($banjar as $b)
          <tr><td>{{ $b->nama }}</td><td>{{ $b->kelian ?: '–' }}</td>
            @foreach(['jumlah_kk','krama_desa','krama_tamiu','tamiu'] as $k)<td class="n">{{ $b->$k !== null ? number_format($b->$k, 0, ',', '.') : '–' }}</td>@endforeach</tr>
        @endforeach
        <tr><td class="grp" colspan="2">Jumlah</td>@foreach(['jumlah_kk','krama_desa','krama_tamiu','tamiu'] as $k)<td class="n grp">{{ $tot($k) ? number_format($tot($k), 0, ',', '.') : '–' }}</td>@endforeach</tr>
      </tbody>
    </table></div>
    <p class="note">Data per banjar diperbarui oleh prajuru melalui panel admin.</p>
  </div>
</div>
@endsection
