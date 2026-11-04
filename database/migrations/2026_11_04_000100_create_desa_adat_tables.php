<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Pengaturan situs (identitas, kontak, sambutan, sejarah, visi misi, dll.)
        Schema::create('settings', function (Blueprint $t) {
            $t->id();
            $t->string('key')->unique();
            $t->longText('value')->nullable();
            $t->timestamps();
        });

        // Berita, pengumuman, artikel
        Schema::create('posts', function (Blueprint $t) {
            $t->id();
            $t->string('type', 20)->index(); // berita | pengumuman | artikel
            $t->string('title');
            $t->string('slug')->unique();
            $t->string('kategori')->nullable();
            $t->text('excerpt')->nullable();
            $t->longText('body')->nullable();
            $t->string('cover')->nullable();
            $t->string('status', 10)->default('terbit'); // draf | terbit
            $t->boolean('unggulan')->default(false);
            $t->timestamp('published_at')->nullable()->index();
            $t->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $t->unsignedInteger('views')->default(0);
            $t->timestamps();
        });

        Schema::create('lembagas', function (Blueprint $t) {
            $t->id();
            $t->string('nama');
            $t->string('slug')->unique();
            $t->string('nama_lengkap')->nullable();
            $t->text('deskripsi')->nullable();
            $t->text('tugas')->nullable(); // satu tugas per baris
            $t->string('ketua')->nullable();
            $t->string('sekretariat')->nullable();
            $t->string('kontak')->nullable();
            $t->string('foto')->nullable();
            $t->unsignedInteger('urutan')->default(0);
            $t->timestamps();
        });

        Schema::create('prajurus', function (Blueprint $t) {
            $t->id();
            $t->string('jabatan');
            $t->string('keterangan')->nullable();
            $t->string('nama')->nullable();
            $t->string('foto')->nullable();
            $t->unsignedInteger('urutan')->default(0);
            $t->timestamps();
        });

        Schema::create('banjars', function (Blueprint $t) {
            $t->id();
            $t->string('nama');
            $t->string('kelian')->nullable();
            $t->unsignedInteger('jumlah_kk')->nullable();
            $t->unsignedInteger('krama_desa')->nullable();
            $t->unsignedInteger('krama_tamiu')->nullable();
            $t->unsignedInteger('tamiu')->nullable();
            $t->unsignedInteger('urutan')->default(0);
            $t->timestamps();
        });

        Schema::create('produk_hukums', function (Blueprint $t) {
            $t->id();
            $t->string('jenis', 30); // Awig-awig | Pararem | Keputusan Prajuru
            $t->string('judul');
            $t->string('tahun', 10)->nullable();
            $t->string('keterangan')->nullable();
            $t->string('file')->nullable();
            $t->timestamps();
        });

        Schema::create('dokumens', function (Blueprint $t) {
            $t->id();
            $t->string('judul');
            $t->string('sumber')->nullable();
            $t->string('tahun', 10)->nullable();
            $t->string('url')->nullable();
            $t->string('file')->nullable();
            $t->timestamps();
        });

        Schema::create('galeris', function (Blueprint $t) {
            $t->id();
            $t->string('jenis', 10)->default('foto'); // foto | video
            $t->string('judul');
            $t->string('gambar')->nullable();
            $t->string('url_video')->nullable();
            $t->date('tanggal')->nullable();
            $t->timestamps();
        });

        Schema::create('wisatas', function (Blueprint $t) {
            $t->id();
            $t->string('nama');
            $t->string('slug')->unique();
            $t->string('kategori')->nullable();
            $t->string('ringkasan')->nullable();
            $t->text('deskripsi')->nullable();
            $t->string('gambar')->nullable();
            $t->unsignedInteger('urutan')->default(0);
            $t->timestamps();
        });

        Schema::create('agendas', function (Blueprint $t) {
            $t->id();
            $t->string('judul');
            $t->dateTime('mulai');
            $t->string('lokasi')->nullable();
            $t->text('keterangan')->nullable();
            $t->timestamps();
        });

        Schema::create('faqs', function (Blueprint $t) {
            $t->id();
            $t->string('pertanyaan');
            $t->text('jawaban');
            $t->unsignedInteger('urutan')->default(0);
            $t->timestamps();
        });

        Schema::create('pengaduans', function (Blueprint $t) {
            $t->id();
            $t->string('kode', 20)->unique();
            $t->string('nama');
            $t->string('banjar')->nullable();
            $t->string('kontak')->nullable();
            $t->string('jenis', 40);
            $t->text('isi');
            $t->string('status', 12)->default('baru'); // baru | diproses | selesai
            $t->text('tanggapan')->nullable();
            $t->foreignId('ditangani_oleh')->nullable()->constrained('users')->nullOnDelete();
            $t->timestamps();
        });

        Schema::create('laporan_keuangans', function (Blueprint $t) {
            $t->id();
            $t->unsignedSmallInteger('tahun')->index();
            $t->string('kelompok', 12); // Pendapatan | Belanja
            $t->string('uraian');
            $t->unsignedBigInteger('jumlah')->nullable();
            $t->string('keterangan')->nullable();
            $t->unsignedInteger('urutan')->default(0);
            $t->timestamps();
        });

        Schema::create('programs', function (Blueprint $t) {
            $t->id();
            $t->string('jenis', 12); // perencanaan | pembangunan
            $t->string('bidang', 20); // Parahyangan | Pawongan | Palemahan
            $t->string('judul');
            $t->string('keterangan')->nullable();
            $t->string('status', 12)->default('Rencana'); // Rencana | Berjalan | Selesai
            $t->unsignedSmallInteger('tahun')->nullable();
            $t->unsignedBigInteger('anggaran')->nullable();
            $t->timestamps();
        });

        Schema::create('prestasis', function (Blueprint $t) {
            $t->id();
            $t->string('tahun', 10)->nullable();
            $t->string('judul');
            $t->string('keterangan')->nullable();
            $t->timestamps();
        });
    }

    public function down(): void
    {
        foreach (['prestasis','programs','laporan_keuangans','pengaduans','faqs','agendas','wisatas','galeris','dokumens','produk_hukums','banjars','prajurus','lembagas','posts','settings'] as $t) {
            Schema::dropIfExists($t);
        }
    }
};
