@extends('layouts.app')
@section('content')
<div class="container">
<h1>User</h1>
<a class="btn btn-primary" href="{{ url('resto/user/create') }}">Tambah</a>
<table class="table">
 <thead><tr><th></th><th>User Name</th><th>Real Name</th><th>Role</th></thead>
 <tbody>
 @foreach ($users as $cur )
 <tr>
 <td>
 <a class="btn btn-primary"
href="{{ url('resto/user/edit').'/'.$cur->id }}">Edit</a>
 <form method="post"
 action="{{ url('resto/user/destroy').'/'.$cur->id }}"
 style="display:inline">
 @csrf
 <button class="btn btn-danger" style="submit"
 onclick="return confirm('Hapus data?')">
 Hapus
 </button>
 </form>
 </td>
 <td>{!! $cur->email !!}</td>
 <td>{!! $cur->name !!}</td>
 <td>{!! $cur->role !!}</td>
 </tr>
 @endforeach
 </tbody>
</table>
{{ $users->links() }}
</div>
@endsection