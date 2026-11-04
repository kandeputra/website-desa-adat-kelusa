<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\Formulir;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/** CRUD generik untuk semua modul di config/admin.php */
class ResourceController extends Controller
{
    protected function modul(string $kunci): array
    {
        $m = config('admin.modul.'.$kunci);
        abort_unless($m, 404);
        $u = auth()->user();
        abort_unless($m['peran'] === 'admin' || $u->isSuperAdmin(), 403, 'Modul ini hanya untuk Super Admin.');
        return $m + ['kunci' => $kunci];
    }

    protected function query(array $m)
    {
        $q = $m['model']::query();
        foreach ($m['where'] ?? [] as $k => $v) $q->where($k, $v);
        return $q;
    }

    protected function cari(array $m, int $id): Model
    {
        return $this->query($m)->findOrFail($id);
    }

    public function index(Request $r, string $modul)
    {
        $m = $this->modul($modul);
        $q = $this->query($m);
        if ($s = trim((string) $r->query('q'))) {
            $q->where(fn ($w) => collect($m['cari'] ?? [])->each(fn ($c) => $w->orWhere($c, 'like', "%$s%")));
        }
        foreach ($m['filter'] ?? [] as $kol => $opsi) {
            if ($r->filled($kol) && array_key_exists($r->query($kol), $opsi)) $q->where($kol, $r->query($kol));
        }
        [$kol, $arah] = $m['urut'] ?? ['id', 'desc'];
        $q->orderBy($kol, $arah);
        if (isset($m['urut2'])) $q->orderBy(...$m['urut2']);
        return view('admin.resource.index', ['m' => $m, 'items' => $q->orderByDesc('id')->paginate(20)->withQueryString()]);
    }

    public function create(string $modul)
    {
        $m = $this->modul($modul);
        abort_if(($m['tambah'] ?? true) === false, 404);
        $item = new $m['model']($m['set'] ?? []);
        if (in_array('status', array_column($m['fields'], 'nama'))) $item->status ??= array_key_first(collect($m['fields'])->firstWhere('nama', 'status')['opsi']);
        return view('admin.resource.form', ['m' => $m, 'item' => $item]);
    }

    public function store(Request $r, string $modul)
    {
        $m = $this->modul($modul);
        abort_if(($m['tambah'] ?? true) === false, 404);
        $valid = $r->validate(Formulir::aturan($m['fields']), [], Formulir::label($m['fields']));
        $data = Formulir::olah($r, $m['fields'], $valid, [], $modul, $m['model']);
        $data += $m['set'] ?? [];
        if (! empty($m['penulis'])) {
            $data['user_id'] = $r->user()->id;
            $data['published_at'] ??= now();
        }
        $item = $m['model']::create($data);
        return redirect()->route('admin.r.edit', [$modul, $item->id])->with('ok', ucfirst($m['tunggal']).' tersimpan.');
    }

    public function edit(string $modul, int $id)
    {
        $m = $this->modul($modul);
        return view('admin.resource.form', ['m' => $m, 'item' => $this->cari($m, $id)]);
    }

    public function update(Request $r, string $modul, int $id)
    {
        $m = $this->modul($modul);
        $item = $this->cari($m, $id);
        $valid = $r->validate(Formulir::aturan($m['fields']), [], Formulir::label($m['fields']));
        $data = Formulir::olah($r, $m['fields'], $valid, $item->getAttributes(), $modul, $m['model'], $item->id);
        if (! empty($m['penulis'])) $data['published_at'] ??= $item->published_at ?? now();
        if (! empty($m['petugas'])) $data['ditangani_oleh'] = $r->user()->id;
        $item->update($data);
        return back()->with('ok', ucfirst($m['tunggal']).' diperbarui.');
    }

    public function destroy(string $modul, int $id)
    {
        $m = $this->modul($modul);
        $item = $this->cari($m, $id);
        foreach ($m['fields'] as $f) {
            if (in_array($f['tipe'], ['image', 'file'])) Formulir::hapusBerkas($item->{$f['nama']});
        }
        $item->delete();
        return redirect()->route('admin.r.index', $modul)->with('ok', ucfirst($m['tunggal']).' dihapus.');
    }
}
