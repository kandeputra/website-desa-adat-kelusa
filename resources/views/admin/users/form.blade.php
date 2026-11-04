@php $baru = ! $u->exists; $saya = $u->is(auth()->user()); @endphp
@extends('admin.layout', ['judul' => $baru ? 'Tambah pengguna' : 'Ubah pengguna', 'crumb' => '<a href="'.route('admin.pengguna.index').'">Pengguna</a>'])
@section('isi')
<form class="formulir" method="post" action="{{ $baru ? route('admin.pengguna.store') : route('admin.pengguna.update', $u) }}">
  @csrf @unless($baru) @method('PUT') @endunless
  <div class="kartu grid-field">
    <div class="field setengah"><label for="name">Nama lengkap<span class="wajib">*</span></label><input id="name" name="name" value="{{ old('name', $u->name) }}" required></div>
    <div class="field setengah"><label for="jabatan">Jabatan</label><input id="jabatan" name="jabatan" value="{{ old('jabatan', $u->jabatan) }}" placeholder="mis. Penyarikan, Kelian Banjar Ayah"></div>
    <div class="field setengah"><label for="email">Email<span class="wajib">*</span></label><input type="email" id="email" name="email" value="{{ old('email', $u->email) }}" required autocomplete="off"></div>
    <div class="field setengah"><label for="role">Peran<span class="wajib">*</span></label>
      <select id="role" name="role" @disabled($saya)>@foreach(\App\Models\User::ROLES as $k => $l)<option value="{{ $k }}" @selected(old('role', $u->role) === $k)>{{ $l }}</option>@endforeach</select>
      @if($saya)<input type="hidden" name="role" value="{{ $u->role }}"><small class="bantuan">Peran akun sendiri tidak bisa diubah.</small>@endif
    </div>
    <div class="field penuh">
      <div class="peran-info">
        <div><span class="peran super_admin">Super Admin</span><small>Semua akses: akun pengguna, pengaturan situs, prajuru, banjar, lembaga, produk hukum, laporan keuangan & program, serta seluruh konten.</small></div>
        <div><span class="peran admin">Admin</span><small>Berita, pengumuman, budaya & tradisi, agenda, galeri, objek wisata, FAQ, perpustakaan, prestasi, dan menanggapi pengaduan.</small></div>
      </div>
    </div>
    <div class="field setengah"><label for="password">{{ $baru ? 'Kata sandi' : 'Kata sandi baru' }}@if($baru)<span class="wajib">*</span>@endif</label><input type="password" id="password" name="password" autocomplete="new-password" @required($baru)><small class="bantuan">{{ $baru ? 'Minimal 8 karakter, berisi huruf dan angka.' : 'Kosongkan jika tidak diganti.' }}</small></div>
    <div class="field setengah"><label for="password_confirmation">Ulangi kata sandi</label><input type="password" id="password_confirmation" name="password_confirmation" autocomplete="new-password"></div>
    <div class="field penuh"><label class="cek"><input type="hidden" name="is_active" value="0"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $u->is_active)) @disabled($saya)><span>Akun aktif (bisa masuk ke panel)</span></label>@if($saya)<input type="hidden" name="is_active" value="1">@endif</div>
  </div>
  <div class="bar-simpan"><a class="tautan" href="{{ route('admin.pengguna.index') }}">← Kembali</a><div class="kanan"><button class="btn utama" type="submit">{{ $baru ? 'Buat akun' : 'Simpan perubahan' }}</button></div></div>
</form>
@unless($baru || $saya)
  <form class="zona-bahaya" method="post" action="{{ route('admin.pengguna.destroy', $u) }}" data-konfirmasi="Hapus akun {{ $u->name }}? Tulisannya tetap tersimpan.">
    @csrf @method('DELETE')
    <div><b>Hapus akun</b><small>Untuk sementara, lebih aman menonaktifkan akun daripada menghapusnya.</small></div>
    <button class="btn bahaya" type="submit">Hapus akun</button>
  </form>
@endunless
@endsection
