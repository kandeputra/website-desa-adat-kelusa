<?php

/*
|--------------------------------------------------------------------------
| Modul panel admin
|--------------------------------------------------------------------------
| peran: 'admin'        → bisa dikelola Admin dan Super Admin
|        'super_admin'  → hanya Super Admin
|
| Tipe field: text, textarea, markdown, number, select, date, datetime,
|             image, file, url, checkbox, slug, tampil (hanya dibaca)
*/

use App\Models;

$postFields = fn (bool $unggulan = false, array $kategori = []) => array_values(array_filter([
    ['nama' => 'title', 'label' => 'Judul', 'tipe' => 'text', 'wajib' => true, 'aturan' => 'max:200'],
    ['nama' => 'slug', 'label' => 'Alamat (slug)', 'tipe' => 'slug', 'dari' => 'title', 'bantuan' => 'Kosongkan agar dibuat otomatis dari judul.'],
    ['nama' => 'kategori', 'label' => 'Kategori', 'tipe' => 'text', 'saran' => $kategori, 'lebar' => 'setengah'],
    ['nama' => 'status', 'label' => 'Status', 'tipe' => 'select', 'opsi' => ['terbit' => 'Terbit', 'draf' => 'Draf'], 'wajib' => true, 'lebar' => 'setengah'],
    ['nama' => 'published_at', 'label' => 'Tanggal terbit', 'tipe' => 'datetime', 'lebar' => 'setengah', 'bantuan' => 'Kosongkan untuk terbit sekarang. Isi tanggal mendatang untuk menjadwalkan.'],
    $unggulan ? ['nama' => 'unggulan', 'label' => 'Jadikan berita utama di beranda', 'tipe' => 'checkbox', 'lebar' => 'setengah'] : null,
    ['nama' => 'excerpt', 'label' => 'Ringkasan', 'tipe' => 'textarea', 'baris' => 3, 'aturan' => 'max:400', 'bantuan' => 'Satu-dua kalimat yang tampil di kartu dan hasil pencarian.'],
    ['nama' => 'cover', 'label' => 'Gambar sampul', 'tipe' => 'image'],
    ['nama' => 'body', 'label' => 'Isi', 'tipe' => 'markdown', 'wajib' => true],
]));

$postModul = fn (string $type, string $label, string $tunggal, bool $unggulan, array $kategori, string $ikon) => [
    'label' => $label, 'tunggal' => $tunggal, 'grup' => 'Konten', 'ikon' => $ikon, 'peran' => 'admin',
    'model' => Models\Post::class, 'where' => ['type' => $type], 'set' => ['type' => $type], 'penulis' => true,
    'urut' => ['published_at', 'desc'], 'cari' => ['title', 'excerpt', 'body'],
    'filter' => ['status' => ['terbit' => 'Terbit', 'draf' => 'Draf']],
    'kolom' => ['title' => 'Judul', 'kategori' => 'Kategori', 'status' => 'Status', 'published_at' => 'Terbit', 'views' => 'Dibaca'],
    'publik' => $type.'.show',
    'fields' => $postFields($unggulan, $kategori),
];

