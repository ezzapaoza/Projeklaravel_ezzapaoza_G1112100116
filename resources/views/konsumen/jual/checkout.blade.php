@extends('layouts.app')
@section('content')
<div class="container">
<h1>Checkout</h1>
<form method="post" action="{{ url('konsumen/checkout') }}">
 @csrf
 <input type="hidden" name="jual_id" value="{{ $jual->id }}"/>
 <h2>Alamat Kirim</h2>
 @if(count($alamat_kirims)==0)
 Tidak ada alamat kirim. Silakan tambah alamat kirim melalui link 
<a href="{{ url('konsumen/alamatkirim') }}">berikut</a>.
 @else
 <select name="alamat_kirim_id" class="form-control">
 @foreach ($alamat_kirims as $alamat_kirim )
 <option value="{{ $alamat_kirim->id }}"
{{ $alamat_kirim->id==$jual->alamat_kirim_id ? 'selected' :'' }}>
{{ $alamat_kirim->nama_penerima.' - '.$alamat_kirim->alamat }}</option>
 @endforeach
 </select>
 @endif
 <h2>Pesanan</h2>
 <table class="table">
 <thead>
 <tr><th>Qty</th><th>Pizza</th><th>Harga Satuan</th><th>Sub Total</th></tr>
 </thead>
 <tbody>
 @foreach ($jual_details as $cur )
 <tr> 
 <td>{!! $cur->qty !!}</td>
 <td>{!! $cur->nama_pizza !!}</td>
 <td style="text-align:right">{!! $cur->harga_satuan !!}</td>
 <td style="text-align:right">{!! $cur->sub_total !!}</td>
 </tr>
 @endforeach
 <tr>
 <td colspan="3">Total</td>
 <td style="text-align:right">{{ $jual->total_harga }}</td>
 </tr>
 </tbody>
 </table>
 <p>{{ $jual->keterangan }}</p>
 <a class="btn" href="{{ url('konsumen/cart') }}">Kembali ke Cart</a>
 <button class="btn btn-primary" type="submit">Bayar</button>
</form>
</div>
@endsection