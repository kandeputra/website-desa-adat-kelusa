<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    protected $guarded = ['id'];

    protected $casts = ['tanggal' => 'date'];

    /** ID video YouTube dari berbagai bentuk tautan */
    public function youtubeId(): ?string
    {
        if (! $this->url_video) return null;
        preg_match('~(?:youtu\.be/|v=|embed/|shorts/)([A-Za-z0-9_-]{11})~', $this->url_video, $m);
        return $m[1] ?? null;
    }
}
