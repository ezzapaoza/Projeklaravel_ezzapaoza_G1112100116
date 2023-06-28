@extends('layouts.app')
@section('content')
<div class="container">
 <h1>Resto</h1>
 <div class="row">
 <div class="col-4 pizza-card pizza-primary">
 <div class="row" style="padding-left:5px;padding-right:20px">
 <div class="col">Order bulan ini</div>
 <div class="col">
 {{ $order_bulan_ini }}
 </div>
 </div>
 </div>
 <div class="col-4 pizza-card pizza-primary">
 <div class="row" style="padding-left:5px;padding-right:20px">
 <div class="col">
 Order minggu 
 </div>
 <div class="col">
 {{ $order_minggu_terakhir }}
 </div>
 </div>
 </div>
 <div class="col-4 pizza-card pizza-primary">
 <div class="row" style="padding-left:5px;padding-right:20px">
 <div class="col">
 Rating
 </div>
 <div class="col">
 {{ $rating_50 == null ? '-' : number_format($rating_50,2) }}
/{{ number_format($rating_semua,2) }}
 </div>
 </div>
 </div>
 </div>
 <div class="col-12 pizza-card pizza-primary">
 <div class="row" style="padding-left:5px;padding-right:20px">
 <div class="col">
 order di batalkan
 </div>
 <div class="col">
 {{ $order_di_batalkan }}
 </div>
 </div>
 </div>
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
 Order {{ $cur->id }} ({{ $cur->status_jual }}) 
{{ Carbon\Carbon::parse($cur->waktu_pesan)->format('d-m-Y H:i:s') }} 
{{ Carbon\Carbon::parse($cur->waktu_pesan)->diffForHumans() }} 
<button type="button" class="btn btn-light"
onclick="toggle_detail({{ $cur->id }});">>></button>
 </div>
 <div class="col-12" style="display:none" id="detail{{ $cur->id}}">
 <p>{{ $cur->alamat_kirim->nama_penerima }}<br/>
{{ $cur->alamat_kirim->alamat }}</p>
 <ul>
 @foreach ($cur->jual_details as $jual_detail)
 <li>{{ $jual_detail->qty }} {{ $jual_detail->nama_pizza }}</li> 
 @endforeach
 </ul>
 @if($cur->status_jual=='PESAN')
 <form style="display:inline" method="POST"
action="{{ url('resto/proses').'/'.$cur->id }}">@csrf
<button class="btn btn-primary">TERIMA</button></form>
 @endif
 @if($cur->status_jual=='PROSES')
 <form style="display:inline" method="POST"
action="{{ url('resto/siap').'/'.$cur->id }}">@csrf
<button class="btn btn-primary">SIAP</button></form>
 @endif
 @if(in_array($cur->status_jual, ['PESAN','PROSES','SIAP','ANTAR']))
 <form style="display:inline" method="POST"
action="{{ url('resto/cancel').'/'.$cur->id }}">@csrf
<button class="btn btn-danger"
onclick="return confirm('Batalkan order?');">
BATALKAN ORDER</button></form>
 @endif
 <a class="btn btn-primary"
href="{{ url('resto/track').'/'.$cur->id }}">TRACK</a>
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