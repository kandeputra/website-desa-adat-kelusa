<?php

namespace App\Support;

use Carbon\CarbonImmutable;

/**
 * Kalender pawukon Bali (siklus 210 hari).
 * Jangkar: Galungan, Buda Kliwon Dungulan, 17 Juni 2026.
 */
class Pawukon
{
    public const WUKU = ['Sinta','Landep','Ukir','Kulantir','Tolu','Gumbreg','Wariga','Warigadean','Julungwangi','Sungsang','Dungulan','Kuningan','Langkir','Medangsia','Pujut','Pahang','Krulut','Merakih','Tambir','Medangkungan','Matal','Uye','Menail','Prangbakat','Bala','Ugu','Wayang','Kelawu','Dukut','Watugunung'];
    public const SAPTAWARA = ['Redite','Soma','Anggara','Buda','Wraspati','Sukra','Saniscara'];
    public const PANCAWARA = ['Umanis','Paing','Pon','Wage','Kliwon'];
    public const HARI = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
    public const BULAN = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

    /** offset hari dari Galungan */
    public const RERAHINAN = [
        ['o' => -74, 'n' => 'Saraswati', 'd' => 'Hari turunnya ilmu pengetahuan.'],
        ['o' => -70, 'n' => 'Pagerwesi', 'd' => 'Memohon keteguhan iman dan perlindungan.'],
        ['o' => -60, 'n' => 'Tumpek Landep', 'd' => 'Upacara untuk benda tajam dan logam.'],
        ['o' => -25, 'n' => 'Tumpek Wariga', 'd' => 'Persembahan bagi tumbuh-tumbuhan.'],
        ['o' => 0,   'n' => 'Galungan', 'd' => 'Kemenangan dharma atas adharma.'],
        ['o' => 10,  'n' => 'Kuningan', 'd' => 'Bertepatan dengan rangkaian Piodalan Pura Hyang Api.', 'api' => true],
        ['o' => 45,  'n' => 'Tumpek Krulut', 'd' => 'Persembahan untuk gamelan dan kesenian.'],
        ['o' => 80,  'n' => 'Tumpek Kandang', 'd' => 'Hari hewan ternak, erat dengan Pura Hyang Api.', 'api' => true],
        ['o' => 115, 'n' => 'Tumpek Wayang', 'd' => 'Persembahan untuk wayang dan seni pertunjukan.'],
    ];

    protected static function anchor(): CarbonImmutable
    {
        return CarbonImmutable::create(2026, 6, 17, 0, 0, 0, config('app.timezone'));
    }

    protected static function selisih(CarbonImmutable $d): int
    {
        return (int) static::anchor()->diffInDays($d->startOfDay(), false);
    }

    public static function tanggalMasehi(CarbonImmutable $d): string
    {
        return static::HARI[$d->dayOfWeek].', '.$d->day.' '.static::BULAN[$d->month - 1].' '.$d->year;
    }

    public static function tanggalBali(?CarbonImmutable $d = null): string
    {
        $d ??= CarbonImmutable::now();
        $i = static::selisih($d);
        $wuku = static::WUKU[(((10 + intdiv($i + 3 - (($i + 3) % 7 + 7) % 7, 7)) % 30) + 30) % 30];
        $panca = static::PANCAWARA[(((4 + $i) % 5) + 5) % 5];
        return static::SAPTAWARA[$d->dayOfWeek].' '.$panca.' '.$wuku;
    }

    /** @return array<int, array{tanggal: CarbonImmutable, nama: string, ket: string, api: bool, sisa: int}> */
    public static function mendatang(int $jumlah = 6, ?CarbonImmutable $dari = null): array
    {
        $hariIni = ($dari ?? CarbonImmutable::now())->startOfDay();
        $i = static::selisih($hariIni);
        $hasil = [];
        foreach (static::RERAHINAN as $r) {
            $k = (int) ceil(($i - $r['o']) / 210);
            $off = $r['o'] + max(0, $k) * 210;
            if ($off < $i) $off += 210;
            $t = static::anchor()->addDays($off);
            $hasil[] = ['tanggal' => $t, 'nama' => $r['n'], 'ket' => $r['d'], 'api' => $r['api'] ?? false, 'sisa' => $off - $i];
        }
        usort($hasil, fn ($a, $b) => $a['sisa'] <=> $b['sisa']);
        return array_slice($hasil, 0, $jumlah);
    }

    public static function hariIni(): ?string
    {
        $m = static::mendatang(1);
        return ($m[0]['sisa'] ?? 1) === 0 ? $m[0]['nama'] : null;
    }
}
