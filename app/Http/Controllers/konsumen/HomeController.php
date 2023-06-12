<?php

namespace App\Http\Controllers\konsumen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jual;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $jual = Jual::whereRaw("konsumen_id=? AND status_jual<>'TIBA' 
        AND status_jual<>'BATAL'", [auth()->user()->id])->first();
        return view('konsumen.home.index', compact('jual'));
    }
}

$jual = Jual::whereRaw(
    "konsumen_id=? AND (status_jual<>'TIBA'
 OR kurir_rate=0) AND status_jual<>'BATAL' AND waktu_pesan>?",
    [auth()->user()->id, Carbon::today()]
)->first();
$rating_5 = Jual::whereRaw(
    "status_jual='TIBA' AND konsumen_id=?",
    [auth()->user()->id]
)->orderBy('waktu_pesan', 'desc')->take(5)
    ->avg('konsumen_rate');
$rating_semua = Jual::whereRaw(
    "status_jual='TIBA' AND konsumen_id=?",
    [auth()->user()->id]
)->avg('konsumen_rate');
$order_minggu_terakhir = Jual::whereRaw("konsumen_id=? AND status_jual='TIBA'
 AND waktu_pesan>=? AND waktu_pesan<?", [
    auth()->user()->id,
    Carbon::today()->subDays(6), Carbon::today()->addDays(1)
])->count();
$order_bulan_ini = Jual::whereRaw("konsumen_id=? AND status_jual='TIBA'
 AND waktu_pesan>=? AND waktu_pesan<?", [
    auth()->user()->id,
    Carbon::today()->firstOfMonth(), Carbon::today()->firstOfMonth()
        ->addMonths(1)
])->count();
return view('konsumen.home.index', compact(
    'jual',
    'rating_5',
    'rating_semua',
    'order_minggu_terakhir',
    'order_bulan_ini'
));
