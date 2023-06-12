<?php

namespace App\Http\Controllers\kurir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jual;
use App\Models\JualDetail;
use App\Models\AlamatKirim;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return view('kurir.home.index');
    }
    protected $_arr_status_jual = ['RESPON', 'SIAP', 'ANTAR', 'RATE'];
    protected $_arr_status_jual_map = [
        'RESPON' => ['SIAP', 'ANTAR', 'TIBA'],
        'SIAP' => ['SIAP'],
        'ANTAR' => ['ANTAR'],
        'RATE' => ['TIBA']
    ];
}
$status_jual = $request->get('status_jual', $this->_arr_status_jual[0]);
$juals = Jual::whereRaw(
    "(kurir_id=0 OR kurir_id=?) AND konsumen_rate=0
 AND waktu_pesan>?",
    [auth()->user()->id, date('Y-m-d')]
)
    ->whereIn('status_jual', $this->_arr_status_jual_map[$status_jual])->paginate();
foreach ($juals as $cur) {
    $cur->alamat_kirim = AlamatKirim::find($cur->alamat_kirim_id);
    $cur->jual_details = JualDetail::whereRaw("jual_id=?", [$cur->id])->get();
}
$arr_status_jual = $this->_arr_status_jual;
$rating_5 = Jual::whereRaw(
    "status_jual='TIBA' AND kurir_id=?",
    [auth()->user()->id]
)->orderBy('waktu_pesan', 'desc')->take(5)
    ->avg('kurir_rate');
$rating_semua = Jual::whereRaw(
    "status_jual='TIBA' AND kurir_id=?",
    [auth()->user()->id]
)->avg('kurir_rate');
$order_minggu_terakhir = Jual::whereRaw(
    "kurir_id=? AND 
 status_jual='TIBA' AND waktu_pesan>=? AND waktu_pesan<?",
    [
        auth()->user()->id, Carbon::today()->subDays(6),
        Carbon::today()->addDays(1)
    ]
)->count();
$order_bulan_ini = Jual::whereRaw(
    "kurir_id=? AND status_jual='TIBA'
 AND waktu_pesan>=? AND waktu_pesan<?",
    [
        auth()->user()->id, Carbon::today()->firstOfMonth(),
        Carbon::today()->firstOfMonth()->addMonths(1)
    ]
)->count();
return view('kurir.home.index', compact(
    'juals',
    'status_jual',
    'arr_status_jual',
    'rating_5',
    'rating_semua',
    'order_minggu_terakhir',
    'order_bulan_ini'
));
