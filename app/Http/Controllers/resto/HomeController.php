<?php

namespace App\Http\Controllers\resto;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jual;
use App\Models\JualDetail;
use App\Models\AlamatKirim;


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
            ->whereIn('status_jual', $this->_arr_status_jual_map[$status_jual])
            ->paginate();
        foreach ($juals as $cur) {
            $cur->alamat_kirim = AlamatKirim::find($cur->alamat_kirim_id);
            $cur->jual_details = JualDetail::whereRaw("jual_id=?", [$cur->id])->get();
        }
        $arr_status_jual = $this->_arr_status_jual;
        $jual = null;
        return view('resto.home.index', compact(
            'juals',
            'status_jual',
            'arr_status_jual',
            'jual'
        ));
    }
}
