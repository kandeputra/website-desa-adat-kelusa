@extends('admin.layout', ['judul' => 'Profil Saya', 'crumb' => 'Akun'])
@section('isi')
<form class="formulir" method="post" action="{{ route('admin.profil.update') }}">
  @csrf @method('PUT')
  <div class="kartu grid-field">
    <h3 class="judul-grup">Data diri <span class="peran {{ $u->role }}">{{ $u->roleLabel() }}</span></h3>
    <div class="field setengah"><label for="name">Nama</label><input id="name" name="name" value="{{ old('name', $u->name) }}" required></div>
    <div class="field setengah"><label for="jabatan">Jabatan</label><input id="jabatan" name="jabatan" value="{{ old('jabatan', $u->jabatan) }}"></div>
    <div class="field setengah"><label for="email">Email</label><input type="email" id="email" name="email" value="{{ old('email', $u->email) }}" required></div>
  </div>
  <div class="kartu grid-field">
    <h3 class="judul-grup">Ganti kata sandi</h3>
    <div class="field setengah"><label for="password_lama">Kata sandi saat ini</label><input type="password" id="password_lama" name="password_lama" autocomplete="current-password"></div>
    <div class="field setengah"></div>
    <div class="field setengah"><label for="password">Kata sandi baru</label><input type="password" id="password" name="password" autocomplete="new-password"><small class="bantuan">Minimal 8 karakter, berisi huruf dan angka.</small></div>
    <div class="field setengah"><label for="password_confirmation">Ulangi kata sandi baru</label><input type="password" id="password_confirmation" name="password_confirmation" autocomplete="new-password"></div>
  </div>
  <div class="bar-simpan"><span></span><div class="kanan"><button class="btn utama" type="submit">Simpan</button></div></div>
</form>
@endsection
