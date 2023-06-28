@extends('layouts.app')
@section('content')
<div class="container">
 <h1>Konsumen</h1>
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
 Rating Konsumen
 </div>
 <div class="col">
 {{ $rating_5 == null ? '-' : number_format($rating_5,2) }}/{{ 
number_format($rating_semua,2) }}
 </div>
 </div>
 </div>
 </div>
 <div class="row">
 <div class="col-9 pizza-card pizza-primary">
 @if($jual==null)
 Silakan pesan pizza kesukaanmu! Klik di <a href="{{ url('/konsumen/order') 
}}">sini</a>.
 @elseif ($jual->status_jual=='CART')
 Selesaikan ordermu di <a href="{{ url('/konsumen/checkout') }}">sini</a>.
 @elseif ($jual->status_jual=='PESAN')
 Restoran akan segera merespon ordermu. Track di <a href="{{ 
url('/konsumen/track').'/'.$jual->id }}">sini</a>.
 @elseif ($jual->status_jual=='PROSES')
 Restoran sedang menyiapkan makananmu. Track di <a href="{{ 
url('/konsumen/track').'/'.$jual->id }}">sini</a>.
 @elseif ($jual->status_jual=='SIAP')
 Kurir sedang mengambil ordermu. Track di <a href="{{ 
url('/konsumen/track').'/'.$jual->id }}">sini</a>.
 @elseif ($jual->status_jual=='ANTAR')
 Kurir sedang mengirim ordermu. Track di <a href="{{ 
url('/konsumen/track').'/'.$jual->id }}">sini</a>.
 @elseif ($jual->status_jual=='TIBA')
 Silakan beri rating ordermu di <a href="{{ 
url('/konsumen/track').'/'.$jual->id }}">sini</a>.
 @endif
 </div>
 <div class="col-3 pizza-card pizza-primary">
 Atur alamat kirim di <a href="{{ url('/konsumen/alamatkirim') 
}}">sini</a>.
 </div>
 </div>
</div>
@endsection