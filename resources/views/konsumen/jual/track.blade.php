@extends('layouts.app')
@section('content')
<div class="container">
<h1>Track</h1>
<h2>Penerima</h2>
<table class="table">
 <tbody>
 <tr><td>Nama</td><td>{{ $alamat_kirim->nama_penerima }}</td></tr>
 <tr><td>Alamat</td><td>{{ $alamat_kirim->alamat }}</td></tr>
 </tbody>
</table>
<h2>Order</h2>
<table class="table">
 <tbody>
 @foreach ($jual_details as $cur )
 <tr> 
 <td>{!! $cur->nama_pizza !!}</td>
 <td>{{ $cur->qty }}</td>
 </tr>
 @endforeach
 <tr>
 <td colspan="2">
 Keterangan:<br/>
 {{ $jual->keterangan }}
 </td>
 </tr>
 </tbody>
</table>
<h2>Waktu</h2>
<table class="table">
 <tbody>
 <tr><td>PESAN</td>
<td>{{ $jual->waktu_pesan != null ? $jual->waktu_pesan : '' }}</td></tr>
 <tr><td>PROSES</td>
<td>{{ $jual->waktu_proses != null ? $jual->waktu_proses : '' }}</td></tr>
 <tr><td>SIAP</td>
<td>{{ $jual->waktu_siap != null ? $jual->waktu_siap : '' }}</td></tr>
 <tr><td>ANTAR</td>
<td>{{ $jual->waktu_antar != null ? $jual->waktu_antar : '' }}</td></tr>
 <tr><td>TIBA</td>
<td>&nbsp;</td></tr>
 </tbody>
</table>
<a class="btn" href="{{ url('/konsumen/home') }}">Kembali</a>
@if($jual->status_jual=='PESAN')
<form method="post" action="{{ url('konsumen/cancel').'/'.$jual->id }}"
style="display:inline">
 @csrf
 <button class="btn btn-danger" onclick="return confirm('Batalkan order?')"
type="submit">Batal</button>
</form>@endif
</div>
@endsection
@extends('layouts.app')
@section('content')
<div class="container">
<h1>Track</h1>
<h2>Penerima</h2>
<table class="table">
 <tbody>
 <tr><td>Nama</td><td>{{ $alamat_kirim->nama_penerima }}</td></tr>
 <tr><td>Alamat</td><td>{{ $alamat_kirim->alamat }}</td></tr>
 </tbody>
</table>
<h2>Order</h2>
<table class="table">
 <tbody>
 @foreach ($jual_details as $cur )
 <tr> 
 <td>{!! $cur->nama_pizza !!}</td>
 <td>{{ $cur->qty }}</td>
 </tr>
 @endforeach
 <tr>
 <td colspan="2">
 Keterangan:<br/>
 {{ $jual->keterangan }}
 </td>
 </tr>
 </tbody>
</table>
<h2>Waktu</h2>
<table class="table">
 <tbody>
 <tr><td>PESAN</td><td>{{ $jual->waktu_pesan != null ? 
 Carbon\Carbon::parse($jual->waktu_pesan)->format('d-M-Y H:i:s') : '' 
}}</td></tr>
 <tr><td>PROSES</td><td>{{ $jual->waktu_proses != null ? 
 Carbon\Carbon::parse($jual->waktu_proses)->format('d-M-Y H:i:s') : '' 
}}</td></tr>
 <tr><td>SIAP</td><td>{{ $jual->waktu_siap != null ? 
 Carbon\Carbon::parse($jual->waktu_siap)->format('d-M-Y H:i:s').' ('.
 Carbon\Carbon::parse($jual->waktu_siap)-
>diffForHumans(Carbon\Carbon::parse($jual->waktu_pesan)).')' : '' }}</td></tr>
 <tr><td>ANTAR</td><td>{{ $jual->waktu_antar != null ? 
 Carbon\Carbon::parse($jual->waktu_antar)->format('d-M-Y H:i:s').
 ($kurir == null ? '' : '('.$kurir->name.')') : '' }}</td></tr>
 <tr><td>TIBA</td><td>{{ $jual->waktu_tiba != null ? 
Carbon\Carbon::parse($jual->waktu_tiba)
 ->format('d-M-Y H:i:s').' ('.Carbon\Carbon::parse($jual->waktu_tiba)
 ->diffForHumans(Carbon\Carbon::parse($jual->waktu_pesan)).')' : '' 
}}</td></tr>
 </tbody>
</table>
@if($jual->status_jual!='TIBA')
<a class="btn" href="{{ url('/konsumen/home') }}">Kembali</a>
@endif
@if($jual->status_jual=='PESAN')
<form method="post" action="{{ url('konsumen/cancel').'/'.$jual->id }}"
style="display:inline">
 @csrf
 <button class="btn btn-danger" onclick="return confirm('Batalkan order?')"
type="submit">Batal</button>
</form>@endif
@if($jual->status_jual=='TIBA')
<form method="post" action="{{ url('konsumen/rate').'/'.$jual->id }}"
style="display:inline">
 @csrf
 <div class="row">
 @csrf
 <div class="col-3">
 <label for="resto_rate" class="form-label">Beri rating restoran</label>
 </div>
 <div class="col-3">
 <select name="resto_rate" class="form-select">
 @foreach (['1','2','3','4','5'] as $rate )
 <option value="{{ $rate }}" {{ $rate==5 ? 'selected' : '' }}>{{ $rate 
}}</option>
 @endforeach
 </select>
 </div>
 </div>
 <div class="row">
 @csrf
 <div class="col-3">
 <label for="kurir_rate" class="form-label">Beri rating kurir</label>
 </div>
 <div class="col-3">
 <select name="kurir_rate" class="form-select">
 @foreach (['1','2','3','4','5'] as $rate )
 <option value="{{ $rate }}" {{ $rate==5 ? 'selected' : '' }}>{{ $rate 
}}</option>
 @endforeach
 </select>
 </div>
 </div>
 <button class="btn btn-primary" type="submit">Simpan</button>
 <a class="btn" href="{{ url('/konsumen/home') }}">Kembali</a>
</form>
@endif
</div>
@endsection