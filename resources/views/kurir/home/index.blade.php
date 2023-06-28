@extends('layouts.app')
@section('content')
<div class="container">
 <h1>KURIR</h1>
 <div class="row">
 <div class="col-4 pizza-card pizza-primary">
 <div class="row" style="padding-left:5px;padding-right:20px">
 <div class="col">
 Order bulan ini
 </div>
 <div class="col">
 {{ $order_bulan_ini }}
 </div>
 </div>
 </div>
 <div class="col-4 pizza-card pizza-primary">
 <div class="row" style="padding-left:5px;padding-right:20px">
 <div class="col">
 Order minggu terakhir
 </div>
 <div class="col">
 {{ $order_minggu_terakhir }}
 </div>
 </div>
 </div>
 <div class="col-4 pizza-card pizza-primary">
 <div class="row" style="padding-left:5px;padding-right:20px">
 <div class="col">
 Rating Kurir
 </div>
 <div class="col">
 {{ $rating_5 == null ? '-' : number_format($rating_5,2) }}/{{ 
number_format($rating_semua,2) }}
 </div>
 </div>
 </div>
 </div>
 <br/>
 <div class="row">
 <div class="col-10">&nbsp;</div>
 <div class="col-2">
 <form>
 <select name="status_jual" class="form-control"
onchange="this.form.submit()">
 @foreach ($arr_status_jual as $cur)
 <option value="{{ $cur }}"
@if($cur==$status_jual) selected @endif>{{ $cur }}</option>
 @endforeach
 </select>
 </form>
 </div>
 </div>
 @forelse ($juals as $cur)
 <div class="row">
 <div class="col-12 pizza-card pizza-primary"> 
 Order {{ $cur->id }} ({{ $cur->status_jual }}) {{ 
Carbon\Carbon::parse($cur->waktu_pesan)->format('d-m-Y H:i:s') }} {{ 
Carbon\Carbon::parse($cur->waktu_pesan)->diffForHumans() }} <button type="button"
class="btn btn-light" onclick="toggle_detail({{ $cur->id }});">>></button>
 </div>
 <div class="col-12" style="display:none" id="detail{{ $cur->id}}">
 <p>{{ $cur->alamat_kirim->nama_penerima }}<br/>
{{ $cur->alamat_kirim->alamat }}</p>
 <ul>
 @foreach ($cur->jual_details as $jual_detail)
 <li>{{ $jual_detail->qty }} {{ $jual_detail->nama_pizza }}</li> 
 @endforeach
 </ul>
 @if($cur->status_jual=='SIAP')
 <form style="display:inline" method="POST"
action="{{ url('kurir/antar').'/'.$cur->id }}">@csrf
<button class="btn btn-primary">AMBIL ORDER</button></form>
 @endif
 @if($cur->status_jual=='ANTAR')
 <form style="display:inline" method="POST"
action="{{ url('kurir/tiba').'/'.$cur->id }}">@csrf
<button class="btn btn-primary">SELESAI ORDER</button></form>
 @endif
 @if($cur->status_jual=='TIBA')
 <form style="display:inline" method="POST"
action="{{ url('kurir/rate').'/'.$cur->id }}">
 <div class="row">
 @csrf
 <div class="col-auto">
 <label for="konsumen_rate" class="form-label">Beri rating 
konsumen</label>
 </div>
 <div class="col-auto">
 <select name="konsumen_rate" class="form-select">
 @foreach (['1','2','3','4','5'] as $rate )
 <option value="{{ $rate }}"
{{ $rate==5 ? 'selected' : '' }}>{{ $rate }}</option>
 @endforeach
</select>
 </div>
 <div class="col-auto">
 <button class="btn btn-primary">RATE</button>
 </div>
 </div
 </form>
 @endif
 </div>
 </div>
 @empty
 <p class="pizza-danger">Tidak ada data</p>
 @endforelse
</div>
<script>
function toggle_detail(id){
 var obj_id = 'detail' + id;
 var x = document.getElementById(obj_id);
 if (x.style.display === "none") {
 x.style.display = "block";
 } else {
 x.style.display = "none";
 }
}
</script>
@endsection