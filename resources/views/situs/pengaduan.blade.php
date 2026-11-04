@extends('layouts.situs', ['judul' => 'Pengaduan Krama'])
@section('isi')
@include('situs.partials.phead', ['crumb' => 'Layanan', 'h1' => 'Pengaduan Krama', 'sub' => 'Sampaikan keluhan, masukan, atau permohonan informasi. Setiap pengaduan mendapat kode tiket untuk memantau tanggapan prajuru.'])
<div class="wrap pbody grid2">
  <div>
    @if(session('tiket_baru'))
      <div class="alert"><b>Pengaduan terkirim. Suksma.</b>Simpan kode tiket berikut untuk mengecek tanggapan:<p class="tiket" id="tiket">{{ session('tiket_baru') }}</p><button type="button" class="copy" data-salin="#tiket">Salin kode</button></div>
    @endif
    @if($errors->any())<div class="alert galat"><b>Periksa kembali isian Anda.</b>@foreach($errors->all() as $e)<span style="display:block">{{ $e }}</span>@endforeach</div>@endif
    <form class="form" method="post" action="{{ route('pengaduan.store') }}">
      @csrf
      <label for="nama">Nama<input id="nama" name="nama" value="{{ old('nama') }}" required maxlength="120" autocomplete="name"></label>
      <label for="banjar">Banjar<select id="banjar" name="banjar">@foreach($banjar as $b)<option @selected(old('banjar') === $b)>{{ $b }}</option>@endforeach<option @selected(old('banjar') === 'Krama tamiu / tamu')>Krama tamiu / tamu</option></select></label>
      <label for="kontak">Nomor WA / email <span style="font-weight:400;color:var(--muted)">(opsional, agar prajuru bisa menghubungi)</span><input id="kontak" name="kontak" value="{{ old('kontak') }}" maxlength="120"></label>
      <label for="jenis">Jenis<select id="jenis" name="jenis">@foreach(['Pengaduan','Masukan / saran','Permohonan informasi'] as $j)<option @selected(old('jenis') === $j)>{{ $j }}</option>@endforeach</select></label>
      <label for="isi">Isi pengaduan<textarea id="isi" name="isi" required minlength="10" maxlength="5000">{{ old('isi') }}</textarea></label>
      <input type="text" name="situs_web" tabindex="-1" autocomplete="off" style="position:absolute;left:-9999px" aria-hidden="true">
      <button class="btn primary" type="submit" style="justify-self:start">Kirim pengaduan</button>
    </form>
  </div>
  <div style="display:grid;gap:18px;align-content:start">
    <p class="eyebrow">Cek status pengaduan</p>
    <form class="form" method="get" action="{{ route('pengaduan.create') }}" style="grid-template-columns:1fr auto;align-items:end;padding:20px">
      <label for="kode">Kode tiket<input id="kode" name="kode" value="{{ request('kode') }}" placeholder="ADU-261104-XXXX"></label>
      <button class="btn line" type="submit">Cek</button>
    </form>
    @if($dicari)
      @if($tiket)
        <div class="panel" style="display:grid;gap:10px">
          <div style="display:flex;justify-content:space-between;gap:10px;flex-wrap:wrap"><b>{{ $tiket->kode }}</b><span class="status {{ $tiket->status }}">{{ $tiket->status }}</span></div>
          <p class="note" style="margin:0">{{ $tiket->jenis }} · dikirim {{ tgl($tiket->created_at) }}</p>
          <p>{{ \Illuminate\Support\Str::limit($tiket->isi, 220) }}</p>
          <div style="border-top:1px solid var(--line);padding-top:10px"><p class="tagk">Tanggapan prajuru</p><p>{{ $tiket->tanggapan ?: 'Belum ada tanggapan. Pengaduan Anda sedang menunggu ditinjau.' }}</p></div>
        </div>
      @else<p class="alert galat">Kode tiket tidak ditemukan. Periksa kembali penulisannya.</p>@endif
    @endif
    <p class="note" style="margin:0">Perkara adat diselesaikan melalui Kertha Desa secara musyawarah. Data Anda hanya dilihat oleh prajuru.</p>
  </div>
</div>
@endsection