return [
    'modul' => [
        // ================= Konten (Admin & Super Admin) =================
        'berita' => $postModul('berita', 'Berita', 'berita', true, ['Paruman', 'Parahyangan', 'Pawongan', 'Palemahan', 'Yowana', 'LPD', 'Kegiatan'], 'koran'),
        'pengumuman' => $postModul('pengumuman', 'Pengumuman', 'pengumuman', false, [], 'toa'),
        'artikel' => $postModul('artikel', 'Budaya & Tradisi', 'artikel', false, ['Parahyangan', 'Tradisi', 'Rerahinan', 'Sejarah'], 'lontar'),

        'agenda' => [
            'label' => 'Agenda Desa', 'tunggal' => 'agenda', 'grup' => 'Konten', 'ikon' => 'kalender', 'peran' => 'admin',
            'model' => Models\Agenda::class, 'urut' => ['mulai', 'desc'], 'cari' => ['judul', 'lokasi'],
            'kolom' => ['judul' => 'Kegiatan', 'mulai' => 'Waktu', 'lokasi' => 'Lokasi'],
            'fields' => [
                ['nama' => 'judul', 'label' => 'Nama kegiatan', 'tipe' => 'text', 'wajib' => true],
                ['nama' => 'mulai', 'label' => 'Waktu mulai', 'tipe' => 'datetime', 'wajib' => true, 'lebar' => 'setengah'],
                ['nama' => 'lokasi', 'label' => 'Lokasi', 'tipe' => 'text', 'lebar' => 'setengah'],
                ['nama' => 'keterangan', 'label' => 'Keterangan', 'tipe' => 'textarea', 'baris' => 3],
            ],
        ],

        'galeri' => [
            'label' => 'Galeri', 'tunggal' => 'item galeri', 'grup' => 'Konten', 'ikon' => 'foto', 'peran' => 'admin',
            'model' => Models\Galeri::class, 'urut' => ['created_at', 'desc'], 'cari' => ['judul'],
            'filter' => ['jenis' => ['foto' => 'Foto', 'video' => 'Video']],
            'kolom' => ['gambar' => 'Pratinjau', 'judul' => 'Judul', 'jenis' => 'Jenis', 'tanggal' => 'Tanggal'],
            'fields' => [
                ['nama' => 'jenis', 'label' => 'Jenis', 'tipe' => 'select', 'opsi' => ['foto' => 'Foto', 'video' => 'Video YouTube'], 'wajib' => true, 'lebar' => 'setengah'],
                ['nama' => 'tanggal', 'label' => 'Tanggal', 'tipe' => 'date', 'lebar' => 'setengah'],
                ['nama' => 'judul', 'label' => 'Judul / keterangan', 'tipe' => 'text', 'wajib' => true],
                ['nama' => 'gambar', 'label' => 'Foto', 'tipe' => 'image', 'bantuan' => 'Wajib untuk jenis Foto.'],
                ['nama' => 'url_video', 'label' => 'Tautan YouTube', 'tipe' => 'url', 'bantuan' => 'Untuk jenis Video, mis. https://youtu.be/xxxx'],
            ],
        ],

        'wisata' => [
            'label' => 'Objek Wisata', 'tunggal' => 'objek wisata', 'grup' => 'Konten', 'ikon' => 'pin', 'peran' => 'admin',
            'model' => Models\Wisata::class, 'urut' => ['urutan', 'asc'], 'cari' => ['nama', 'kategori'],
            'kolom' => ['gambar' => 'Gambar', 'nama' => 'Nama', 'kategori' => 'Kategori', 'urutan' => 'Urutan'],
            'publik' => 'wisata.show',
            'fields' => [
                ['nama' => 'nama', 'label' => 'Nama', 'tipe' => 'text', 'wajib' => true],
                ['nama' => 'slug', 'label' => 'Alamat (slug)', 'tipe' => 'slug', 'dari' => 'nama'],
                ['nama' => 'kategori', 'label' => 'Kategori', 'tipe' => 'text', 'saran' => ['Wisata spiritual', 'Air suci', 'Alam', 'Budaya', 'Kuliner'], 'lebar' => 'setengah'],
                ['nama' => 'urutan', 'label' => 'Urutan tampil', 'tipe' => 'number', 'lebar' => 'setengah'],
                ['nama' => 'ringkasan', 'label' => 'Ringkasan', 'tipe' => 'textarea', 'baris' => 2, 'aturan' => 'max:255'],
                ['nama' => 'gambar', 'label' => 'Gambar', 'tipe' => 'image'],
                ['nama' => 'deskripsi', 'label' => 'Deskripsi lengkap', 'tipe' => 'markdown'],
            ],
        ],

        'faq' => [
            'label' => 'Tanya Jawab', 'tunggal' => 'pertanyaan', 'grup' => 'Konten', 'ikon' => 'tanya', 'peran' => 'admin',
            'model' => Models\Faq::class, 'urut' => ['urutan', 'asc'], 'cari' => ['pertanyaan', 'jawaban'],
            'kolom' => ['pertanyaan' => 'Pertanyaan', 'urutan' => 'Urutan'],
            'fields' => [
                ['nama' => 'pertanyaan', 'label' => 'Pertanyaan', 'tipe' => 'text', 'wajib' => true],
                ['nama' => 'jawaban', 'label' => 'Jawaban', 'tipe' => 'textarea', 'wajib' => true, 'baris' => 5],
                ['nama' => 'urutan', 'label' => 'Urutan', 'tipe' => 'number', 'lebar' => 'setengah'],
            ],
        ],

        'perpustakaan' => [
            'label' => 'Perpustakaan Digital', 'tunggal' => 'dokumen', 'grup' => 'Konten', 'ikon' => 'buku', 'peran' => 'admin',
            'model' => Models\Dokumen::class, 'urut' => ['tahun', 'desc'], 'cari' => ['judul', 'sumber'],
            'kolom' => ['judul' => 'Judul', 'sumber' => 'Sumber', 'tahun' => 'Tahun'],
            'fields' => [
                ['nama' => 'judul', 'label' => 'Judul', 'tipe' => 'text', 'wajib' => true],
                ['nama' => 'sumber', 'label' => 'Sumber / penerbit', 'tipe' => 'text', 'lebar' => 'setengah'],
                ['nama' => 'tahun', 'label' => 'Tahun', 'tipe' => 'text', 'lebar' => 'setengah', 'aturan' => 'max:10'],
                ['nama' => 'url', 'label' => 'Tautan daring', 'tipe' => 'url'],
                ['nama' => 'file', 'label' => 'Berkas (PDF/DOC)', 'tipe' => 'file'],
            ],
        ],

        'prestasi' => [
            'label' => 'Prestasi', 'tunggal' => 'prestasi', 'grup' => 'Konten', 'ikon' => 'piala', 'peran' => 'admin',
            'model' => Models\Prestasi::class, 'urut' => ['tahun', 'desc'], 'cari' => ['judul'],
            'kolom' => ['tahun' => 'Tahun', 'judul' => 'Prestasi', 'keterangan' => 'Keterangan'],
            'fields' => [
                ['nama' => 'judul', 'label' => 'Nama prestasi', 'tipe' => 'text', 'wajib' => true],
                ['nama' => 'tahun', 'label' => 'Tahun', 'tipe' => 'text', 'lebar' => 'setengah', 'aturan' => 'max:10'],
                ['nama' => 'keterangan', 'label' => 'Keterangan', 'tipe' => 'text', 'bantuan' => 'Lembaga pemberi, tingkat, peringkat.'],
            ],
        ],

        // ================= Layanan =================
        'pengaduan' => [
            'label' => 'Pengaduan Krama', 'tunggal' => 'pengaduan', 'grup' => 'Layanan', 'ikon' => 'pesan', 'peran' => 'admin',
            'model' => Models\Pengaduan::class, 'urut' => ['created_at', 'desc'], 'cari' => ['kode', 'nama', 'isi'],
            'tambah' => false, 'petugas' => true,
            'filter' => ['status' => ['baru' => 'Baru', 'diproses' => 'Diproses', 'selesai' => 'Selesai']],
            'kolom' => ['kode' => 'Kode', 'nama' => 'Pengirim', 'jenis' => 'Jenis', 'status' => 'Status', 'created_at' => 'Masuk'],
            'fields' => [
                ['nama' => 'kode', 'label' => 'Kode tiket', 'tipe' => 'tampil', 'lebar' => 'setengah'],
                ['nama' => 'created_at', 'label' => 'Dikirim', 'tipe' => 'tampil', 'lebar' => 'setengah'],
                ['nama' => 'nama', 'label' => 'Pengirim', 'tipe' => 'tampil', 'lebar' => 'setengah'],
                ['nama' => 'banjar', 'label' => 'Banjar', 'tipe' => 'tampil', 'lebar' => 'setengah'],
                ['nama' => 'kontak', 'label' => 'Kontak', 'tipe' => 'tampil', 'lebar' => 'setengah'],
                ['nama' => 'jenis', 'label' => 'Jenis', 'tipe' => 'tampil', 'lebar' => 'setengah'],
                ['nama' => 'isi', 'label' => 'Isi pengaduan', 'tipe' => 'tampil'],
                ['nama' => 'status', 'label' => 'Status', 'tipe' => 'select', 'opsi' => ['baru' => 'Baru', 'diproses' => 'Diproses', 'selesai' => 'Selesai'], 'wajib' => true, 'lebar' => 'setengah'],
                ['nama' => 'tanggapan', 'label' => 'Tanggapan prajuru', 'tipe' => 'textarea', 'baris' => 5, 'bantuan' => 'Tanggapan ini dapat dibaca pengirim melalui kode tiket.'],
            ],
        ],

        // ================= Data resmi (Super Admin) =================
        'prajuru' => [
            'label' => 'Prajuru', 'tunggal' => 'prajuru', 'grup' => 'Data Resmi', 'ikon' => 'mahkota', 'peran' => 'super_admin',
            'model' => Models\Prajuru::class, 'urut' => ['urutan', 'asc'], 'cari' => ['jabatan', 'nama'],
            'kolom' => ['foto' => 'Foto', 'jabatan' => 'Jabatan', 'nama' => 'Nama', 'urutan' => 'Urutan'],
            'fields' => [
                ['nama' => 'jabatan', 'label' => 'Jabatan', 'tipe' => 'text', 'wajib' => true, 'lebar' => 'setengah'],
                ['nama' => 'nama', 'label' => 'Nama pejabat', 'tipe' => 'text', 'lebar' => 'setengah'],
                ['nama' => 'keterangan', 'label' => 'Keterangan', 'tipe' => 'text', 'lebar' => 'setengah'],
                ['nama' => 'urutan', 'label' => 'Urutan', 'tipe' => 'number', 'lebar' => 'setengah'],
                ['nama' => 'foto', 'label' => 'Foto', 'tipe' => 'image'],
            ],
        ],

        'banjar' => [
            'label' => 'Banjar & Demografi', 'tunggal' => 'banjar', 'grup' => 'Data Resmi', 'ikon' => 'rumah', 'peran' => 'super_admin',
            'model' => Models\Banjar::class, 'urut' => ['urutan', 'asc'], 'cari' => ['nama', 'kelian'],
            'kolom' => ['nama' => 'Banjar', 'kelian' => 'Kelian', 'jumlah_kk' => 'KK', 'krama_desa' => 'Krama desa', 'krama_tamiu' => 'Krama tamiu', 'tamiu' => 'Tamiu'],
            'fields' => [
                ['nama' => 'nama', 'label' => 'Nama banjar', 'tipe' => 'text', 'wajib' => true, 'lebar' => 'setengah'],
                ['nama' => 'kelian', 'label' => 'Kelian banjar', 'tipe' => 'text', 'lebar' => 'setengah'],
                ['nama' => 'jumlah_kk', 'label' => 'Jumlah KK', 'tipe' => 'number', 'lebar' => 'setengah'],
                ['nama' => 'krama_desa', 'label' => 'Krama desa (jiwa)', 'tipe' => 'number', 'lebar' => 'setengah'],
                ['nama' => 'krama_tamiu', 'label' => 'Krama tamiu (jiwa)', 'tipe' => 'number', 'lebar' => 'setengah'],
                ['nama' => 'tamiu', 'label' => 'Tamiu (jiwa)', 'tipe' => 'number', 'lebar' => 'setengah'],
                ['nama' => 'urutan', 'label' => 'Urutan', 'tipe' => 'number', 'lebar' => 'setengah'],
            ],
        ],

        'lembaga' => [
            'label' => 'Lembaga Adat', 'tunggal' => 'lembaga', 'grup' => 'Data Resmi', 'ikon' => 'orang', 'peran' => 'super_admin',
            'model' => Models\Lembaga::class, 'urut' => ['urutan', 'asc'], 'cari' => ['nama', 'nama_lengkap', 'ketua'],
            'kolom' => ['nama' => 'Lembaga', 'nama_lengkap' => 'Keterangan', 'ketua' => 'Ketua', 'urutan' => 'Urutan'],
            'publik' => 'lembaga.show',
            'fields' => [
                ['nama' => 'nama', 'label' => 'Nama lembaga', 'tipe' => 'text', 'wajib' => true, 'lebar' => 'setengah'],
                ['nama' => 'nama_lengkap', 'label' => 'Nama lengkap / keterangan', 'tipe' => 'text', 'lebar' => 'setengah'],
                ['nama' => 'slug', 'label' => 'Alamat (slug)', 'tipe' => 'slug', 'dari' => 'nama'],
                ['nama' => 'deskripsi', 'label' => 'Deskripsi', 'tipe' => 'textarea', 'baris' => 4],
                ['nama' => 'tugas', 'label' => 'Tugas & kegiatan', 'tipe' => 'textarea', 'baris' => 5, 'bantuan' => 'Satu tugas per baris.'],
                ['nama' => 'ketua', 'label' => 'Ketua', 'tipe' => 'text', 'lebar' => 'setengah'],
                ['nama' => 'kontak', 'label' => 'Kontak', 'tipe' => 'text', 'lebar' => 'setengah'],
                ['nama' => 'sekretariat', 'label' => 'Sekretariat', 'tipe' => 'text', 'lebar' => 'setengah'],
                ['nama' => 'urutan', 'label' => 'Urutan', 'tipe' => 'number', 'lebar' => 'setengah'],
                ['nama' => 'foto', 'label' => 'Foto / logo', 'tipe' => 'image'],
            ],
        ],

        'produk-hukum' => [
            'label' => 'Produk Hukum', 'tunggal' => 'produk hukum', 'grup' => 'Data Resmi', 'ikon' => 'timbangan', 'peran' => 'super_admin',
            'model' => Models\ProdukHukum::class, 'urut' => ['tahun', 'desc'], 'cari' => ['judul', 'keterangan'],
            'filter' => ['jenis' => ['Awig-awig' => 'Awig-awig', 'Pararem' => 'Pararem', 'Keputusan Prajuru' => 'Keputusan Prajuru']],
            'kolom' => ['jenis' => 'Jenis', 'judul' => 'Judul', 'tahun' => 'Tahun', 'file' => 'Berkas'],
            'fields' => [
                ['nama' => 'jenis', 'label' => 'Jenis', 'tipe' => 'select', 'opsi' => ['Awig-awig' => 'Awig-awig', 'Pararem' => 'Pararem', 'Keputusan Prajuru' => 'Keputusan Prajuru'], 'wajib' => true, 'lebar' => 'setengah'],
                ['nama' => 'tahun', 'label' => 'Tahun', 'tipe' => 'text', 'lebar' => 'setengah', 'aturan' => 'max:10'],
                ['nama' => 'judul', 'label' => 'Judul', 'tipe' => 'text', 'wajib' => true],
                ['nama' => 'keterangan', 'label' => 'Keterangan', 'tipe' => 'text'],
                ['nama' => 'file', 'label' => 'Berkas (PDF)', 'tipe' => 'file'],
            ],
        ],

        'laporan-keuangan' => [
            'label' => 'Laporan Keuangan', 'tunggal' => 'baris laporan', 'grup' => 'Data Resmi', 'ikon' => 'koin', 'peran' => 'super_admin',
            'model' => Models\LaporanKeuangan::class, 'urut' => ['tahun', 'desc'], 'urut2' => ['urutan', 'asc'], 'cari' => ['uraian'],
            'filter' => ['kelompok' => ['Pendapatan' => 'Pendapatan', 'Belanja' => 'Belanja']],
            'kolom' => ['tahun' => 'Tahun', 'kelompok' => 'Kelompok', 'uraian' => 'Uraian', 'jumlah' => 'Jumlah (Rp)'],
            'fields' => [
                ['nama' => 'tahun', 'label' => 'Tahun anggaran', 'tipe' => 'number', 'wajib' => true, 'lebar' => 'setengah'],
                ['nama' => 'kelompok', 'label' => 'Kelompok', 'tipe' => 'select', 'opsi' => ['Pendapatan' => 'Pendapatan', 'Belanja' => 'Belanja'], 'wajib' => true, 'lebar' => 'setengah'],
                ['nama' => 'uraian', 'label' => 'Uraian', 'tipe' => 'text', 'wajib' => true],
                ['nama' => 'jumlah', 'label' => 'Jumlah (Rupiah)', 'tipe' => 'number', 'lebar' => 'setengah', 'bantuan' => 'Angka saja, tanpa titik.'],
                ['nama' => 'urutan', 'label' => 'Urutan', 'tipe' => 'number', 'lebar' => 'setengah'],
                ['nama' => 'keterangan', 'label' => 'Keterangan', 'tipe' => 'text'],
            ],
        ],

        'program' => [
            'label' => 'Perencanaan & Pembangunan', 'tunggal' => 'program', 'grup' => 'Data Resmi', 'ikon' => 'bangun', 'peran' => 'super_admin',
            'model' => Models\Program::class, 'urut' => ['tahun', 'desc'], 'cari' => ['judul', 'keterangan'],
            'filter' => ['jenis' => ['perencanaan' => 'Perencanaan', 'pembangunan' => 'Pembangunan']],
            'kolom' => ['jenis' => 'Jenis', 'bidang' => 'Bidang', 'judul' => 'Program', 'status' => 'Status', 'tahun' => 'Tahun'],
            'fields' => [
                ['nama' => 'jenis', 'label' => 'Jenis laporan', 'tipe' => 'select', 'opsi' => ['perencanaan' => 'Perencanaan', 'pembangunan' => 'Pembangunan'], 'wajib' => true, 'lebar' => 'setengah'],
                ['nama' => 'bidang', 'label' => 'Bidang', 'tipe' => 'select', 'opsi' => ['Parahyangan' => 'Parahyangan', 'Pawongan' => 'Pawongan', 'Palemahan' => 'Palemahan'], 'wajib' => true, 'lebar' => 'setengah'],
                ['nama' => 'judul', 'label' => 'Nama program', 'tipe' => 'text', 'wajib' => true],
                ['nama' => 'keterangan', 'label' => 'Keterangan', 'tipe' => 'text'],
                ['nama' => 'status', 'label' => 'Status', 'tipe' => 'select', 'opsi' => ['Rencana' => 'Rencana', 'Berjalan' => 'Berjalan', 'Selesai' => 'Selesai'], 'wajib' => true, 'lebar' => 'setengah'],
                ['nama' => 'tahun', 'label' => 'Tahun', 'tipe' => 'number', 'lebar' => 'setengah'],
                ['nama' => 'anggaran', 'label' => 'Anggaran (Rupiah)', 'tipe' => 'number', 'lebar' => 'setengah'],
            ],
        ],
    ],
];
