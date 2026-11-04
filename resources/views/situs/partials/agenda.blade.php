@if($agenda->isEmpty())
  <p class="kosong">Belum ada agenda terjadwal.</p>
@else
<div class="agenda">
  @foreach($agenda as $a)
    <div><span class="tg"><b>{{ $a->mulai->day }}</b><span>{{ mb_substr(\App\Support\Pawukon::BULAN[$a->mulai->month-1],0,3) }}</span></span>
      <span><strong>{{ $a->judul }}</strong><small>{{ \App\Support\Pawukon::HARI[$a->mulai->dayOfWeek] }}, {{ $a->mulai->format('H.i') }} Wita{{ $a->lokasi ? ' · '.$a->lokasi : '' }}</small>
      @if($a->keterangan)<small style="display:block">{{ $a->keterangan }}</small>@endif</span></div>
  @endforeach
</div>
@endif
