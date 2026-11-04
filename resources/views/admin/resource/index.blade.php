@extends('admin.layout', ['judul' => $m['label'], 'crumb' => e($m['grup'])])
@section('isi')
@php
  $sel = function ($item, $kol) {
    $v = $item->$kol;
    if (in_array($kol, ['gambar', 'foto', 'cover'])) return $v ? '<img class="thumb" src="'.e(unggahan($v)).'" alt="">' : '<span class="thumb kosong"></span>';
    if ($kol === 'file') return $v ? '<a href="'.e(unggahan($v)).'" target="_blank" rel="noopener">Unduh</a>' : '–';
    if ($kol === 'status') return '<span class="badge s-'.e(\Illuminate\Support\Str::slug($v)).'">'.e(ucfirst($v)).'</span>';
    if ($kol === 'jumlah') return $v === null ? '–' : number_format($v, 0, ',', '.');
    if ($v instanceof \DateTimeInterface) return e(tgl($v)).($v->format('H:i') !== '00:00' ? ' <small>'.$v->format('H.i').'</small>' : '');
    if (is_bool($v)) return $v ? 'Ya' : 'Tidak';
    return e(\Illuminate\Support\Str::limit((string) ($v ?? '–'), 70));
  };
  $kolom = $m['kolom']; $pertama = array_key_first($kolom);
  if (in_array($pertama, ['gambar', 'foto', 'cover'])) { $judulKol = array_keys($kolom)[1] ?? $pertama; } else { $judulKol = $pertama; }
@endphp
<div class="alat">
  <form class="cari-form" method="get">
    <label class="sr" for="q">Cari</label>
    <div class="cari"><svg><use href="#i-cari"/></svg><input type="search" id="q" name="q" value="{{ request('q') }}" placeholder="Cari {{ strtolower($m['label']) }}…"></div>
    @foreach($m['filter'] ?? [] as $kol => $opsi)
      <select name="{{ $kol }}" onchange="this.form.submit()" aria-label="Saring {{ $kol }}">
        <option value="">Semua {{ $kol }}</option>
        @foreach($opsi as $k => $l)<option value="{{ $k }}" @selected(request($kol) === (string) $k)>{{ $l }}</option>@endforeach
      </select>
    @endforeach
    @if(request()->hasAny(['q', ...array_keys($m['filter'] ?? [])]))<a class="tautan" href="{{ route('admin.r.index', $m['kunci']) }}">Atur ulang</a>@endif
  </form>
  @if(($m['tambah'] ?? true) !== false)
    <a class="btn utama" href="{{ route('admin.r.create', $m['kunci']) }}"><svg><use href="#i-tambah"/></svg>Tambah {{ $m['tunggal'] }}</a>
  @endif
</div>

<div class="kartu tabel-wrap">
  @if($items->isEmpty())
    <div class="kosong"><svg><use href="#i-{{ $m['ikon'] }}"/></svg><p><b>Belum ada {{ $m['tunggal'] }}.</b></p>
      @if(($m['tambah'] ?? true) !== false)<a class="btn utama" href="{{ route('admin.r.create', $m['kunci']) }}">Tambah {{ $m['tunggal'] }} pertama</a>@endif</div>
  @else
  <table class="tabel">
    <thead><tr>@foreach($kolom as $k => $l)<th class="{{ in_array($k, ['jumlah','views','urutan','jumlah_kk','krama_desa','krama_tamiu','tamiu']) ? 'n' : '' }}">{{ $l }}</th>@endforeach<th class="aksi"><span class="sr">Aksi</span></th></tr></thead>
    <tbody>
      @foreach($items as $it)
        <tr>
          @foreach($kolom as $k => $l)
            <td class="{{ in_array($k, ['jumlah','views','urutan','jumlah_kk','krama_desa','krama_tamiu','tamiu']) ? 'n' : '' }}">
              @if($k === $judulKol)<a class="judul" href="{{ route('admin.r.edit', [$m['kunci'], $it->id]) }}">{!! $sel($it, $k) !!}</a>
                @if(!empty($it->unggulan))<span class="badge s-unggulan">Utama</span>@endif
              @else{!! $sel($it, $k) !!}@endif
            </td>
          @endforeach
          <td class="aksi">
            @if(!empty($m['publik']) && ($it->status ?? 'terbit') === 'terbit')<a class="ikon-btn" href="{{ route($m['publik'], $it->slug) }}" target="_blank" rel="noopener" title="Lihat di situs"><svg><use href="#i-situs"/></svg></a>@endif
            <a class="btn kecil" href="{{ route('admin.r.edit', [$m['kunci'], $it->id]) }}">{{ $m['kunci'] === 'pengaduan' ? 'Tanggapi' : 'Ubah' }}</a>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
  @endif
</div>
<div class="bawah-tabel"><span>{{ $items->total() }} {{ $m['tunggal'] }}</span>{{ $items->links('admin.partials.pager') }}</div>
@endsection
