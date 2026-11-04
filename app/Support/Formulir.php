<?php

namespace App\Support;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/** Validasi dan pengolahan field formulir admin (dipakai modul & pengaturan). */
class Formulir
{
    public static function aturan(array $fields, ?string $tabel = null, $id = null): array
    {
        $r = [];
        foreach ($fields as $f) {
            $n = $f['nama'];
            $wajib = ! empty($f['wajib']) ? 'required' : 'nullable';
            $r[$n] = match ($f['tipe']) {
                'tampil' => null,
                'text', 'textarea', 'markdown' => [$wajib, 'string', ...(isset($f['aturan']) ? explode('|', $f['aturan']) : ($f['tipe'] === 'text' ? ['max:255'] : ['max:100000']))],
                'number' => [$wajib, 'integer', 'min:0'],
                'select' => [$wajib, 'in:'.implode(',', array_keys($f['opsi']))],
                'date' => [$wajib, 'date'],
                'datetime' => [$wajib, 'date'],
                'url' => [$wajib, 'url', 'max:500'],
                'email' => [$wajib, 'email', 'max:150'],
                'checkbox' => ['nullable', 'boolean'],
                'slug' => ['nullable', 'string', 'max:200', 'alpha_dash'],
                'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
                'file' => ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png', 'max:10240'],
                default => ['nullable'],
            };
            if ($r[$n] === null) unset($r[$n]);
        }
        return $r;
    }

    public static function label(array $fields): array
    {
        return collect($fields)->mapWithKeys(fn ($f) => [$f['nama'] => strtolower($f['label'])])->all();
    }

    /**
     * Ubah input menjadi nilai yang disimpan.
     * @param  array  $lama  nilai lama (untuk berkas yang diganti/dihapus)
     */
    public static function olah(Request $r, array $fields, array $valid, array $lama, string $folder, ?string $modelClass = null, $id = null): array
    {
        $data = [];
        foreach ($fields as $f) {
            $n = $f['nama'];
            switch ($f['tipe']) {
                case 'tampil':
                    break;
                case 'checkbox':
                    $data[$n] = $r->boolean($n);
                    break;
                case 'image':
                case 'file':
                    if ($r->hasFile($n)) {
                        static::hapusBerkas($lama[$n] ?? null);
                        $berkas = $r->file($n);
                        $nama = Str::slug(pathinfo($berkas->getClientOriginalName(), PATHINFO_FILENAME)) ?: 'berkas';
                        $data[$n] = $berkas->storeAs($folder.'/'.now()->format('Y/m'), Str::limit($nama, 60, '').'-'.Str::lower(Str::random(6)).'.'.$berkas->extension(), 'uploads');
                    } elseif ($r->boolean('hapus_'.$n)) {
                        static::hapusBerkas($lama[$n] ?? null);
                        $data[$n] = null;
                    }
                    break;
                case 'slug':
                    $s = Str::slug($valid[$n] ?? '') ?: Str::slug($valid[$f['dari']] ?? '') ?: Str::lower(Str::random(8));
                    if ($modelClass) {
                        $base = $s; $i = 2;
                        while ($modelClass::where($n, $s)->when($id, fn ($q) => $q->whereKeyNot($id))->exists()) $s = $base.'-'.$i++;
                    }
                    $data[$n] = $s;
                    break;
                default:
                    $data[$n] = $valid[$n] ?? null;
            }
        }
        return $data;
    }

    public static function hapusBerkas(?string $path): void
    {
        if ($path) Storage::disk('uploads')->delete($path);
    }
}
