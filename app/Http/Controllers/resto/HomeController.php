<?php

namespace App\Http\Controllers\resto;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jual;
use App\Models\JualDetail;
use App\Models\AlamatKirim;
use Illuminate\Support\Carbon;


class HomeController extends Controller
{
    protected $_arr_status_jual = [
        'RESPON', 'SIAP', 'PROSES', 'PESAN', 'BERJALAN',
        'SELESAI', 'BATAL'
    ];
    protected $_arr_status_jual_map = [
        'RESPON' => ['PESAN', 'PROSES'],
        'SIAP' => ['SIAP'],
        'PROSES' => ['PROSES'],
        'PESAN' => ['PESAN'],
        'BERJALAN' => ['PESAN', 'PROSES', 'SIAP', 'ANTAR'],
        'SELESAI' => ['TIBA'],
        'BATAL' => ['BATAL']
    ];
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $status_jual = $request->get('status_jual', $this->_arr_status_jual[0]);
        $juals = Jual::where('waktu_pesan', '>=', date('Y-m-d'))
            ->whereIn('status_jual', $this->_arr_status_jual_map[$status_jual])->paginate();
        foreach ($juals as $cur) {
            $cur->alamat_kirim = AlamatKirim::find($cur->alamat_kirim_id);
            $cur->jual_details = JualDetail::whereRaw("jual_id=?", [$cur->id])->get();
        }
        $arr_status_jual = $this->_arr_status_jual;
        $jual = null;
        $rating_50 = Jual::whereRaw("status_jual='TIBA'", [])->orderBy('waktu_pesan', 'desc')
            ->take(50)->avg('resto_rate');
        $rating_semua = Jual::whereRaw("status_jual='TIBA'", [])->avg('resto_rate');
        $order_minggu_terakhir = Jual::whereRaw("status_jual='TIBA' AND waktu_pesan>=? AND 
        waktu_pesan<?", [Carbon::today()->subDays(6), Carbon::today()->addDays(1)])->count();
        $order_bulan_ini = Jual::whereRaw("status_jual='TIBA' AND waktu_pesan>=? AND 
        waktu_pesan<?", [Carbon::today()->firstOfMonth(), Carbon::today()
            ->firstOfMonth()->addMonths(1)])->count();
        $order_di_batalkan = Jual::whereRaw("status_jual='BATAL' AND waktu_pesan>=? AND 
        waktu_pesan<?", [Carbon::today()->subDays(6), Carbon::today()->addDays(1)])->count();
        return view('resto.home.index', compact(
            'juals',
            'status_jual',
            'arr_status_jual',
            'jual',
            'rating_50',
            'rating_semua',
            'order_minggu_terakhir',
            'order_bulan_ini',
            'order_di_batalkan',
        ));
    }
}
