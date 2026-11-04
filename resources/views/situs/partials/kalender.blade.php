<div class="kal">
  @foreach($rerahinan as $r)
    <div class="{{ $r['api'] ? 'api' : '' }}">
      <span class="tgl">{{ \App\Support\Pawukon::tanggalMasehi($r['tanggal']) }}</span>
      <b>{{ $r['nama'] }}</b>
      <span>{{ $r['ket'] }}</span>
      <span class="hari">{{ $r['sisa'] === 0 ? 'Hari ini' : ($r['sisa'] === 1 ? 'Besok' : $r['sisa'].' hari lagi') }}</span>
    </div>
  @endforeach
</div>
