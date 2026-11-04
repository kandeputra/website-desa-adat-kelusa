<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wisata extends Model
{
    protected $guarded = ['id'];

    public function getRouteKeyName(): string { return 'slug'; }
}
