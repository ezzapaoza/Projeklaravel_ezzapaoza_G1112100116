@extends('layouts.app')
@section('content')
<div class="container">
<h1>Order</h1>
@if($is_cart)
<a class="btn btn-primary" href="{{ url('konsumen/cart') }}">Lihat Cart</a>
@endif
<?php $i = 0; $items_per_row = 3; ?>
@foreach ($pizzas as $cur)
 @if($i%$items_per_row==0)
 @if($i!=0)
</div>
 @endif
<div class="row mb-4">
 @endif
 <div class="col text-center">
 <form method="post"
 action="{{ url('konsumen/addtocart').'/'.$cur->id }}"
 style="display:inline">
 @csrf
 <img src="{!! $cur->pizza_url == ''? asset('images/default.jpg') 
 : asset($cur->pizza_url); !!}"
style="width:100%;height:250px;object-fit:cover"
alt="{!! 'Gambar '.$cur->nama_pizza !!}" /><br/>
 {!! $cur->nama_pizza !!}<br/>
 {!! $cur->harga_satuan !!}<br/>
 <button class="btn btn-primary" style="submit">
 Order
 </button>
 </form> 
 </div>
<?php $i++; ?>
@endforeach
</div>
</div>
@endsection