@extends('layouts.app')
@section('content')
<div class="container">
<h1>Edit Alamat</h1>
    <form method="post"
        action="{{ url('konsumen/alamatkirim/update').'/'.$alamat_kirim->id }}"
        style="display:inline">
        @csrf
        <label for="nama_penerima" class="col-form-label">Nama</label>
        <input type="text" class="form-control" name="nama_penerima"
            value="{{ old('alamat_kirim', $alamat_kirim->nama_penerima) }}"/>
        <label for="alamat" class="col-form-label">Alamat</label>
        <input type="text" class="form-control" name="alamat"
            value="{{ old('alamat_kirim', $alamat_kirim->alamat) }}"/>
        <br/>
        <button class="btn btn-primary" style="submit">SIMPAN</button>
        <a href="{{ url('/konsumen/alamatkirim') }}" class="btn">BATAL</a>
    </form>
</div>
@endsection