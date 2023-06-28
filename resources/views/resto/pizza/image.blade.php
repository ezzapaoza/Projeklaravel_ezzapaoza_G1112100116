@extends('layouts.app')
@section('content')
<div class="container">
<h1>Pizza</h1>
<form method="post"
 style="display:inline" enctype="multipart/form-data">
 @csrf
 <label for="pizza_url" class="col-form-label">
 Gambar {{ $pizza->nama_pizza }}
 </label>
 <input type="file" class="form-control" name="pizza_url" />
 <br/>
 <button class="btn btn-primary" style="submit">SIMPAN</button>
 <a href="{{ url('/resto/pizza') }}" class="btn">BATAL</a>
</form>
</div>
@endsection
