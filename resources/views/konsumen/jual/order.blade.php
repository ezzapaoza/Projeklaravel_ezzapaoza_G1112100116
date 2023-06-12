@extends('layouts.app')
@section('content')
<div class="container">
<h1>Order</h1>
@if($is_cart)
<a class="btn btn-primary" href="{{ url('konsumen/cart') }}">Lihat Cart</a>
@endif
<table class="table">
 <thead><tr><th></th><th>Pizza</th><th>Harga</th></thead>
 <tbody>
 @foreach ($pizzas as $cur )
 <tr>
 <td>
 <form method="post"
 action="{{ url('konsumen/addtocart').'/'.$cur->id }}"
 style="display:inline">
 @csrf
 <button class="btn btn-primary" style="submit">
 Order
 </button>
 </form>
 </td>
 <td>{!! $cur->nama_pizza !!}</td>
 <td>{!! $cur->harga_satuan !!}</td>
 </tr>
 @endforeach
 </tbody>
</table>
</div>
@endsection
