@extends('layouts.app')
@section('content')
<div class="container">
<h1>Cart</h1>
<form method="post" action="{{ url('konsumen/cart') }}">
 @csrf
 <input type="hidden" name="jual_id" value="{{ $jual->id }}"/>
 <table class="table">
 <thead><tr><th></th><th>Pizza</th><th>Qty</th></thead>
 <tbody>
 @foreach ($jual_details as $cur )
 <tr> 
 <td><button class="btn btn-danger" type="submit"
name="action_button" value="hapus{{ $cur->id }}">Hapus</button></td> 
 <td>{!! $cur->nama_pizza !!}</td>
 <td>
 <input type="hidden" name="jual_detail_ids[]"
value="{{ $cur->id }}"/>
 <input type="number" name="qtys[]" value="{{ $cur->qty }}"
style="text-align:right"/>
 </td>
 </tr>
 @endforeach
 </tbody>
 </table>
 <label for="keterangan" class="col-form-label">Keterangan</label>
 <textarea name="keterangan" class="form-control">
{{ old('keterangan', $jual->keterangan) }}</textarea>
 <br/>
 <button class="btn btn-primary" type="submit" name="action_button"
value="order">Simpan dan order lagi</button>
 <button class="btn btn-primary" type="submit" name="action_button"
value="hapusall">Kosongkan cart</button>
 <button class="btn btn-primary" type="submit" name="action_button"
value="checkout">Simpan dan checkout</button>
</form>
</div>
@endsection