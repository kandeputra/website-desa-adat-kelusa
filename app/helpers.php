<?php

use App\Support\Situs;

if (! function_exists('situs')) {
    function situs(string $key, $default = null) { return Situs::get($key, $default); }
}

if (! function_exists('unggahan')) {
    /** URL publik berkas unggahan, atau null */
    function unggahan(?string $path): ?string { return $path ? asset('uploads/'.ltrim($path, '/')) : null; }
}

if (! function_exists('rupiah')) {
    function rupiah($n): string { return $n === null ? '–' : 'Rp '.number_format((float) $n, 0, ',', '.'); }
}

if (! function_exists('tgl')) {
    function tgl($d, bool $hari = false): string
    {
        if (! $d) return '';
        $d = \Carbon\CarbonImmutable::parse($d);
        $s = $d->day.' '.\App\Support\Pawukon::BULAN[$d->month - 1].' '.$d->year;
        return $hari ? \App\Support\Pawukon::HARI[$d->dayOfWeek].', '.$s : $s;
    }
}
