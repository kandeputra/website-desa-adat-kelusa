@extends('admin.layout', ['judul' => 'Pengguna', 'crumb' => 'Sistem'])
@section('isi')
<div class="alat">
  <p class="keterangan"><b>Super Admin</b> mengelola akun, pengaturan situs, dan data resmi (prajuru, banjar, lembaga, produk hukum, laporan). <b>Admin</b> mengelola konten harian dan pengaduan.</p>
  <a class="btn utama" href="{{ route('admin.pengguna.create') }}"><svg><use href="#i-tambah"/></svg>Tambah pengguna</a>
</div>
<div class="kartu tabel-wrap">
  <table class="tabel">
    <thead><tr><th>Nama</th><th>Email</th><th>Peran</th><th>Status</th><th class="n">Tulisan</th><th>Terakhir masuk</th><th class="aksi"><span class="sr">Aksi</span></th></tr></thead>
    <tbody>
      @foreach($users as $usr)
        <tr>
          <td><a class="judul" href="{{ route('admin.pengguna.edit', $usr) }}"><span class="avatar kecil">{{ mb_strtoupper(mb_substr($usr->name, 0, 1)) }}</span>{{ $usr->name }}</a>@if($usr->jabatan)<small class="sub">{{ $usr->jabatan }}</small>@endif</td>
          <td>{{ $usr->email }}</td>
          <td><span class="peran {{ $usr->role }}">{{ $usr->roleLabel() }}</span></td>
          <td><span class="badge {{ $usr->is_active ? 's-terbit' : 's-draf' }}">{{ $usr->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
          <td class="n">{{ $usr->posts_count }}</td>
          <td>{{ $usr->last_login_at ? $usr->last_login_at->diffForHumans() : 'Belum pernah' }}</td>
          <td class="aksi"><a class="btn kecil" href="{{ route('admin.pengguna.edit', $usr) }}">Ubah</a></td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
