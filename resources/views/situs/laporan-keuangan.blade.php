@extends('layouts.situs', ['judul' => 'Laporan Keuangan'])
@section('isi')
@include('situs.partials.phead', ['crumb' => 'Laporan', 'h1' => 'Laporan Keuangan', 'sub' => 'Ringkasan pendapatan dan belanja desa adat, disampaikan terbuka kepada krama.'])
<div class="wrap pbody" style="display:grid;gap:18px">
  @if($tahunList->count() > 1)<nav class="filter">@foreach($tahunList as $t)<a href="?tahun={{ $t }}" class="{{ $t == $tahun ? 'aktif' : '' }}">{{ $t }}</a>@endforeach</nav>@endif
  @if($baris->isEmpty())<p class="kosong">Laporan tahun {{ $tahun }} belum diterbitkan.</p>@else
  <div class="tbl"><table>
    <thead><tr><th>Uraian</th><th class="n">Tahun {{ $tahun }}</th><th>Keterangan</th></tr></thead>
    <tbody>
      @foreach(['Pendapatan', 'Belanja'] as $k)
        @if(isset($baris[$k]))
          <tr><td colspan="3" class="grp">{{ $k }}</td></tr>
          @foreach($baris[$k] as $b)<tr><td>{{ $b->uraian }}</td><td class="n">{{ rupiah($b->jumlah) }}</td><td>{{ $b->keterangan }}</td></tr>@endforeach
          <tr><td><b>Jumlah {{ strtolower($k) }}</b></td><td class="n"><b>{{ $baris[$k]->whereNotNull('jumlah')->isEmpty() ? '–' : rupiah($baris[$k]->sum('jumlah')) }}</b></td><td></td></tr>
        @endif
      @endforeach
    </tbody>
  </table></div>
  <p class="note" style="margin:0">Angka diisi patengen setelah disahkan dalam paruman. Baris bertanda "–" belum diisi.</p>
  @endif
</div>
@endsection
