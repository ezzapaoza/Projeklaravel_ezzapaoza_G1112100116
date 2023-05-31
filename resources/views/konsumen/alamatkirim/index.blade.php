@extends('layouts.app')
@section('content')
<div class="container">
<h1>Alamat Kirim</h1>
@if($is_no_default)
<div class="alert alert-warning">
 Belum ada alamat default
</div>
@endif
<a class="btn btn-primary" href="{{ url('konsumen/alamatkirim/create') }}">Tambah</a>
<table class="table">
 <thead><tr><th></th><th>Nama Penerima</th><th>Alamat</th><th></th></thead>
 <tbody>
 @foreach ($alamatkirims as $cur )
 <tr>
 <td>
 <a class="btn btn-primary"
 href="{{ url('konsumen/alamatkirim/edit').'/'.$cur->id }}">
 Edit</a>
 <form method="post"
 action="{{ url('konsumen/alamatkirim/default').'/'.$cur->id }}"
 style="display:inline">
 @csrf
 <button class="btn btn-primary" style="submit">
 Default
 </button>
 </form>
 <form method="post"
 action="{{ url('konsumen/alamatkirim/destroy').'/'.$cur->id }}"
 style="display:inline">
 @csrf
 <button class="btn btn-danger" style="submit"
 onclick="return confirm('Hapus data?')">
 Hapus
 </button>
 </form>
 </td>
 <td>{!! $cur->nama_penerima !!}</td>
 <td>{!! $cur->alamat !!}</td>
 <td>{!! $cur->is_default ? 'Default' : '' !!}</td>
 </tr>
 @endforeach
 </tbody>
</table>
{{ $alamatkirims->links() }}
</div>
@endsection