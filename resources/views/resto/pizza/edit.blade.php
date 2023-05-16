@extends('layouts.app')
@section('content')
<div class="container">
<h1>Pizza</h1>
<form method="post"
 action="{{ url('resto/pizza/update').'/'.$pizza->id }}"
 style="display:inline">
 @csrf
 <label for="nama_pizza" class="col-form-label">Nama</label>
 <input type="text" class="form-control" name="nama_pizza"
 value="{{ old('nama_pizza', $pizza->nama_pizza) }}"/>
 <label for="harga_satuan" class="col-form-label">Harga Satuan</label>
 <input type="text" class="form-control" name="harga_satuan"
 value="{{ old('harga_satuan', $pizza->harga_satuan) }}"/>
 <br/>
 <button class="btn btn-primary" style="submit">SIMPAN</button>
 <a href="{{ url('/resto/pizza') }}" class="btn">BATAL</a>
</form>
</div>
@endsection