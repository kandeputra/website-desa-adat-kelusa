@include('errors.tampil', ['kode' => 403, 'judulGalat' => 'Akses dibatasi', 'pesan' => $exception->getMessage() ?: 'Anda tidak memiliki izin untuk membuka halaman ini.'])
