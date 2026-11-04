<a class="wcard" href="{{ route('wisata.show', $w) }}">
  @if($w->gambar)<img class="ph" src="{{ unggahan($w->gambar) }}" alt="" loading="lazy" style="object-fit:cover;width:100%">@else<div class="ph {{ $loop->index % 2 ? 'ph-daun' : 'ph-api' }}" aria-hidden="true"></div>@endif
  <span class="tagk">{{ $w->kategori }}</span><h3>{{ $w->nama }}</h3><p>{{ $w->ringkasan }}</p>
</a>
