@extends('layouts.app')
@section('content')
<div class="container">
<h1>Pizza</h1>
<a class="btn btn-primary" href="{{ url('resto/pizza/create') }}">Tambah</a>
<table class="table">
 <thead><tr><th></th><th>Pizza</th><th>Harga</th></thead>
 <tbody>
 @foreach ($pizzas as $cur )
 <tr>
 <td>
 <a class="btn btn-primary"
 href="{{ url('resto/pizza/edit').'/'.$cur->id }}">Edit</a>
 <form method="post"
 action="{{ url('resto/pizza/destroy').'/'.$cur->id }}"
 style="display:inline">
 @csrf
 <button class="btn btn-danger" style="submit"
 onclick="return confirm('Hapus data?')">
 Hapus
 </button>
 </form>
 </td>
 <td>{!! $cur->nama_pizza !!}</td>
 <td>{!! $cur->harga_satuan !!}</td>
 </tr>
 @endforeach
 </tbody>
</table>
{{ $pizzas->links() }}
</div>
@endsection