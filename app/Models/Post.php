<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    protected $guarded = ['id'];
    protected $casts = ['published_at' => 'datetime', 'unggulan' => 'boolean'];

    public const TYPES = ['berita' => 'Berita', 'pengumuman' => 'Pengumuman', 'artikel' => 'Artikel'];

    public function getRouteKeyName(): string { return 'slug'; }
    public function penulis() { return $this->belongsTo(User::class, 'user_id'); }

    public function scopeTerbit(Builder $q): Builder
    {
        return $q->where('status', 'terbit')->where(fn ($w) => $w->whereNull('published_at')->orWhere('published_at', '<=', now()));
    }

    public function scopeJenis(Builder $q, string $type): Builder { return $q->where('type', $type); }

    public function url(): string { return route($this->type.'.show', $this->slug); }

    public function ringkasan(int $n = 160): string
    {
        return $this->excerpt ?: Str::limit(trim(strip_tags(Str::markdown((string) $this->body))), $n);
    }

    public function isiHtml(): string
    {
        return Str::markdown((string) $this->body, ['html_input' => 'strip', 'allow_unsafe_links' => false]);
    }

    public function menitBaca(): int { return max(1, (int) ceil(str_word_count(strip_tags((string) $this->body)) / 200)); }
}
