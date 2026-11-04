<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lembaga extends Model
{
    protected $guarded = ['id'];

    public function getRouteKeyName(): string { return 'slug'; }
    public function tugasList(): array { return array_values(array_filter(array_map('trim', preg_split('/\r?\n/', (string) $this->tugas)))); }
}
