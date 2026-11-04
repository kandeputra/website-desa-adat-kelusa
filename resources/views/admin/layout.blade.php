@php
  $u = auth()->user();
  $modul = collect(config('admin.modul'))->filter(fn ($m) => $m['peran'] === 'admin' || $u->isSuperAdmin());
  $grup = $modul->groupBy('grup', true);
  $aktif = request()->route('modul');
  $aduanBaru = \App\Models\Pengaduan::where('status', 'baru')->count();
@endphp
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex,nofollow">
<title>{{ $judul ?? 'Panel Admin' }} · {{ situs('nama_situs', 'Desa Adat Kelusa') }}</title>
<link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600&family=Cormorant+Garamond:wght@600&family=Source+Sans+3:ital,wght@0,400;0,600;0,700;1,400&display=swap">
<link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ filemtime(public_path('css/admin.css')) }}">
</head>
<body>
@include('admin.partials.ikon')
@include('situs.partials.lambang')
<div class="shell">
  <aside class="sidebar" id="sidebar">
    <a class="brand" href="{{ route('admin.dashboard') }}">
      <svg class="lambang" aria-hidden="true"><use href="#lambang"/></svg>
      <span><b>{{ situs('nama_situs', 'Desa Adat Kelusa') }}</b><small>Panel Admin</small></span>
    </a>
    <nav class="snav" aria-label="Menu admin">
      <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'on' : '' }}"><svg><use href="#i-dasbor"/></svg>Ringkasan</a>
      @foreach($grup as $nama => $isi)
        <p class="sgrup">{{ $nama }}@if($nama === 'Data Resmi')<span class="kunci">Super</span>@endif</p>
        @foreach($isi as $kunci => $m)
          <a href="{{ route('admin.r.index', $kunci) }}" class="{{ $aktif === $kunci ? 'on' : '' }}"><svg><use href="#i-{{ $m['ikon'] }}"/></svg>{{ $m['label'] }}
            @if($kunci === 'pengaduan' && $aduanBaru)<span class="hitung">{{ $aduanBaru }}</span>@endif</a>
        @endforeach
      @endforeach
      @if($u->isSuperAdmin())
        <p class="sgrup">Sistem<span class="kunci">Super</span></p>
        <a href="{{ route('admin.pengguna.index') }}" class="{{ request()->routeIs('admin.pengguna.*') ? 'on' : '' }}"><svg><use href="#i-pengguna"/></svg>Pengguna</a>
        <a href="{{ route('admin.pengaturan') }}" class="{{ request()->routeIs('admin.pengaturan') ? 'on' : '' }}"><svg><use href="#i-gerigi"/></svg>Pengaturan Situs</a>
      @endif
    </nav>
    <div class="tumpal" aria-hidden="true"></div>
  </aside>

  <div class="kolom-utama">
    <header class="topbar">
      <button class="burger" type="button" id="burger" aria-controls="sidebar" aria-expanded="false" aria-label="Buka menu"><span></span><span></span><span></span></button>
      <div class="tb-judul">
        @isset($crumb)<p class="crumb">{!! $crumb !!}</p>@endisset
        <h1>{{ $judul ?? 'Panel Admin' }}</h1>
      </div>
      <a class="tb-link" href="{{ route('home') }}" target="_blank" rel="noopener"><svg><use href="#i-situs"/></svg><span>Lihat situs</span></a>
      <details class="akun">
        <summary><span class="avatar">{{ mb_strtoupper(mb_substr($u->name, 0, 1)) }}</span><span class="akun-nama"><b>{{ $u->name }}</b><small class="peran {{ $u->role }}">{{ $u->roleLabel() }}</small></span></summary>
        <div class="akun-menu">
          <a href="{{ route('admin.profil') }}"><svg><use href="#i-pengguna"/></svg>Profil &amp; kata sandi</a>
          <form method="post" action="{{ route('admin.logout') }}">@csrf<button type="submit"><svg><use href="#i-keluar"/></svg>Keluar</button></form>
        </div>
      </details>
    </header>

    <main class="konten">
      @if(session('ok'))<div class="flash ok" role="status">{{ session('ok') }}</div>@endif
      @if($errors->any())<div class="flash galat" role="alert"><b>Periksa kembali isian berikut:</b><ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
      @yield('isi')
    </main>
    <footer class="kaki">Om Shanti Shanti Shanti Om · {{ situs('nama_situs') }} · Masuk sebagai {{ $u->roleLabel() }}</footer>
  </div>
</div>
<script src="{{ asset('js/admin.js') }}?v={{ filemtime(public_path('js/admin.js')) }}" defer></script>
</body>
</html>
