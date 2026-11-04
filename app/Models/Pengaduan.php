<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    protected $guarded = ['id'];

    public function petugas() { return $this->belongsTo(User::class, 'ditangani_oleh'); }

    public static function buatKode(): string
    {
        do { $k = 'ADU-'.now()->format('ymd').'-'.strtoupper(\Illuminate\Support\Str::random(4)); }
        while (static::where('kode', $k)->exists());
        return $k;
    }
}
