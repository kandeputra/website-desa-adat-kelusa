<?php

namespace App\Support;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

/** Akses pengaturan situs (tabel settings), di-cache agar cepat. */
class Situs
{
    public static function all(): array
    {
        return Cache::rememberForever('situs.settings', function () {
            try {
                return Schema::hasTable('settings') ? Setting::pluck('value', 'key')->all() : [];
            } catch (\Throwable) {
                return [];
            }
        });
    }

    public static function get(string $key, $default = null)
    {
        $v = static::all()[$key] ?? null;
        return ($v === null || $v === '') ? $default : $v;
    }

    public static function set(array $values): void
    {
        foreach ($values as $k => $v) {
            Setting::updateOrCreate(['key' => $k], ['value' => $v]);
        }
        Cache::forget('situs.settings');
    }
}
