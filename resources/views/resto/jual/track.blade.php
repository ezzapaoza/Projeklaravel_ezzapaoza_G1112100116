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
 Carbon\Carbon::parse($jual->waktu_siap)->format('d-M-Y H:i:s') : '' 
}}</td></tr>
 <tr><td>ANTAR</td><td>{{ $jual->waktu_antar != null ? 
 Carbon\Carbon::parse($jual->waktu_antar)->format('d-M-Y H:i:s') : '' 
}}</td></tr>
 <tr><td>TIBA</td><td>{{ $jual->waktu_tiba != null ? 
 Carbon\Carbon::parse($jual->waktu_tiba)->format('d-M-Y H:i:s') : '' 
}}</td></tr>
 <tr><td>BATAL</td><td>{{ $jual->waktu_batal != null ? 
 Carbon\Carbon::parse($jual->waktu_batal)->format('d-M-Y H:i:s') : '' 
}}</td></tr>
 </tbody>
</table>
<a class="btn" href="{{ url('/resto/home') }}">Kembali</a>
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
 Carbon\Carbon::parse($jual->waktu_tiba)->format('d-M-Y H:i:s').' ('.
 Carbon\Carbon::parse($jual->waktu_tiba)-
>diffForHumans(Carbon\Carbon::parse($jual->waktu_pesan)).')' : '' }}</td></tr>
 <tr><td>BATAL</td><td>{{ $jual->waktu_batal != null ? 
 Carbon\Carbon::parse($jual->waktu_batal)->format('d-M-Y H:i:s') : '' 
}}</td></tr>
 </tbody>
</table>
<a class="btn" href="{{ url('/resto/home') }}">Kembali</a>
</div>
@endsection