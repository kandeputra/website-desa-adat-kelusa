@extends('layouts.situs', ['judul' => 'Sejarah Desa Adat'])
@section('isi')
@include('situs.partials.phead', ['crumb' => 'Tentang Desa', 'h1' => 'Sejarah '.situs('nama_situs'), 'sub' => 'Dari perjalanan suci Maharsi Markandya hingga desa adat masa kini.'])
<div class="wrap pbody grid2">
  <div class="prose konten">{!! \Illuminate\Support\Str::markdown((string) situs('sejarah'), ['html_input' => 'strip']) !!}</div>
  <ol class="timeline" aria-label="Linimasa sejarah">
    @foreach(array_filter(preg_split('/\R/', (string) situs('linimasa'))) as $baris)
      @php [$th, $jd, $ket] = array_pad(array_map('trim', explode('|', $baris)), 3, ''); @endphp
      <li><span class="th">{{ $th }}</span><b>{{ $jd }}</b><span>{{ $ket }}</span></li>
    @endforeach
  </ol>
</div>
@endsection
