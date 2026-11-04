<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="robots" content="noindex,nofollow">
<title>Masuk · Panel Admin {{ situs('nama_situs', 'Desa Adat Kelusa') }}</title>
<link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600&family=Cormorant+Garamond:ital,wght@0,600;1,500&family=Source+Sans+3:wght@400;600;700&display=swap">
<link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ filemtime(public_path('css/admin.css')) }}">
</head>
<body class="hal-masuk">
@include('situs.partials.lambang')
<main class="masuk">
  <section class="masuk-seni" aria-hidden="true">
    <div class="masuk-isi">
      <svg class="lambang besar"><use href="#lambang"/></svg>
      <p class="salam">Om Swastyastu</p>
      <h1>{{ situs('nama_situs', 'Desa Adat Kelusa') }}</h1>
      <p class="tagline">Panel pengelolaan informasi resmi desa adat</p>
    </div>
    <div class="tumpal"></div>
  </section>
  <section class="masuk-form">
    <form method="post" action="{{ route('admin.login.post') }}" class="kartu">
      @csrf
      <p class="eyebrow">Panel Admin</p>
      <h2>Masuk ke akun Anda</h2>
      @if(session('ok'))<div class="flash ok">{{ session('ok') }}</div>@endif
      @error('email')<div class="flash galat">{{ $message }}</div>@enderror
      <div class="field"><label for="email">Email</label><input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"></div>
      <div class="field"><label for="password">Kata sandi</label><input type="password" id="password" name="password" required autocomplete="current-password"></div>
      <label class="cek"><input type="checkbox" name="ingat" value="1"><span>Ingat saya di perangkat ini</span></label>
      <button class="btn utama penuh" type="submit">Masuk</button>
      <a class="tautan" href="{{ route('home') }}">← Kembali ke situs</a>
    </form>
  </section>
</main>
</body>
</html>
