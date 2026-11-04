<a class="post" href="{{ $p->url() }}">
  @if($p->cover)<img class="cover" src="{{ unggahan($p->cover) }}" alt="" loading="lazy">@else<div class="cover ph-api" aria-hidden="true"></div>@endif
  <div class="isi-kartu">
    <span class="tagk">{{ $p->kategori ?: \App\Models\Post::TYPES[$p->type] }}</span>
    <h3>{{ $p->title }}</h3>
    <time datetime="{{ $p->published_at?->toDateString() }}">{{ tgl($p->published_at) }}</time>
    <p>{{ $p->ringkasan(140) }}</p>
  </div>
</a>
