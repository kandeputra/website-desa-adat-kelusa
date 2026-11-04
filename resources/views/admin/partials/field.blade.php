@php
  $n = $f['nama']; $id = 'f-'.$n; $val = old($n, $nilai);
  $lebar = ($f['lebar'] ?? 'penuh') === 'setengah' ? 'setengah' : 'penuh';
@endphp
<div class="field {{ $lebar }} t-{{ $f['tipe'] }} {{ $errors->has($n) ? 'error' : '' }}">
  @if($f['tipe'] !== 'checkbox')<label for="{{ $id }}">{{ $f['label'] }}@if(!empty($f['wajib']))<span class="wajib" aria-hidden="true">*</span>@endif</label>@endif
  @switch($f['tipe'])
    @case('tampil')
      <div class="tampil" id="{{ $id }}">{{ $nilai instanceof \DateTimeInterface ? tgl($nilai, true).' '.$nilai->format('H.i') : ($nilai ?: '–') }}</div>
      @break
    @case('textarea')
      <textarea id="{{ $id }}" name="{{ $n }}" rows="{{ $f['baris'] ?? 4 }}" @required(!empty($f['wajib']))>{{ $val }}</textarea>
      @break
    @case('markdown')
      <div class="md">
        <div class="md-alat" role="toolbar" aria-label="Format teks">
          <button type="button" data-md="**|**" title="Tebal"><b>B</b></button>
          <button type="button" data-md="*|*" title="Miring"><i>I</i></button>
          <button type="button" data-md="\n## |" title="Subjudul">H2</button>
          <button type="button" data-md="\n### |" title="Subjudul kecil">H3</button>
          <button type="button" data-md="\n- |" title="Daftar">• Daftar</button>
          <button type="button" data-md="\n> |" title="Kutipan">❝ Kutipan</button>
          <button type="button" data-md="[|](https://)" title="Tautan">Tautan</button>
          <button type="button" class="md-pratinjau" title="Pratinjau">Pratinjau</button>
        </div>
        <textarea id="{{ $id }}" name="{{ $n }}" rows="16" @required(!empty($f['wajib']))>{{ $val }}</textarea>
        <div class="md-hasil konten-preview" hidden></div>
      </div>
      <small class="bantuan">Pisahkan paragraf dengan baris kosong. **tebal**, *miring*, ## subjudul, - daftar.</small>
      @break
    @case('select')
      <select id="{{ $id }}" name="{{ $n }}" @required(!empty($f['wajib']))>
        @if(empty($f['wajib']))<option value="">—</option>@endif
        @foreach($f['opsi'] as $k => $l)<option value="{{ $k }}" @selected((string) $val === (string) $k)>{{ $l }}</option>@endforeach
      </select>
      @break
    @case('checkbox')
      <label class="cek"><input type="hidden" name="{{ $n }}" value="0"><input type="checkbox" id="{{ $id }}" name="{{ $n }}" value="1" @checked($val)><span>{{ $f['label'] }}</span></label>
      @break
    @case('number')
      <input type="number" id="{{ $id }}" name="{{ $n }}" value="{{ $val }}" min="0" step="1" inputmode="numeric" @required(!empty($f['wajib']))>
      @break
    @case('date')
      <input type="date" id="{{ $id }}" name="{{ $n }}" value="{{ $val instanceof \DateTimeInterface ? $val->format('Y-m-d') : $val }}" @required(!empty($f['wajib']))>
      @break
    @case('datetime')
      <input type="datetime-local" id="{{ $id }}" name="{{ $n }}" value="{{ $val instanceof \DateTimeInterface ? $val->format('Y-m-d\TH:i') : ($val ? str_replace(' ', 'T', substr($val, 0, 16)) : '') }}" @required(!empty($f['wajib']))>
      @break
    @case('image')
    @case('file')
      <div class="unggah">
        @if($nilai)
          <div class="unggah-ada">
            @if($f['tipe'] === 'image')<img src="{{ unggahan($nilai) }}" alt="">@else<a href="{{ unggahan($nilai) }}" target="_blank" rel="noopener">{{ basename($nilai) }} ↗</a>@endif
            <label class="cek kecil"><input type="checkbox" name="hapus_{{ $n }}" value="1"><span>Hapus berkas ini</span></label>
          </div>
        @endif
        <input type="file" id="{{ $id }}" name="{{ $n }}" accept="{{ $f['tipe'] === 'image' ? 'image/jpeg,image/png,image/webp' : '.pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png' }}" data-pratinjau="{{ $f['tipe'] === 'image' ? '1' : '' }}">
        <img class="unggah-pratinjau" alt="" hidden>
      </div>
      <small class="bantuan">{{ $f['tipe'] === 'image' ? 'JPG, PNG, atau WEBP, maksimal 4 MB.' : 'PDF, DOC, XLS, atau gambar, maksimal 10 MB.' }}</small>
      @break
    @case('slug')
      <div class="awalan"><span>{{ parse_url(url('/'), PHP_URL_HOST) }}/…/</span><input type="text" id="{{ $id }}" name="{{ $n }}" value="{{ $val }}" data-slug-dari="f-{{ $f['dari'] }}" pattern="[a-z0-9\-_]*"></div>
      @break
    @default
      <input type="{{ $f['tipe'] === 'url' ? 'url' : ($f['tipe'] === 'email' ? 'email' : 'text') }}" id="{{ $id }}" name="{{ $n }}" value="{{ $val }}" @required(!empty($f['wajib'])) @if(!empty($f['saran'])) list="{{ $id }}-saran" @endif>
      @if(!empty($f['saran']))<datalist id="{{ $id }}-saran">@foreach($f['saran'] as $s)<option value="{{ $s }}">@endforeach</datalist>@endif
  @endswitch
  @if(!empty($f['bantuan']))<small class="bantuan">{{ $f['bantuan'] }}</small>@endif
  @error($n)<small class="pesan-galat">{{ $message }}</small>@enderror
</div>
