@extends('layouts.app')
@section('content')
<div class="container">
<h1>Track</h1>
<h2>Penerima</h2>
<table class="table">
 <tbody>
 <tr><td>Nama</td><td>{{ $alamat_kirim->nama_penerima }}</td></tr>
 <tr><td>Alamat</td><td>{{ $alamat_kirim->alamat }}</td></tr>
 </tbody>
</table>
<h2>Order</h2>
<table class="table">
 <tbody>
 @foreach ($jual_details as $cur )
 <tr> 
 <td>{!! $cur->nama_pizza !!}</td>
 <td>{{ $cur->qty }}</td>
 </tr>
 @endforeach
 <tr>
 <td colspan="2">
 Keterangan:<br/>
 {{ $jual->keterangan }}
 </td>
 </tr>
 </tbody>
</table>
<h2>Waktu</h2>
<table class="table">
 <tbody>
 <tr><td>PESAN</td>
<td>{{ $jual->waktu_pesan != null ? $jual->waktu_pesan : '' }}</td></tr>
 <tr><td>PROSES</td>
<td>{{ $jual->waktu_proses != null ? $jual->waktu_proses : '' }}</td></tr>
 <tr><td>SIAP</td>
<td>{{ $jual->waktu_siap != null ? $jual->waktu_siap : '' }}</td></tr>
 <tr><td>ANTAR</td>
<td>{{ $jual->waktu_antar != null ? $jual->waktu_antar : '' }}</td></tr>
 <tr><td>TIBA</td>
<td>&nbsp;</td></tr>
 </tbody>
</table>
<a class="btn" href="{{ url('/konsumen/home') }}">Kembali</a>
@if($jual->status_jual=='PESAN')
<form method="post" action="{{ url('konsumen/cancel').'/'.$jual->id }}"
style="display:inline">
 @csrf
 <button class="btn btn-danger" onclick="return confirm('Batalkan order?')"
type="submit">Batal</button>
</form>@endif
</div>
@endsection