@if ($paginator->hasPages())
<nav class="pager" aria-label="Halaman">
  @if ($paginator->onFirstPage())<span class="mati">‹</span>@else<a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Sebelumnya">‹</a>@endif
  @if(isset($elements))
    @foreach ($elements as $el)
      @if (is_string($el))<span class="mati">{{ $el }}</span>@endif
      @if (is_array($el))
        @foreach ($el as $page => $url)
          @if ($page == $paginator->currentPage())<span class="aktif" aria-current="page">{{ $page }}</span>@else<a href="{{ $url }}">{{ $page }}</a>@endif
        @endforeach
      @endif
    @endforeach
  @endif
  @if ($paginator->hasMorePages())<a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Berikutnya">›</a>@else<span class="mati">›</span>@endif
</nav>
@endif
