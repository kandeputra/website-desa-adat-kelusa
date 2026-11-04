<?php

namespace Database\Seeders;

use App\Models\{Agenda, Banjar, Dokumen, Faq, Galeri, LaporanKeuangan, Lembaga, Post, Prajuru, Prestasi, ProdukHukum, Program, User, Wisata};
use App\Support\Situs;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ---------- Akun ----------
        $super = User::updateOrCreate(
            ['email' => env('SUPERADMIN_EMAIL', 'superadmin@desaadatkelusa.or.id')],
            ['name' => 'Super Admin', 'password' => env('SUPERADMIN_PASSWORD', 'GantiSandiIni!2026'), 'role' => 'super_admin', 'jabatan' => 'Penyarikan Desa Adat']
        );
        User::updateOrCreate(
            ['email' => 'admin@desaadatkelusa.or.id'],
            ['name' => 'Admin Konten', 'password' => 'AdminKelusa!2026', 'role' => 'admin', 'jabatan' => 'Pengelola informasi']
        );

        // ---------- Pengaturan situs ----------
        Situs::set([
            'nama_situs' => 'Desa Adat Kelusa',
            'wilayah' => 'Kecamatan Payangan · Kabupaten Gianyar · Provinsi Bali',
            'hero_judul' => 'Desa Adat Kelusa',
            'hero_tagline' => 'Pengempon Pura Hyang Api, salah satu pura tertua di Bali, di perbukitan hijau Payangan.',
            'hero_gambar' => null,
            'bendesa_nama' => null,
            'bendesa_masa_bakti' => null,
            'bendesa_foto' => null,
            'sambutan' => "Website ini kami hadirkan sebagai sumber informasi resmi bagi krama desa, krama tamiu, dan masyarakat luas. Di sini tersedia kabar kegiatan, pengumuman paruman, produk hukum adat, serta informasi lembaga dan pura di wewidangan Desa Adat Kelusa.\n\nSemoga keterbukaan informasi ini memperkuat rasa menyama braya dan membantu kita bersama menjaga parahyangan, pawongan, dan palemahan desa.",
            'sejarah' => "Penuturan tetua dan kajian sejarah mengaitkan asal-usul Kelusa dengan dharmayatra dan tirtayatra Maharsi Markandya, resi yang menyebarkan ajaran Siwa di Bali. Di tempat inilah beliau diyakini menanam pohon beringin, dan di kawasan ini pula berdiri Pura Hyang Api.\n\nDesa Kelusa berada di Kecamatan Payangan, Kabupaten Gianyar, dengan luas sekitar 6,5 km². Di wilayah desa dinas Kelusa terdapat tiga desa adat: Desa Adat Kelusa, Desa Adat Keliki Kawan, dan Desa Adat Yeh Tengah. Desa Adat Kelusa mewilayahi empat banjar adat: Ayah, Triwangsa, Roban, dan Peliatan.\n\nKehidupan krama diatur oleh awig-awig desa adat yang disebut *Murdha Gitta*, dilengkapi pararem hasil paruman sesuai kebutuhan zaman.",
            'linimasa' => "± Abad 8 M | Masa Maharsi Markandya | Pura Hyang Api diperkirakan berdiri pada era penyebaran ajaran Siwa di Bali.\nMasa kerajaan | Terbentuknya desa pakraman | Krama Kelusa menjadi pengempon Pura Hyang Api dan Kahyangan Tiga.\n1981 | Awig-awig Murdha Gitta | Awig-awig Desa Pakraman Kelusa dibukukan sebagai pedoman tertulis.\n2019 | Perda Bali No. 4 Tahun 2019 | Desa Pakraman resmi bernama Desa Adat dan diakui sebagai subjek hukum.\nKini | Desa adat yang terbuka | Pelestarian tradisi berjalan seiring layanan krama dan keterbukaan informasi.",
            'visi' => 'Desa Adat Kelusa yang ajeg, sukerta, dan lestari, berlandaskan Tri Hita Karana.',
            'misi' => "Menjaga kesucian dan kelestarian Pura Hyang Api serta Kahyangan Tiga.\nMenegakkan awig-awig dan pararem secara adil dan terbuka.\nMemperkuat kebersamaan krama, sekaa, dan banjar adat.\nMengembangkan ekonomi krama melalui LPD dan BUPDA.\nMelestarikan lingkungan, sawah, dan sumber air wewidangan desa.",
            'luas_wilayah' => '6,50',
            'jumlah_penduduk' => '4.345',
            'tahun_penduduk' => '2014',
            'pura_deskripsi' => "Di pura ini umat memuja Ida Sang Hyang Widhi dalam manifestasi Dewa Agni. Pemedek memohon kerahayuan: kesehatan (*kewarasan*), kelancaran hidup, serta keselamatan hewan ternak (*wewalungan*). Pura ini erat kaitannya dengan rerahinan Tumpek Kandang dan disungsung umat dari berbagai daerah di Bali.\n\nPiodalan jatuh setiap 210 hari bertepatan dengan rangkaian Kuningan, saat tradisi khas **Aci Keburan** digelar di jaba pura.",
            'alamat_sekretariat' => null,
            'telepon_sekretariat' => null,
            'email_sekretariat' => null,
            'jam_layanan' => null,
            'alamat_kantor_desa' => 'Jln. Raya Kelusa, Payangan, Gianyar 80572',
            'telepon_kantor_desa' => '0361 973524',
            'email_kantor_desa' => 'kantordesakelusa@gmail.com',
            'peta_query' => 'Pura Hyang Api Kelusa Payangan Gianyar',
            'facebook' => null, 'instagram' => null, 'tiktok' => null, 'youtube' => null,
        ]);

        // ---------- Prajuru ----------
        foreach ([
            ['Bendesa Adat', 'Pemimpin desa adat'], ['Petajuh', 'Wakil bendesa'], ['Penyarikan', 'Sekretaris'],
            ['Patengen', 'Bendahara'], ['Ketua Sabha Desa', 'Lembaga pertimbangan'], ['Ketua Kertha Desa', 'Penyelesaian wicara adat'],
        ] as $i => [$j, $k]) {
            Prajuru::updateOrCreate(['jabatan' => $j], ['keterangan' => $k, 'urutan' => $i + 1]);
        }

        // ---------- Banjar ----------
        foreach (['Banjar Ayah', 'Banjar Triwangsa', 'Banjar Roban', 'Banjar Peliatan'] as $i => $b) {
            Banjar::updateOrCreate(['nama' => $b], ['urutan' => $i + 1]);
        }

        // ---------- Lembaga ----------
        $lembaga = [
            ['LPD', 'Lembaga Perkreditan Desa', 'Lembaga keuangan milik desa adat yang melayani tabungan dan kredit krama. Sebagian keuntungannya menopang pembangunan dan upacara desa.', "Tabungan dan deposito krama\nKredit usaha dan kebutuhan krama\nKontribusi untuk pembangunan desa adat"],
            ['BUPDA', 'Baga Utsaha Padruwen Desa Adat', 'Badan usaha milik desa adat sesuai Perda Bali No. 4 Tahun 2019, untuk mengelola potensi ekonomi wewidangan desa.', "Mengelola unit usaha desa adat\nMengembangkan potensi wisata dan pertanian\nMenyerap tenaga kerja krama"],
            ['Pecalang', 'Keamanan adat', 'Menjaga keamanan dan ketertiban di wewidangan desa adat, terutama saat upacara di Pura Hyang Api dan Kahyangan Tiga.', "Pengamanan upacara dan piodalan\nPengaturan lalu lintas saat prosesi\nKoordinasi dengan aparat desa dinas"],
            ['Yowana Desa Adat', 'Sekaa Teruna', 'Wadah generasi muda desa adat untuk kegiatan keagamaan, seni, olahraga, dan sosial.', "Ngayah saat upacara\nPembuatan ogoh-ogoh dan penjor\nKegiatan sosial dan lingkungan"],
            ['Sekaa Gong', 'Seni tabuh', 'Pengiring upacara di kahyangan desa dan pelestari seni tabuh Bali.', "Mengiringi piodalan\nLatihan rutin generasi muda\nPentas pada acara desa"],
            ['Sekaa Santi', 'Kidung & dharma gita', 'Melantunkan kidung dan kekawin yang mengiringi rangkaian upacara.', "Kidung saat piodalan\nPembinaan dharma gita\nPengiring upacara pitra dan manusa yadnya"],
            ['Paiketan Pemangku', 'Pinandita desa', 'Wadah para pemangku pura di wewidangan Desa Adat Kelusa.', "Memimpin persembahyangan\nMenjaga tata upacara di pura\nPembinaan pengetahuan agama krama"],
            ['Paiketan Serati', 'Pembuat banten', 'Wadah para serati yang menyiapkan upakara dan banten untuk upacara desa.', "Menyiapkan banten piodalan\nPelatihan membuat banten\nPendampingan upakara krama"],
            ['Paiketan Krama Istri', 'Pasikian Istri', 'Wadah krama istri dalam kegiatan upakara, kesehatan keluarga, dan pemberdayaan ekonomi.', "Ngayah upakara\nKegiatan PKK dan posyandu\nUsaha ekonomi keluarga"],
            ['Banjar Adat', 'Ayah · Triwangsa · Roban · Peliatan', 'Satuan terkecil desa adat tempat krama berkumpul, bermusyawarah, dan ngayah. Banjar juga menjadi tempat pendataan krama tamiu dan tamiu.', "Paruman banjar\nPendataan krama tamiu: KTP, KK, surat keterangan pemilik tempat tinggal, pas foto, kontak darurat\nGotong royong kebersihan"],
            ['Sabha Desa', 'Lembaga pertimbangan desa adat', 'Lembaga yang memberi pertimbangan dan masukan kepada prajuru dalam penyelenggaraan desa adat, sesuai Perda Provinsi Bali No. 4 Tahun 2019. Anggotanya terdiri dari tokoh dan wakil krama yang dipilih melalui paruman.', "Memberi pertimbangan atas rencana kerja dan anggaran desa adat\nIkut membahas rancangan awig-awig dan pararem\nMengawasi pelaksanaan keputusan paruman\nMenampung aspirasi krama dan menyampaikannya kepada prajuru"],
            ['Kertha Desa', 'Penyelesaian wicara adat', 'Lembaga yang menyelesaikan perkara adat (wicara) secara musyawarah berdasarkan awig-awig dan pararem.', "Menerima pengaduan krama\nMediasi wicara adat\nMemberi pertimbangan kepada prajuru"],
        ];
        foreach ($lembaga as $i => [$n, $f, $d, $t]) {
            Lembaga::updateOrCreate(['slug' => Str::slug($n)], ['nama' => $n, 'nama_lengkap' => $f, 'deskripsi' => $d, 'tugas' => $t, 'urutan' => $i + 1]);
        }

        // ---------- Produk hukum & perpustakaan ----------
        ProdukHukum::updateOrCreate(['judul' => 'Awig-awig Murdha Gitta'], ['jenis' => 'Awig-awig', 'tahun' => '1981', 'keterangan' => 'Awig-awig Desa Pakraman Kelusa']);
        foreach ([['Pararem Krama Tamiu dan Tamiu', 'Pendataan dan kewajiban pendatang'], ['Pararem Pelestarian Lingkungan', 'Sampah, sungai, dan alih fungsi lahan'], ['Pararem Pelaksanaan Upacara', 'Tata cara piodalan dan ngayah']] as [$j, $k]) {
            ProdukHukum::updateOrCreate(['judul' => $j], ['jenis' => 'Pararem', 'keterangan' => $k]);
        }
        foreach ([
            ['Tinjauan Makna Keberadaan Pura Hyang Api di Desa Kelusa, Bali', 'Jurnal Lembaran Sejarah, Universitas Gadjah Mada', '2019', 'https://jurnal.ugm.ac.id/lembaran-sejarah/article/view/59521'],
            ['Sejarah Pura Hyang Api di Desa Kelusa, Kecamatan Payangan', 'Jurnal Widyadari, IKIP PGRI Bali', '2019', 'https://ojs.mahadewa.ac.id/index.php/widyadari/article/view/505'],
            ['Pelaksanaan Tradisi Aci Keburan di Pura Hyang Api Desa Pakraman Kelusa', 'Jayapangus Press', null, 'https://jayapanguspress.penerbit.org/index.php/JPAH/article/view/1528'],
            ['Pengembangan Ekowisata Berkelanjutan Desa Kelusa', 'Pendekatan Triple Bottom Line dan Tri Hita Karana', null, 'https://openjournal.unpam.ac.id/index.php/DKP/article/view/38803'],
        ] as [$j, $s, $t, $u]) {
            Dokumen::updateOrCreate(['judul' => $j], ['sumber' => $s, 'tahun' => $t, 'url' => $u]);
        }

        // ---------- Artikel, berita, pengumuman ----------
        $artikel = [
            ['Pura Hyang Api, stana Dewa Agni di Kelusa', 'Parahyangan', 'Salah satu pura kuno di Bali yang diperkirakan ada sejak abad ke-8 Masehi.', "Pura Hyang Api di Desa Kelusa, Kecamatan Payangan, adalah pura kuno yang diperkirakan telah ada sejak abad ke-8 Masehi, pada masa Maharsi Markandya mengembangkan ajaran Siwa di Bali.\n\nDi pura ini umat memuja Ida Sang Hyang Widhi dalam wujud Dewa Agni. Pemedek datang untuk memohon kewarasan (kesehatan), kelancaran hidup, dan keselamatan hewan ternak. Pura ini disungsung tidak hanya oleh krama Kelusa, tetapi juga umat dari berbagai daerah di Bali.\n\nStruktur pura mengikuti konsep Tri Mandala: Utama Mandala (jeroan), Madya Mandala (jaba tengah), dan Nista Mandala (jaba sisi), yang melambangkan tiga alam: bhur, bhuwah, dan swah."],
            ['Aci Keburan saat piodalan Pura Hyang Api', 'Tradisi', 'Tradisi khas yang digelar di jaba pura setiap 210 hari.', "Aci Keburan adalah tradisi khas yang menyertai piodalan Pura Hyang Api. Piodalan berlangsung setiap 210 hari menurut kalender pawukon, bertepatan dengan rangkaian Hari Raya Kuningan.\n\nTradisi ini dilaksanakan di jaba atau halaman luar pura sebagai bagian dari rangkaian upacara (tabuh rah), dan menjadi persembahan khas yang membedakan Pura Hyang Api dari pura lainnya.\n\nKajian tentang tradisi ini merujuk pada awig-awig Desa Pakraman Kelusa, *Murdha Gitta*, yang disusun tahun 1981."],
            ['Tumpek Kandang dan pemujaan di Pura Hyang Api', 'Rerahinan', 'Hari untuk hewan ternak yang erat kaitannya dengan pura di Kelusa.', "Tumpek Kandang jatuh pada Saniscara Kliwon wuku Uye, setiap 210 hari. Pada hari ini umat Hindu Bali menghaturkan persembahan bagi keselamatan hewan peliharaan dan ternak.\n\nBagi krama Kelusa, Tumpek Kandang dikaitkan dengan pemujaan Dewa Agni di Pura Hyang Api, tempat umat memohon keselamatan wewalungan (hewan ternak).\n\nTanggal Tumpek Kandang berikutnya dapat dilihat di halaman Kalender Rerahinan."],
        ];
        foreach ($artikel as $i => [$j, $k, $e, $b]) {
            Post::updateOrCreate(['slug' => Str::slug($j)], ['type' => 'artikel', 'title' => $j, 'kategori' => $k, 'excerpt' => $e, 'body' => $b, 'status' => 'terbit', 'published_at' => now()->subDays(30 + $i), 'user_id' => $super->id]);
        }
        $berita = [
            ['Paruman Desa Adat menjelang Galungan', 'Paruman', 'Pembahasan persiapan ngayah, pembagian tugas antarbanjar, dan rencana penjor desa.', true],
            ['Persiapan Piodalan Pura Hyang Api', 'Parahyangan', 'Jadwal ngayah krama, susunan panitia, dan tata tertib bagi pemedek.', false],
            ['Gotong royong kebersihan wewidangan', 'Palemahan', 'Kerja bakti di jalan desa, area pura, dan saluran air, dikoordinasi kelian banjar.', false],
            ['Yowana desa ikuti pelatihan pecalang', 'Yowana', 'Generasi muda dibekali pengetahuan pengamanan upacara besar.', false],
        ];
        foreach ($berita as $i => [$j, $k, $e, $u]) {
            Post::updateOrCreate(['slug' => Str::slug($j)], ['type' => 'berita', 'title' => $j, 'kategori' => $k, 'excerpt' => $e,
                'body' => $e."\n\n*Ini adalah berita contoh. Ganti atau hapus melalui panel admin.*", 'status' => 'terbit', 'unggulan' => $u, 'published_at' => now()->subDays($i * 3 + 1), 'user_id' => $super->id]);
        }
        foreach ([['Jadwal ngayah persiapan Galungan', 'Berlaku untuk keempat banjar adat'], ['Paruman desa adat', 'Wajib dihadiri kelian banjar dan prajuru'], ['Pendataan ulang krama tamiu', 'Melalui kelian banjar masing-masing'], ['Penutupan jalan saat piodalan', 'Jalan Raya Kelusa di depan Pura Hyang Api']] as $i => [$j, $e]) {
            Post::updateOrCreate(['slug' => Str::slug($j)], ['type' => 'pengumuman', 'title' => $j, 'excerpt' => $e,
                'body' => $e."\n\n*Ini adalah pengumuman contoh. Ganti atau hapus melalui panel admin.*", 'status' => 'terbit', 'published_at' => now()->subDays($i * 2), 'user_id' => $super->id]);
        }

        // ---------- Wisata ----------
        foreach ([
            ['Pura Hyang Api', 'Wisata spiritual', 'Pura kuno pemujaan Dewa Agni di tepi Jalan Raya Kelusa. Masuk dengan pakaian adat dan izin pemangku.'],
            ['Pancoran Solas & Pancoran Susu', 'Air suci', 'Sumber air di kawasan Pura Mengening, wilayah Desa Kelusa, yang dikaji sebagai potensi ekowisata.'],
            ['Sawah & jalan desa', 'Alam', 'Bentang sawah dan subak khas Payangan, cocok untuk jalan kaki atau bersepeda pagi hari.'],
            ['Upacara & kesenian', 'Budaya', 'Saksikan rangkaian piodalan dan kesenian pengiring dengan tetap menghormati kesucian upacara.'],
        ] as $i => [$n, $k, $r]) {
            Wisata::updateOrCreate(['slug' => Str::slug($n)], ['nama' => $n, 'kategori' => $k, 'ringkasan' => $r, 'deskripsi' => $r, 'urutan' => $i + 1]);
        }

        // ---------- FAQ ----------
        foreach ([
            ['Bagaimana cara melapor sebagai krama tamiu atau tamiu?', 'Laporkan diri kepada kelian banjar adat tempat Anda tinggal dengan membawa fotokopi KTP dan Kartu Keluarga, surat keterangan dari pemilik tempat tinggal, pas foto, dan kontak darurat. Besaran iuran mengikuti pararem desa adat.'],
            ['Bagaimana cara menjadi anggota banjar (mipil)?', 'Ajukan permohonan melalui kelian banjar. Permohonan dibahas dalam paruman banjar sesuai awig-awig. Hubungi kelian banjar untuk persyaratan lengkap.'],
            ['Bisakah saya meminta surat keterangan dari desa adat?', 'Bisa. Datang ke sekretariat desa adat dengan surat pengantar dari kelian banjar dan KTP. Untuk surat kependudukan (domisili, pindah, usaha), urus di Kantor Desa (dinas) Kelusa.'],
            ['Apakah wisatawan boleh masuk ke Pura Hyang Api?', 'Boleh untuk bersembahyang atau berkunjung dengan pakaian adat dan sikap sopan. Perempuan yang sedang haid dan orang dalam masa cuntaka tidak memasuki area pura. Saat upacara, ikuti arahan pecalang.'],
            ['Kapan piodalan Pura Hyang Api?', 'Setiap 210 hari bertepatan dengan rangkaian Hari Raya Kuningan. Tanggal terdekat ada di halaman Kalender Rerahinan, dan jadwal resmi diumumkan prajuru.'],
            ['Bagaimana cara mengetahui tindak lanjut pengaduan saya?', 'Setelah mengirim pengaduan, Anda mendapat kode tiket. Masukkan kode itu di halaman Pengaduan untuk melihat status dan tanggapan prajuru.'],
        ] as $i => [$q, $a]) {
            Faq::updateOrCreate(['pertanyaan' => $q], ['jawaban' => $a, 'urutan' => $i + 1]);
        }

        // ---------- Agenda (contoh) ----------
        Agenda::updateOrCreate(['judul' => 'Paruman Desa Adat'], ['mulai' => now()->addDays(5)->setTime(19, 0), 'lokasi' => 'Bale Agung Desa Adat Kelusa', 'keterangan' => 'Contoh agenda. Ubah melalui panel admin.']);
        Agenda::updateOrCreate(['judul' => 'Gotong royong kebersihan pura'], ['mulai' => now()->addDays(9)->setTime(7, 0), 'lokasi' => 'Pura Hyang Api', 'keterangan' => 'Contoh agenda. Ubah melalui panel admin.']);

        // ---------- Laporan, program, prestasi (format awal) ----------
        $th = (int) now()->year;
        foreach ([['Pendapatan', 'Dana Desa Adat (Pemprov Bali)', 'Bantuan keuangan khusus'], ['Pendapatan', 'Kontribusi LPD', 'Bagian laba'], ['Pendapatan', 'Peturunan & iuran krama', 'Sesuai pararem'], ['Pendapatan', 'Dana punia', 'Termasuk piodalan'], ['Belanja', 'Parahyangan (upacara & pura)', null], ['Belanja', 'Pawongan (lembaga & sekaa)', null], ['Belanja', 'Palemahan (lingkungan)', null]] as $i => [$k, $u, $ket]) {
            LaporanKeuangan::updateOrCreate(['tahun' => $th, 'uraian' => $u], ['kelompok' => $k, 'keterangan' => $ket, 'urutan' => $i + 1]);
        }
        foreach ([['perencanaan', 'Parahyangan', 'Rencana upacara dan pemeliharaan pura', 'Termasuk persiapan piodalan Pura Hyang Api'], ['perencanaan', 'Pawongan', 'Pembinaan sekaa, yowana, dan pecalang', 'Pelatihan dan kegiatan rutin'], ['perencanaan', 'Palemahan', 'Program kebersihan dan pelestarian lingkungan', 'Pemilahan sampah dan perawatan sumber air'], ['pembangunan', 'Parahyangan', 'Perbaikan bale di jaba Pura Hyang Api', 'Swadaya krama dan dana punia'], ['pembangunan', 'Palemahan', 'Penataan tempat pemilahan sampah banjar', 'Kerja sama empat banjar adat']] as [$j, $b, $t, $k]) {
            Program::updateOrCreate(['judul' => $t], ['jenis' => $j, 'bidang' => $b, 'keterangan' => $k, 'status' => $j === 'pembangunan' && $b === 'Palemahan' ? 'Berjalan' : 'Rencana', 'tahun' => $th]);
        }
    }
}
