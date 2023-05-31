@extends('layouts.app')
@section('content')
<div class="container">
<h1>Alamat Kirim</h1>
<form method="post"
 action="{{ url('konsumen/alamatkirim/store') }}"
 style="display:inline">
 @csrf
 <label for="nama_penerima" class="col-form-label">Nama</label>
 <input type="text" class="form-control"
 name="nama_penerima" value="{{ old('nama_penerima') }}"/>
 <label for="alamat" class="col-form-label">Alamat</label>
 <textarea class="form-control"
 name="alamat">{{ old('alamat') }}</textarea>
 <br/>
 <button class="btn btn-primary" style="submit">SIMPAN</button>
 <a href="{{ url('/konsumen/alamatkirim') }}" class="btn">BATAL</a>
</form>
</div>
@endsection