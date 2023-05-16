@extends('layouts.app')
@section('content')
<div class="container">
<h1>User</h1>
<form method="post"
 action="{{ url('resto/user/update').'/'.$data->id }}"
 style="display:inline">
 @csrf
 <label for="email" class="col-form-label">Username</label>
 <input type="text" class="form-control" name="email" value="{{ old('email', $data->email) }}" readonly/>
<label for="name" class="col-form-label">Nama Lengkap</label>
<input type="text" class="form-control" name="name" value="{{ old('name', $data->name) }}"/>
<label for="role" class="col-form-label">Role</label>
<select class="form-control" name="role">
@foreach($roles as $k=>$v)
<option value="{{ $k }}"
@if($k==old('role', $data->role)) selected @endif>{{$v}}</option>
@endforeach
</select>
<br/>
<button class="btn btn-primary" style="submit">SIMPAN</button>
<a href="{{ url('/resto/user') }}" class="btn">BATAL</a>
</form>
</div>
@endsection
