@extends('admin.layout', ['judul' => 'Pengaturan Situs', 'crumb' => 'Sistem'])
@section('isi')
<form class="formulir" method="post" enctype="multipart/form-data" action="{{ route('admin.pengaturan.update') }}">
  @csrf @method('PUT')
  <nav class="tab-nav" aria-label="Bagian pengaturan">@foreach($grup as $g => $_)<a href="#g-{{ \Illuminate\Support\Str::slug($g) }}">{{ $g }}</a>@endforeach</nav>
  @foreach($grup as $g => $fields)
    <section class="kartu grid-field" id="g-{{ \Illuminate\Support\Str::slug($g) }}">
      <h3 class="judul-grup">{{ $g }}</h3>
      @foreach($fields as $f)@include('admin.partials.field', ['f' => $f, 'nilai' => $nilai[$f['nama']] ?? null])@endforeach
    </section>
  @endforeach
  <div class="bar-simpan lengket"><span class="keterangan">Perubahan langsung tampil di situs setelah disimpan.</span><div class="kanan"><button class="btn utama" type="submit">Simpan pengaturan</button></div></div>
</form>
@endsection
