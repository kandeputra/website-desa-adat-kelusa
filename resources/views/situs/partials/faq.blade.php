<div class="faq">
  @foreach($faq as $i => $f)
    <details @if($i===0) open @endif><summary>{{ $f->pertanyaan }}</summary><p>{{ $f->jawaban }}</p></details>
  @endforeach
</div>
