@php $baru = ! $item->exists; @endphp
@extends('admin.layout', ['judul' => $baru ? 'Tambah '.$m['tunggal'] : ($m['kunci'] === 'pengaduan' ? 'Tanggapi pengaduan' : 'Ubah '.$m['tunggal']), 'crumb' => '<a href="'.route('admin.r.index', $m['kunci']).'">'.e($m['label']).'</a>'])
@section('isi')
<form class="formulir" method="post" enctype="multipart/form-data" action="{{ $baru ? route('admin.r.store', $m['kunci']) : route('admin.r.update', [$m['kunci'], $item->id]) }}">
  @csrf
  @unless($baru) @method('PUT') @endunless
  <div class="kartu grid-field">
    @foreach($m['fields'] as $f)
      @include('admin.partials.field', ['f' => $f, 'nilai' => $item->{$f['nama']}])
    @endforeach
  </div>
  <div class="bar-simpan">
    <a class="tautan" href="{{ route('admin.r.index', $m['kunci']) }}">← Kembali ke daftar</a>
    <div class="kanan">
      @if(!$baru && !empty($m['publik']) && ($item->status ?? 'terbit') === 'terbit')<a class="btn" href="{{ route($m['publik'], $item->slug) }}" target="_blank" rel="noopener">Lihat di situs ↗</a>@endif
      <button class="btn utama" type="submit">{{ $baru ? 'Simpan' : 'Simpan perubahan' }}</button>
    </div>
  </div>
</form>
@unless($baru)
  <form class="zona-bahaya" method="post" action="{{ route('admin.r.destroy', [$m['kunci'], $item->id]) }}" data-konfirmasi="Hapus {{ $m['tunggal'] }} ini? Tindakan ini tidak bisa dibatalkan.">
    @csrf @method('DELETE')
    <div><b>Hapus {{ $m['tunggal'] }}</b><small>Data dan berkas terlampir akan dihapus permanen.</small></div>
    <button class="btn bahaya" type="submit">Hapus</button>
  </form>
@endunless
@endsection
