-- Database Desa Adat Kelusa (MySQL/MariaDB)
-- Dibuat 2026-11-04 17:11 dari migrasi & seeder. Impor lewat phpMyAdmin.
SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS=0;

create table `users` (`id` bigint unsigned not null auto_increment primary key, `name` varchar(255) not null, `email` varchar(255) not null, `email_verified_at` timestamp null, `password` varchar(255) not null, `role` varchar(20) not null default 'admin', `jabatan` varchar(255) null, `is_active` tinyint(1) not null default '1', `last_login_at` timestamp null, `remember_token` varchar(100) null, `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate 'utf8mb4_unicode_ci';
alter table `users` add unique `users_email_unique`(`email`);
create table `password_reset_tokens` (`email` varchar(255) not null, `token` varchar(255) not null, `created_at` timestamp null, primary key (`email`)) default character set utf8mb4 collate 'utf8mb4_unicode_ci';
create table `sessions` (`id` varchar(255) not null, `user_id` bigint unsigned null, `ip_address` varchar(45) null, `user_agent` text null, `payload` longtext not null, `last_activity` int not null, primary key (`id`)) default character set utf8mb4 collate 'utf8mb4_unicode_ci';
alter table `sessions` add index `sessions_user_id_index`(`user_id`);
alter table `sessions` add index `sessions_last_activity_index`(`last_activity`);
create table `cache` (`key` varchar(255) not null, `value` mediumtext not null, `expiration` int not null, primary key (`key`)) default character set utf8mb4 collate 'utf8mb4_unicode_ci';
create table `cache_locks` (`key` varchar(255) not null, `owner` varchar(255) not null, `expiration` int not null, primary key (`key`)) default character set utf8mb4 collate 'utf8mb4_unicode_ci';
create table `jobs` (`id` bigint unsigned not null auto_increment primary key, `queue` varchar(255) not null, `payload` longtext not null, `attempts` tinyint unsigned not null, `reserved_at` int unsigned null, `available_at` int unsigned not null, `created_at` int unsigned not null) default character set utf8mb4 collate 'utf8mb4_unicode_ci';
alter table `jobs` add index `jobs_queue_index`(`queue`);
create table `job_batches` (`id` varchar(255) not null, `name` varchar(255) not null, `total_jobs` int not null, `pending_jobs` int not null, `failed_jobs` int not null, `failed_job_ids` longtext not null, `options` mediumtext null, `cancelled_at` int null, `created_at` int not null, `finished_at` int null, primary key (`id`)) default character set utf8mb4 collate 'utf8mb4_unicode_ci';
create table `failed_jobs` (`id` bigint unsigned not null auto_increment primary key, `uuid` varchar(255) not null, `connection` text not null, `queue` text not null, `payload` longtext not null, `exception` longtext not null, `failed_at` timestamp not null default CURRENT_TIMESTAMP) default character set utf8mb4 collate 'utf8mb4_unicode_ci';
alter table `failed_jobs` add unique `failed_jobs_uuid_unique`(`uuid`);
create table `settings` (`id` bigint unsigned not null auto_increment primary key, `key` varchar(255) not null, `value` longtext null, `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate 'utf8mb4_unicode_ci';
alter table `settings` add unique `settings_key_unique`(`key`);
create table `posts` (`id` bigint unsigned not null auto_increment primary key, `type` varchar(20) not null, `title` varchar(255) not null, `slug` varchar(255) not null, `kategori` varchar(255) null, `excerpt` text null, `body` longtext null, `cover` varchar(255) null, `status` varchar(10) not null default 'terbit', `unggulan` tinyint(1) not null default '0', `published_at` timestamp null, `user_id` bigint unsigned null, `views` int unsigned not null default '0', `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate 'utf8mb4_unicode_ci';
alter table `posts` add constraint `posts_user_id_foreign` foreign key (`user_id`) references `users` (`id`) on delete set null;
alter table `posts` add index `posts_type_index`(`type`);
alter table `posts` add unique `posts_slug_unique`(`slug`);
alter table `posts` add index `posts_published_at_index`(`published_at`);
create table `lembagas` (`id` bigint unsigned not null auto_increment primary key, `nama` varchar(255) not null, `slug` varchar(255) not null, `nama_lengkap` varchar(255) null, `deskripsi` text null, `tugas` text null, `ketua` varchar(255) null, `sekretariat` varchar(255) null, `kontak` varchar(255) null, `foto` varchar(255) null, `urutan` int unsigned not null default '0', `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate 'utf8mb4_unicode_ci';
alter table `lembagas` add unique `lembagas_slug_unique`(`slug`);
create table `prajurus` (`id` bigint unsigned not null auto_increment primary key, `jabatan` varchar(255) not null, `keterangan` varchar(255) null, `nama` varchar(255) null, `foto` varchar(255) null, `urutan` int unsigned not null default '0', `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate 'utf8mb4_unicode_ci';
create table `banjars` (`id` bigint unsigned not null auto_increment primary key, `nama` varchar(255) not null, `kelian` varchar(255) null, `jumlah_kk` int unsigned null, `krama_desa` int unsigned null, `krama_tamiu` int unsigned null, `tamiu` int unsigned null, `urutan` int unsigned not null default '0', `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate 'utf8mb4_unicode_ci';
create table `produk_hukums` (`id` bigint unsigned not null auto_increment primary key, `jenis` varchar(30) not null, `judul` varchar(255) not null, `tahun` varchar(10) null, `keterangan` varchar(255) null, `file` varchar(255) null, `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate 'utf8mb4_unicode_ci';
create table `dokumens` (`id` bigint unsigned not null auto_increment primary key, `judul` varchar(255) not null, `sumber` varchar(255) null, `tahun` varchar(10) null, `url` varchar(255) null, `file` varchar(255) null, `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate 'utf8mb4_unicode_ci';
create table `galeris` (`id` bigint unsigned not null auto_increment primary key, `jenis` varchar(10) not null default 'foto', `judul` varchar(255) not null, `gambar` varchar(255) null, `url_video` varchar(255) null, `tanggal` date null, `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate 'utf8mb4_unicode_ci';
create table `wisatas` (`id` bigint unsigned not null auto_increment primary key, `nama` varchar(255) not null, `slug` varchar(255) not null, `kategori` varchar(255) null, `ringkasan` varchar(255) null, `deskripsi` text null, `gambar` varchar(255) null, `urutan` int unsigned not null default '0', `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate 'utf8mb4_unicode_ci';
alter table `wisatas` add unique `wisatas_slug_unique`(`slug`);
create table `agendas` (`id` bigint unsigned not null auto_increment primary key, `judul` varchar(255) not null, `mulai` datetime not null, `lokasi` varchar(255) null, `keterangan` text null, `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate 'utf8mb4_unicode_ci';
create table `faqs` (`id` bigint unsigned not null auto_increment primary key, `pertanyaan` varchar(255) not null, `jawaban` text not null, `urutan` int unsigned not null default '0', `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate 'utf8mb4_unicode_ci';
create table `pengaduans` (`id` bigint unsigned not null auto_increment primary key, `kode` varchar(20) not null, `nama` varchar(255) not null, `banjar` varchar(255) null, `kontak` varchar(255) null, `jenis` varchar(40) not null, `isi` text not null, `status` varchar(12) not null default 'baru', `tanggapan` text null, `ditangani_oleh` bigint unsigned null, `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate 'utf8mb4_unicode_ci';
alter table `pengaduans` add constraint `pengaduans_ditangani_oleh_foreign` foreign key (`ditangani_oleh`) references `users` (`id`) on delete set null;
alter table `pengaduans` add unique `pengaduans_kode_unique`(`kode`);
create table `laporan_keuangans` (`id` bigint unsigned not null auto_increment primary key, `tahun` smallint unsigned not null, `kelompok` varchar(12) not null, `uraian` varchar(255) not null, `jumlah` bigint unsigned null, `keterangan` varchar(255) null, `urutan` int unsigned not null default '0', `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate 'utf8mb4_unicode_ci';
alter table `laporan_keuangans` add index `laporan_keuangans_tahun_index`(`tahun`);
create table `programs` (`id` bigint unsigned not null auto_increment primary key, `jenis` varchar(12) not null, `bidang` varchar(20) not null, `judul` varchar(255) not null, `keterangan` varchar(255) null, `status` varchar(12) not null default 'Rencana', `tahun` smallint unsigned null, `anggaran` bigint unsigned null, `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate 'utf8mb4_unicode_ci';
create table `prestasis` (`id` bigint unsigned not null auto_increment primary key, `tahun` varchar(10) null, `judul` varchar(255) not null, `keterangan` varchar(255) null, `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate 'utf8mb4_unicode_ci';
insert into `users` (`email`, `name`, `password`, `role`, `jabatan`, `updated_at`, `created_at`) values ('superadmin@desaadatkelusa.or.id', 'Super Admin', '$2y$12$AwXf4.8ha3h9N6kPj1HUCeuUflyzsT6jNuthXg3ZoHMklyX8W4kri', 'super_admin', 'Penyarikan Desa Adat', '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `users` (`email`, `name`, `password`, `role`, `jabatan`, `updated_at`, `created_at`) values ('admin@desaadatkelusa.or.id', 'Admin Konten', '$2y$12$zjXhVPx7g9Vm24PuQ.WAN.2Cbou1YmpAexT4yLxCOa13bgJXySqha', 'admin', 'Pengelola informasi', '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `settings` (`key`, `value`, `updated_at`, `created_at`) values ('nama_situs', 'Desa Adat Kelusa', '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `settings` (`key`, `value`, `updated_at`, `created_at`) values ('wilayah', 'Kecamatan Payangan · Kabupaten Gianyar · Provinsi Bali', '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `settings` (`key`, `value`, `updated_at`, `created_at`) values ('hero_judul', 'Desa Adat Kelusa', '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `settings` (`key`, `value`, `updated_at`, `created_at`) values ('hero_tagline', 'Pengempon Pura Hyang Api, salah satu pura tertua di Bali, di perbukitan hijau Payangan.', '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `settings` (`key`, `value`, `updated_at`, `created_at`) values ('hero_gambar', null, '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `settings` (`key`, `value`, `updated_at`, `created_at`) values ('bendesa_nama', null, '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `settings` (`key`, `value`, `updated_at`, `created_at`) values ('bendesa_masa_bakti', null, '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `settings` (`key`, `value`, `updated_at`, `created_at`) values ('bendesa_foto', null, '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `settings` (`key`, `value`, `updated_at`, `created_at`) values ('sambutan', 'Website ini kami hadirkan sebagai sumber informasi resmi bagi krama desa, krama tamiu, dan masyarakat luas. Di sini tersedia kabar kegiatan, pengumuman paruman, produk hukum adat, serta informasi lembaga dan pura di wewidangan Desa Adat Kelusa.

Semoga keterbukaan informasi ini memperkuat rasa menyama braya dan membantu kita bersama menjaga parahyangan, pawongan, dan palemahan desa.', '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `settings` (`key`, `value`, `updated_at`, `created_at`) values ('sejarah', 'Penuturan tetua dan kajian sejarah mengaitkan asal-usul Kelusa dengan dharmayatra dan tirtayatra Maharsi Markandya, resi yang menyebarkan ajaran Siwa di Bali. Di tempat inilah beliau diyakini menanam pohon beringin, dan di kawasan ini pula berdiri Pura Hyang Api.

Desa Kelusa berada di Kecamatan Payangan, Kabupaten Gianyar, dengan luas sekitar 6,5 km². Di wilayah desa dinas Kelusa terdapat tiga desa adat: Desa Adat Kelusa, Desa Adat Keliki Kawan, dan Desa Adat Yeh Tengah. Desa Adat Kelusa mewilayahi empat banjar adat: Ayah, Triwangsa, Roban, dan Peliatan.

Kehidupan krama diatur oleh awig-awig desa adat yang disebut *Murdha Gitta*, dilengkapi pararem hasil paruman sesuai kebutuhan zaman.', '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `settings` (`key`, `value`, `updated_at`, `created_at`) values ('linimasa', '± Abad 8 M | Masa Maharsi Markandya | Pura Hyang Api diperkirakan berdiri pada era penyebaran ajaran Siwa di Bali.
Masa kerajaan | Terbentuknya desa pakraman | Krama Kelusa menjadi pengempon Pura Hyang Api dan Kahyangan Tiga.
1981 | Awig-awig Murdha Gitta | Awig-awig Desa Pakraman Kelusa dibukukan sebagai pedoman tertulis.
2019 | Perda Bali No. 4 Tahun 2019 | Desa Pakraman resmi bernama Desa Adat dan diakui sebagai subjek hukum.
Kini | Desa adat yang terbuka | Pelestarian tradisi berjalan seiring layanan krama dan keterbukaan informasi.', '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `settings` (`key`, `value`, `updated_at`, `created_at`) values ('visi', 'Desa Adat Kelusa yang ajeg, sukerta, dan lestari, berlandaskan Tri Hita Karana.', '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `settings` (`key`, `value`, `updated_at`, `created_at`) values ('misi', 'Menjaga kesucian dan kelestarian Pura Hyang Api serta Kahyangan Tiga.
Menegakkan awig-awig dan pararem secara adil dan terbuka.
Memperkuat kebersamaan krama, sekaa, dan banjar adat.
Mengembangkan ekonomi krama melalui LPD dan BUPDA.
Melestarikan lingkungan, sawah, dan sumber air wewidangan desa.', '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `settings` (`key`, `value`, `updated_at`, `created_at`) values ('luas_wilayah', '6,50', '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `settings` (`key`, `value`, `updated_at`, `created_at`) values ('jumlah_penduduk', '4.345', '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `settings` (`key`, `value`, `updated_at`, `created_at`) values ('tahun_penduduk', '2014', '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `settings` (`key`, `value`, `updated_at`, `created_at`) values ('pura_deskripsi', 'Di pura ini umat memuja Ida Sang Hyang Widhi dalam manifestasi Dewa Agni. Pemedek memohon kerahayuan: kesehatan (*kewarasan*), kelancaran hidup, serta keselamatan hewan ternak (*wewalungan*). Pura ini erat kaitannya dengan rerahinan Tumpek Kandang dan disungsung umat dari berbagai daerah di Bali.

Piodalan jatuh setiap 210 hari bertepatan dengan rangkaian Kuningan, saat tradisi khas **Aci Keburan** digelar di jaba pura.', '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `settings` (`key`, `value`, `updated_at`, `created_at`) values ('alamat_sekretariat', null, '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `settings` (`key`, `value`, `updated_at`, `created_at`) values ('telepon_sekretariat', null, '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `settings` (`key`, `value`, `updated_at`, `created_at`) values ('email_sekretariat', null, '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `settings` (`key`, `value`, `updated_at`, `created_at`) values ('jam_layanan', null, '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `settings` (`key`, `value`, `updated_at`, `created_at`) values ('alamat_kantor_desa', 'Jln. Raya Kelusa, Payangan, Gianyar 80572', '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `settings` (`key`, `value`, `updated_at`, `created_at`) values ('telepon_kantor_desa', '0361 973524', '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `settings` (`key`, `value`, `updated_at`, `created_at`) values ('email_kantor_desa', 'kantordesakelusa@gmail.com', '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `settings` (`key`, `value`, `updated_at`, `created_at`) values ('peta_query', 'Pura Hyang Api Kelusa Payangan Gianyar', '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `settings` (`key`, `value`, `updated_at`, `created_at`) values ('facebook', null, '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `settings` (`key`, `value`, `updated_at`, `created_at`) values ('instagram', null, '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `settings` (`key`, `value`, `updated_at`, `created_at`) values ('tiktok', null, '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `settings` (`key`, `value`, `updated_at`, `created_at`) values ('youtube', null, '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `prajurus` (`jabatan`, `keterangan`, `urutan`, `updated_at`, `created_at`) values ('Bendesa Adat', 'Pemimpin desa adat', 1, '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `prajurus` (`jabatan`, `keterangan`, `urutan`, `updated_at`, `created_at`) values ('Petajuh', 'Wakil bendesa', 2, '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `prajurus` (`jabatan`, `keterangan`, `urutan`, `updated_at`, `created_at`) values ('Penyarikan', 'Sekretaris', 3, '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `prajurus` (`jabatan`, `keterangan`, `urutan`, `updated_at`, `created_at`) values ('Patengen', 'Bendahara', 4, '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `prajurus` (`jabatan`, `keterangan`, `urutan`, `updated_at`, `created_at`) values ('Ketua Sabha Desa', 'Lembaga pertimbangan', 5, '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `prajurus` (`jabatan`, `keterangan`, `urutan`, `updated_at`, `created_at`) values ('Ketua Kertha Desa', 'Penyelesaian wicara adat', 6, '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `banjars` (`nama`, `urutan`, `updated_at`, `created_at`) values ('Banjar Ayah', 1, '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `banjars` (`nama`, `urutan`, `updated_at`, `created_at`) values ('Banjar Triwangsa', 2, '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `banjars` (`nama`, `urutan`, `updated_at`, `created_at`) values ('Banjar Roban', 3, '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `banjars` (`nama`, `urutan`, `updated_at`, `created_at`) values ('Banjar Peliatan', 4, '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `lembagas` (`slug`, `nama`, `nama_lengkap`, `deskripsi`, `tugas`, `urutan`, `updated_at`, `created_at`) values ('lpd', 'LPD', 'Lembaga Perkreditan Desa', 'Lembaga keuangan milik desa adat yang melayani tabungan dan kredit krama. Sebagian keuntungannya menopang pembangunan dan upacara desa.', 'Tabungan dan deposito krama
Kredit usaha dan kebutuhan krama
Kontribusi untuk pembangunan desa adat', 1, '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `lembagas` (`slug`, `nama`, `nama_lengkap`, `deskripsi`, `tugas`, `urutan`, `updated_at`, `created_at`) values ('bupda', 'BUPDA', 'Baga Utsaha Padruwen Desa Adat', 'Badan usaha milik desa adat sesuai Perda Bali No. 4 Tahun 2019, untuk mengelola potensi ekonomi wewidangan desa.', 'Mengelola unit usaha desa adat
Mengembangkan potensi wisata dan pertanian
Menyerap tenaga kerja krama', 2, '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `lembagas` (`slug`, `nama`, `nama_lengkap`, `deskripsi`, `tugas`, `urutan`, `updated_at`, `created_at`) values ('pecalang', 'Pecalang', 'Keamanan adat', 'Menjaga keamanan dan ketertiban di wewidangan desa adat, terutama saat upacara di Pura Hyang Api dan Kahyangan Tiga.', 'Pengamanan upacara dan piodalan
Pengaturan lalu lintas saat prosesi
Koordinasi dengan aparat desa dinas', 3, '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `lembagas` (`slug`, `nama`, `nama_lengkap`, `deskripsi`, `tugas`, `urutan`, `updated_at`, `created_at`) values ('yowana-desa-adat', 'Yowana Desa Adat', 'Sekaa Teruna', 'Wadah generasi muda desa adat untuk kegiatan keagamaan, seni, olahraga, dan sosial.', 'Ngayah saat upacara
Pembuatan ogoh-ogoh dan penjor
Kegiatan sosial dan lingkungan', 4, '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `lembagas` (`slug`, `nama`, `nama_lengkap`, `deskripsi`, `tugas`, `urutan`, `updated_at`, `created_at`) values ('sekaa-gong', 'Sekaa Gong', 'Seni tabuh', 'Pengiring upacara di kahyangan desa dan pelestari seni tabuh Bali.', 'Mengiringi piodalan
Latihan rutin generasi muda
Pentas pada acara desa', 5, '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `lembagas` (`slug`, `nama`, `nama_lengkap`, `deskripsi`, `tugas`, `urutan`, `updated_at`, `created_at`) values ('sekaa-santi', 'Sekaa Santi', 'Kidung & dharma gita', 'Melantunkan kidung dan kekawin yang mengiringi rangkaian upacara.', 'Kidung saat piodalan
Pembinaan dharma gita
Pengiring upacara pitra dan manusa yadnya', 6, '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `lembagas` (`slug`, `nama`, `nama_lengkap`, `deskripsi`, `tugas`, `urutan`, `updated_at`, `created_at`) values ('paiketan-pemangku', 'Paiketan Pemangku', 'Pinandita desa', 'Wadah para pemangku pura di wewidangan Desa Adat Kelusa.', 'Memimpin persembahyangan
Menjaga tata upacara di pura
Pembinaan pengetahuan agama krama', 7, '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `lembagas` (`slug`, `nama`, `nama_lengkap`, `deskripsi`, `tugas`, `urutan`, `updated_at`, `created_at`) values ('paiketan-serati', 'Paiketan Serati', 'Pembuat banten', 'Wadah para serati yang menyiapkan upakara dan banten untuk upacara desa.', 'Menyiapkan banten piodalan
Pelatihan membuat banten
Pendampingan upakara krama', 8, '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `lembagas` (`slug`, `nama`, `nama_lengkap`, `deskripsi`, `tugas`, `urutan`, `updated_at`, `created_at`) values ('paiketan-krama-istri', 'Paiketan Krama Istri', 'Pasikian Istri', 'Wadah krama istri dalam kegiatan upakara, kesehatan keluarga, dan pemberdayaan ekonomi.', 'Ngayah upakara
Kegiatan PKK dan posyandu
Usaha ekonomi keluarga', 9, '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `lembagas` (`slug`, `nama`, `nama_lengkap`, `deskripsi`, `tugas`, `urutan`, `updated_at`, `created_at`) values ('banjar-adat', 'Banjar Adat', 'Ayah · Triwangsa · Roban · Peliatan', 'Satuan terkecil desa adat tempat krama berkumpul, bermusyawarah, dan ngayah. Banjar juga menjadi tempat pendataan krama tamiu dan tamiu.', 'Paruman banjar
Pendataan krama tamiu: KTP, KK, surat keterangan pemilik tempat tinggal, pas foto, kontak darurat
Gotong royong kebersihan', 10, '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `lembagas` (`slug`, `nama`, `nama_lengkap`, `deskripsi`, `tugas`, `urutan`, `updated_at`, `created_at`) values ('sabha-desa', 'Sabha Desa', 'Lembaga pertimbangan desa adat', 'Lembaga yang memberi pertimbangan dan masukan kepada prajuru dalam penyelenggaraan desa adat, sesuai Perda Provinsi Bali No. 4 Tahun 2019. Anggotanya terdiri dari tokoh dan wakil krama yang dipilih melalui paruman.', 'Memberi pertimbangan atas rencana kerja dan anggaran desa adat
Ikut membahas rancangan awig-awig dan pararem
Mengawasi pelaksanaan keputusan paruman
Menampung aspirasi krama dan menyampaikannya kepada prajuru', 11, '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `lembagas` (`slug`, `nama`, `nama_lengkap`, `deskripsi`, `tugas`, `urutan`, `updated_at`, `created_at`) values ('kertha-desa', 'Kertha Desa', 'Penyelesaian wicara adat', 'Lembaga yang menyelesaikan perkara adat (wicara) secara musyawarah berdasarkan awig-awig dan pararem.', 'Menerima pengaduan krama
Mediasi wicara adat
Memberi pertimbangan kepada prajuru', 12, '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `produk_hukums` (`judul`, `jenis`, `tahun`, `keterangan`, `updated_at`, `created_at`) values ('Awig-awig Murdha Gitta', 'Awig-awig', '1981', 'Awig-awig Desa Pakraman Kelusa', '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `produk_hukums` (`judul`, `jenis`, `keterangan`, `updated_at`, `created_at`) values ('Pararem Krama Tamiu dan Tamiu', 'Pararem', 'Pendataan dan kewajiban pendatang', '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `produk_hukums` (`judul`, `jenis`, `keterangan`, `updated_at`, `created_at`) values ('Pararem Pelestarian Lingkungan', 'Pararem', 'Sampah, sungai, dan alih fungsi lahan', '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `produk_hukums` (`judul`, `jenis`, `keterangan`, `updated_at`, `created_at`) values ('Pararem Pelaksanaan Upacara', 'Pararem', 'Tata cara piodalan dan ngayah', '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `dokumens` (`judul`, `sumber`, `tahun`, `url`, `updated_at`, `created_at`) values ('Tinjauan Makna Keberadaan Pura Hyang Api di Desa Kelusa, Bali', 'Jurnal Lembaran Sejarah, Universitas Gadjah Mada', '2019', 'https://jurnal.ugm.ac.id/lembaran-sejarah/article/view/59521', '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `dokumens` (`judul`, `sumber`, `tahun`, `url`, `updated_at`, `created_at`) values ('Sejarah Pura Hyang Api di Desa Kelusa, Kecamatan Payangan', 'Jurnal Widyadari, IKIP PGRI Bali', '2019', 'https://ojs.mahadewa.ac.id/index.php/widyadari/article/view/505', '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `dokumens` (`judul`, `sumber`, `tahun`, `url`, `updated_at`, `created_at`) values ('Pelaksanaan Tradisi Aci Keburan di Pura Hyang Api Desa Pakraman Kelusa', 'Jayapangus Press', null, 'https://jayapanguspress.penerbit.org/index.php/JPAH/article/view/1528', '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `dokumens` (`judul`, `sumber`, `tahun`, `url`, `updated_at`, `created_at`) values ('Pengembangan Ekowisata Berkelanjutan Desa Kelusa', 'Pendekatan Triple Bottom Line dan Tri Hita Karana', null, 'https://openjournal.unpam.ac.id/index.php/DKP/article/view/38803', '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `posts` (`slug`, `type`, `title`, `kategori`, `excerpt`, `body`, `status`, `published_at`, `user_id`, `updated_at`, `created_at`) values ('pura-hyang-api-stana-dewa-agni-di-kelusa', 'artikel', 'Pura Hyang Api, stana Dewa Agni di Kelusa', 'Parahyangan', 'Salah satu pura kuno di Bali yang diperkirakan ada sejak abad ke-8 Masehi.', 'Pura Hyang Api di Desa Kelusa, Kecamatan Payangan, adalah pura kuno yang diperkirakan telah ada sejak abad ke-8 Masehi, pada masa Maharsi Markandya mengembangkan ajaran Siwa di Bali.

Di pura ini umat memuja Ida Sang Hyang Widhi dalam wujud Dewa Agni. Pemedek datang untuk memohon kewarasan (kesehatan), kelancaran hidup, dan keselamatan hewan ternak. Pura ini disungsung tidak hanya oleh krama Kelusa, tetapi juga umat dari berbagai daerah di Bali.

Struktur pura mengikuti konsep Tri Mandala: Utama Mandala (jeroan), Madya Mandala (jaba tengah), dan Nista Mandala (jaba sisi), yang melambangkan tiga alam: bhur, bhuwah, dan swah.', 'terbit', '2026-10-05 17:11:16', 1, '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `posts` (`slug`, `type`, `title`, `kategori`, `excerpt`, `body`, `status`, `published_at`, `user_id`, `updated_at`, `created_at`) values ('aci-keburan-saat-piodalan-pura-hyang-api', 'artikel', 'Aci Keburan saat piodalan Pura Hyang Api', 'Tradisi', 'Tradisi khas yang digelar di jaba pura setiap 210 hari.', 'Aci Keburan adalah tradisi khas yang menyertai piodalan Pura Hyang Api. Piodalan berlangsung setiap 210 hari menurut kalender pawukon, bertepatan dengan rangkaian Hari Raya Kuningan.

Tradisi ini dilaksanakan di jaba atau halaman luar pura sebagai bagian dari rangkaian upacara (tabuh rah), dan menjadi persembahan khas yang membedakan Pura Hyang Api dari pura lainnya.

Kajian tentang tradisi ini merujuk pada awig-awig Desa Pakraman Kelusa, *Murdha Gitta*, yang disusun tahun 1981.', 'terbit', '2026-10-04 17:11:16', 1, '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `posts` (`slug`, `type`, `title`, `kategori`, `excerpt`, `body`, `status`, `published_at`, `user_id`, `updated_at`, `created_at`) values ('tumpek-kandang-dan-pemujaan-di-pura-hyang-api', 'artikel', 'Tumpek Kandang dan pemujaan di Pura Hyang Api', 'Rerahinan', 'Hari untuk hewan ternak yang erat kaitannya dengan pura di Kelusa.', 'Tumpek Kandang jatuh pada Saniscara Kliwon wuku Uye, setiap 210 hari. Pada hari ini umat Hindu Bali menghaturkan persembahan bagi keselamatan hewan peliharaan dan ternak.

Bagi krama Kelusa, Tumpek Kandang dikaitkan dengan pemujaan Dewa Agni di Pura Hyang Api, tempat umat memohon keselamatan wewalungan (hewan ternak).

Tanggal Tumpek Kandang berikutnya dapat dilihat di halaman Kalender Rerahinan.', 'terbit', '2026-10-03 17:11:16', 1, '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `posts` (`slug`, `type`, `title`, `kategori`, `excerpt`, `body`, `status`, `unggulan`, `published_at`, `user_id`, `updated_at`, `created_at`) values ('paruman-desa-adat-menjelang-galungan', 'berita', 'Paruman Desa Adat menjelang Galungan', 'Paruman', 'Pembahasan persiapan ngayah, pembagian tugas antarbanjar, dan rencana penjor desa.', 'Pembahasan persiapan ngayah, pembagian tugas antarbanjar, dan rencana penjor desa.

*Ini adalah berita contoh. Ganti atau hapus melalui panel admin.*', 'terbit', 1, '2026-11-03 17:11:16', 1, '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `posts` (`slug`, `type`, `title`, `kategori`, `excerpt`, `body`, `status`, `unggulan`, `published_at`, `user_id`, `updated_at`, `created_at`) values ('persiapan-piodalan-pura-hyang-api', 'berita', 'Persiapan Piodalan Pura Hyang Api', 'Parahyangan', 'Jadwal ngayah krama, susunan panitia, dan tata tertib bagi pemedek.', 'Jadwal ngayah krama, susunan panitia, dan tata tertib bagi pemedek.

*Ini adalah berita contoh. Ganti atau hapus melalui panel admin.*', 'terbit', 0, '2026-10-31 17:11:16', 1, '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `posts` (`slug`, `type`, `title`, `kategori`, `excerpt`, `body`, `status`, `unggulan`, `published_at`, `user_id`, `updated_at`, `created_at`) values ('gotong-royong-kebersihan-wewidangan', 'berita', 'Gotong royong kebersihan wewidangan', 'Palemahan', 'Kerja bakti di jalan desa, area pura, dan saluran air, dikoordinasi kelian banjar.', 'Kerja bakti di jalan desa, area pura, dan saluran air, dikoordinasi kelian banjar.

*Ini adalah berita contoh. Ganti atau hapus melalui panel admin.*', 'terbit', 0, '2026-10-28 17:11:16', 1, '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `posts` (`slug`, `type`, `title`, `kategori`, `excerpt`, `body`, `status`, `unggulan`, `published_at`, `user_id`, `updated_at`, `created_at`) values ('yowana-desa-ikuti-pelatihan-pecalang', 'berita', 'Yowana desa ikuti pelatihan pecalang', 'Yowana', 'Generasi muda dibekali pengetahuan pengamanan upacara besar.', 'Generasi muda dibekali pengetahuan pengamanan upacara besar.

*Ini adalah berita contoh. Ganti atau hapus melalui panel admin.*', 'terbit', 0, '2026-10-25 17:11:16', 1, '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `posts` (`slug`, `type`, `title`, `excerpt`, `body`, `status`, `published_at`, `user_id`, `updated_at`, `created_at`) values ('jadwal-ngayah-persiapan-galungan', 'pengumuman', 'Jadwal ngayah persiapan Galungan', 'Berlaku untuk keempat banjar adat', 'Berlaku untuk keempat banjar adat

*Ini adalah pengumuman contoh. Ganti atau hapus melalui panel admin.*', 'terbit', '2026-11-04 17:11:16', 1, '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `posts` (`slug`, `type`, `title`, `excerpt`, `body`, `status`, `published_at`, `user_id`, `updated_at`, `created_at`) values ('paruman-desa-adat', 'pengumuman', 'Paruman desa adat', 'Wajib dihadiri kelian banjar dan prajuru', 'Wajib dihadiri kelian banjar dan prajuru

*Ini adalah pengumuman contoh. Ganti atau hapus melalui panel admin.*', 'terbit', '2026-11-02 17:11:16', 1, '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `posts` (`slug`, `type`, `title`, `excerpt`, `body`, `status`, `published_at`, `user_id`, `updated_at`, `created_at`) values ('pendataan-ulang-krama-tamiu', 'pengumuman', 'Pendataan ulang krama tamiu', 'Melalui kelian banjar masing-masing', 'Melalui kelian banjar masing-masing

*Ini adalah pengumuman contoh. Ganti atau hapus melalui panel admin.*', 'terbit', '2026-10-31 17:11:16', 1, '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `posts` (`slug`, `type`, `title`, `excerpt`, `body`, `status`, `published_at`, `user_id`, `updated_at`, `created_at`) values ('penutupan-jalan-saat-piodalan', 'pengumuman', 'Penutupan jalan saat piodalan', 'Jalan Raya Kelusa di depan Pura Hyang Api', 'Jalan Raya Kelusa di depan Pura Hyang Api

*Ini adalah pengumuman contoh. Ganti atau hapus melalui panel admin.*', 'terbit', '2026-10-29 17:11:16', 1, '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `wisatas` (`slug`, `nama`, `kategori`, `ringkasan`, `deskripsi`, `urutan`, `updated_at`, `created_at`) values ('pura-hyang-api', 'Pura Hyang Api', 'Wisata spiritual', 'Pura kuno pemujaan Dewa Agni di tepi Jalan Raya Kelusa. Masuk dengan pakaian adat dan izin pemangku.', 'Pura kuno pemujaan Dewa Agni di tepi Jalan Raya Kelusa. Masuk dengan pakaian adat dan izin pemangku.', 1, '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `wisatas` (`slug`, `nama`, `kategori`, `ringkasan`, `deskripsi`, `urutan`, `updated_at`, `created_at`) values ('pancoran-solas-pancoran-susu', 'Pancoran Solas & Pancoran Susu', 'Air suci', 'Sumber air di kawasan Pura Mengening, wilayah Desa Kelusa, yang dikaji sebagai potensi ekowisata.', 'Sumber air di kawasan Pura Mengening, wilayah Desa Kelusa, yang dikaji sebagai potensi ekowisata.', 2, '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `wisatas` (`slug`, `nama`, `kategori`, `ringkasan`, `deskripsi`, `urutan`, `updated_at`, `created_at`) values ('sawah-jalan-desa', 'Sawah & jalan desa', 'Alam', 'Bentang sawah dan subak khas Payangan, cocok untuk jalan kaki atau bersepeda pagi hari.', 'Bentang sawah dan subak khas Payangan, cocok untuk jalan kaki atau bersepeda pagi hari.', 3, '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `wisatas` (`slug`, `nama`, `kategori`, `ringkasan`, `deskripsi`, `urutan`, `updated_at`, `created_at`) values ('upacara-kesenian', 'Upacara & kesenian', 'Budaya', 'Saksikan rangkaian piodalan dan kesenian pengiring dengan tetap menghormati kesucian upacara.', 'Saksikan rangkaian piodalan dan kesenian pengiring dengan tetap menghormati kesucian upacara.', 4, '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `faqs` (`pertanyaan`, `jawaban`, `urutan`, `updated_at`, `created_at`) values ('Bagaimana cara melapor sebagai krama tamiu atau tamiu'Bagaimana cara melapor sebagai krama tamiu atau tamiu'Laporkan diri kepada kelian banjar adat tempat Anda tinggal dengan membawa fotokopi KTP dan Kartu Keluarga, surat keterangan dari pemilik tempat tinggal, pas foto, dan kontak darurat. Besaran iuran mengikuti pararem desa adat.''', 'Laporkan diri kepada kelian banjar adat tempat Anda tinggal dengan membawa fotokopi KTP dan Kartu Keluarga, surat keterangan dari pemilik tempat tinggal, pas foto, dan kontak darurat. Besaran iuran mengikuti pararem desa adat.', 1, '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `faqs` (`pertanyaan`, `jawaban`, `urutan`, `updated_at`, `created_at`) values ('Bagaimana cara menjadi anggota banjar (mipil)'Bagaimana cara menjadi anggota banjar (mipil)'Ajukan permohonan melalui kelian banjar. Permohonan dibahas dalam paruman banjar sesuai awig-awig. Hubungi kelian banjar untuk persyaratan lengkap.''', 'Ajukan permohonan melalui kelian banjar. Permohonan dibahas dalam paruman banjar sesuai awig-awig. Hubungi kelian banjar untuk persyaratan lengkap.', 2, '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `faqs` (`pertanyaan`, `jawaban`, `urutan`, `updated_at`, `created_at`) values ('Bisakah saya meminta surat keterangan dari desa adat'Bisakah saya meminta surat keterangan dari desa adat'Bisa. Datang ke sekretariat desa adat dengan surat pengantar dari kelian banjar dan KTP. Untuk surat kependudukan (domisili, pindah, usaha), urus di Kantor Desa (dinas) Kelusa.''', 'Bisa. Datang ke sekretariat desa adat dengan surat pengantar dari kelian banjar dan KTP. Untuk surat kependudukan (domisili, pindah, usaha), urus di Kantor Desa (dinas) Kelusa.', 3, '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `faqs` (`pertanyaan`, `jawaban`, `urutan`, `updated_at`, `created_at`) values ('Apakah wisatawan boleh masuk ke Pura Hyang Api'Apakah wisatawan boleh masuk ke Pura Hyang Api'Boleh untuk bersembahyang atau berkunjung dengan pakaian adat dan sikap sopan. Perempuan yang sedang haid dan orang dalam masa cuntaka tidak memasuki area pura. Saat upacara, ikuti arahan pecalang.''', 'Boleh untuk bersembahyang atau berkunjung dengan pakaian adat dan sikap sopan. Perempuan yang sedang haid dan orang dalam masa cuntaka tidak memasuki area pura. Saat upacara, ikuti arahan pecalang.', 4, '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `faqs` (`pertanyaan`, `jawaban`, `urutan`, `updated_at`, `created_at`) values ('Kapan piodalan Pura Hyang Api'Kapan piodalan Pura Hyang Api'Setiap 210 hari bertepatan dengan rangkaian Hari Raya Kuningan. Tanggal terdekat ada di halaman Kalender Rerahinan, dan jadwal resmi diumumkan prajuru.''', 'Setiap 210 hari bertepatan dengan rangkaian Hari Raya Kuningan. Tanggal terdekat ada di halaman Kalender Rerahinan, dan jadwal resmi diumumkan prajuru.', 5, '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `faqs` (`pertanyaan`, `jawaban`, `urutan`, `updated_at`, `created_at`) values ('Bagaimana cara mengetahui tindak lanjut pengaduan saya'Bagaimana cara mengetahui tindak lanjut pengaduan saya'Setelah mengirim pengaduan, Anda mendapat kode tiket. Masukkan kode itu di halaman Pengaduan untuk melihat status dan tanggapan prajuru.''', 'Setelah mengirim pengaduan, Anda mendapat kode tiket. Masukkan kode itu di halaman Pengaduan untuk melihat status dan tanggapan prajuru.', 6, '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `agendas` (`judul`, `mulai`, `lokasi`, `keterangan`, `updated_at`, `created_at`) values ('Paruman Desa Adat', '2026-11-09 19:00:00', 'Bale Agung Desa Adat Kelusa', 'Contoh agenda. Ubah melalui panel admin.', '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `agendas` (`judul`, `mulai`, `lokasi`, `keterangan`, `updated_at`, `created_at`) values ('Gotong royong kebersihan pura', '2026-11-13 07:00:00', 'Pura Hyang Api', 'Contoh agenda. Ubah melalui panel admin.', '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `laporan_keuangans` (`tahun`, `uraian`, `kelompok`, `keterangan`, `urutan`, `updated_at`, `created_at`) values (2026, 'Dana Desa Adat (Pemprov Bali)', 'Pendapatan', 'Bantuan keuangan khusus', 1, '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `laporan_keuangans` (`tahun`, `uraian`, `kelompok`, `keterangan`, `urutan`, `updated_at`, `created_at`) values (2026, 'Kontribusi LPD', 'Pendapatan', 'Bagian laba', 2, '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `laporan_keuangans` (`tahun`, `uraian`, `kelompok`, `keterangan`, `urutan`, `updated_at`, `created_at`) values (2026, 'Peturunan & iuran krama', 'Pendapatan', 'Sesuai pararem', 3, '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `laporan_keuangans` (`tahun`, `uraian`, `kelompok`, `keterangan`, `urutan`, `updated_at`, `created_at`) values (2026, 'Dana punia', 'Pendapatan', 'Termasuk piodalan', 4, '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `laporan_keuangans` (`tahun`, `uraian`, `kelompok`, `keterangan`, `urutan`, `updated_at`, `created_at`) values (2026, 'Parahyangan (upacara & pura)', 'Belanja', null, 5, '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `laporan_keuangans` (`tahun`, `uraian`, `kelompok`, `keterangan`, `urutan`, `updated_at`, `created_at`) values (2026, 'Pawongan (lembaga & sekaa)', 'Belanja', null, 6, '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `laporan_keuangans` (`tahun`, `uraian`, `kelompok`, `keterangan`, `urutan`, `updated_at`, `created_at`) values (2026, 'Palemahan (lingkungan)', 'Belanja', null, 7, '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `programs` (`judul`, `jenis`, `bidang`, `keterangan`, `status`, `tahun`, `updated_at`, `created_at`) values ('Rencana upacara dan pemeliharaan pura', 'perencanaan', 'Parahyangan', 'Termasuk persiapan piodalan Pura Hyang Api', 'Rencana', 2026, '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `programs` (`judul`, `jenis`, `bidang`, `keterangan`, `status`, `tahun`, `updated_at`, `created_at`) values ('Pembinaan sekaa, yowana, dan pecalang', 'perencanaan', 'Pawongan', 'Pelatihan dan kegiatan rutin', 'Rencana', 2026, '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `programs` (`judul`, `jenis`, `bidang`, `keterangan`, `status`, `tahun`, `updated_at`, `created_at`) values ('Program kebersihan dan pelestarian lingkungan', 'perencanaan', 'Palemahan', 'Pemilahan sampah dan perawatan sumber air', 'Rencana', 2026, '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `programs` (`judul`, `jenis`, `bidang`, `keterangan`, `status`, `tahun`, `updated_at`, `created_at`) values ('Perbaikan bale di jaba Pura Hyang Api', 'pembangunan', 'Parahyangan', 'Swadaya krama dan dana punia', 'Rencana', 2026, '2026-11-04 17:11:16', '2026-11-04 17:11:16');
insert into `programs` (`judul`, `jenis`, `bidang`, `keterangan`, `status`, `tahun`, `updated_at`, `created_at`) values ('Penataan tempat pemilahan sampah banjar', 'pembangunan', 'Palemahan', 'Kerja sama empat banjar adat', 'Berjalan', 2026, '2026-11-04 17:11:16', '2026-11-04 17:11:16');

CREATE TABLE IF NOT EXISTS `migrations` (`id` int unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY, `migration` varchar(255) NOT NULL, `batch` int NOT NULL) DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('0001_01_01_000000_create_users_table', 1);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('0001_01_01_000001_create_cache_table', 1);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('0001_01_01_000002_create_jobs_table', 1);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2026_11_04_000100_create_desa_adat_tables', 1);

SET FOREIGN_KEY_CHECKS=1;
