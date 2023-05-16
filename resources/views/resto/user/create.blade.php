@extends('layouts.app')
@section('content')
<div class="container">
<h1>User</h1>
<form method="post"
 action="{{ url('resto/user/store') }}"
 style="display:inline">
 @csrf
 <label for="email" class="col-form-label">Email</label>
 <input type="text" class="form-control" name="email" value="{{ old('email') }}"/>
 <label for="name" class="col-form-label">Nama Lengkap</label>
 <input type="text" class="form-control" name="name" value="{{ old('name') }}"/>
 <label for="role" class="col-form-label">Role</label>
 <select class="form-control" name="role">
 @foreach($roles as $k=>$v)
 <option value="{{ $k }}"
 @if($k==old('role')) selected @endif>{{$v}}</option>
 @endforeach
 </select>
 <label for="password" class="col-form-label">Password</label>
 <input type="password" class="form-control" name="password"/>
 <label for="confirm_password" class="col-form-label">Konfirmasi Password</label>
 <input type="password" class="form-control" name="confirm_password"/>
 <br/>
 <button class="btn btn-primary" style="submit">SIMPAN</button>
 <a href="{{ url('/resto/user') }}" class="btn">BATAL</a>
</form>
</div>
@endsection