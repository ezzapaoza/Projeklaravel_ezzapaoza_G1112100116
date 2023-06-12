<?php

namespace App\Http\Controllers\konsumen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Pizza;
use App\Models\Jual;
use App\Models\JualDetail;
use App\Models\AlamatKirim;


class JualController extends Controller
{

    public function order()
    {
        $pizzas = Pizza::paginate();
        $is_cart = Jual::whereRaw(
            "konsumen_id=? AND status_jual='CART'",
            [auth()->user()->id]
        )->first() != null;
        return view('konsumen.jual.order', compact('pizzas', 'is_cart'));
    }
    public function addtocart($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $pizza = Pizza::find($id);
                if ($pizza == null) throw new \Exception('Pizza tidak tersedia');
                $jual = Jual::whereRaw(
                    "konsumen_id=? AND status_jual='CART'",
                    [auth()->user()->id]
                )->first();
                if ($jual == null) {
                    $jual = new Jual();
                    $jual->konsumen_id = auth()->user()->id;
                    $jual->kurir_id = 0;
                    $jual->status_jual = 'CART';
                    $jual->waktu_pesan = null;
                    $jual->waktu_proses = null;
                    $jual->waktu_siap = null;
                    $jual->waktu_antar = null;
                    $jual->waktu_tiba = null;
                    $jual->waktu_batal = null;
                    $jual->keterangan = '';
                    $jual->total_harga = 0;
                    $jual->konsumen_rate = 0;
                    $jual->kurir_rate = 0;
                    $jual->resto_rate = 0;
                    $jual->alamat_kirim_id = 0;
                    $jual->save();
                }
                $jual_detail = JualDetail::whereRaw(
                    "jual_id=? AND pizza_id=?",
                    [$jual->id, $pizza->id]
                )->first();
                if ($jual_detail == null) {
                    $jual_detail = new JualDetail();
                    $jual_detail->jual_id = $jual->id;
                    $jual_detail->pizza_id = $pizza->id;
                    $jual_detail->nama_pizza = $pizza->nama_pizza;
                    $jual_detail->qty = 1;
                    $jual_detail->harga_satuan = $pizza->harga_satuan;
                    $jual_detail->sub_total = $jual_detail->qty *
                        $jual_detail->harga_satuan;
                    $jual_detail->save();
                } else {
                    $jual_detail->qty++;
                    $jual_detail->sub_total = $jual_detail->qty *
                        $jual_detail->harga_satuan;
                    $jual_detail->save();
                }
            }, 5);
        } catch (\Exception $e) {
            return redirect('/konsumen/order')->withErrors(['msg' => $e->getMessage()]);
        }
        return redirect('/konsumen/cart')->with('success', 'Berhasil tambah order');
    }
    public function getcart()
    {
        $jual = Jual::whereRaw(
            "konsumen_id=? AND status_jual='CART'",
            [auth()->user()->id]
        )->first();
        $jual_details = JualDetail::whereRaw("jual_id=?", [$jual->id])->get();
        if ($jual == null) return redirect('/konsumen/order')->withErrors(
            ['msg' => 'Cart masih kosong']
        );
        if (count($jual_details) == 0) return redirect('/konsumen/order')->withErrors(
            ['msg' => 'Cart masih kosong']
        );
        return view('konsumen.jual.cart', compact('jual', 'jual_details'));
    }
    public function postcart(Request $request)
    {
        $pesan = '';
        $redirect_url = 'konsumen/order';
        Validator::make($request->all(), [
            'qty.*' => 'required|numeric|min:1',
        ], [
            'qty.*.required' => 'Qty harus diisi!',
            'qty.*.numeric' => 'Qty harus berupa angka!',
            'qty.*.min' => 'Qty tidak boleh lebih kecil dari :min!'
        ])->validate();
        try {
            DB::transaction(function () use ($request, &$pesan, &$redirect_url) {
                if (
                    $request->action_button == 'checkout' ||
                    $request->action_button == 'order'
                ) {
                    $count = count($request->jual_detail_ids);
                    for ($i = 0; $i < $count; $i++) {
                        $jual_detail_id = $request->jual_detail_ids[$i];
                        $qty = $request->qtys[$i];
                        $jual_detail = JualDetail::find($jual_detail_id);
                        $jual_detail->qty = $qty;
                        $jual_detail->sub_total = $jual_detail->qty *
                            $jual_detail->harga_satuan;
                        $jual_detail->save();
                    }
                    $jual = Jual::find($request->jual_id);
                    $jual->keterangan = $request->keterangan;
                    if ($jual->keterangan == null) $jual->keterangan = '';
                    $jual->save();
                    $pesan = 'Berhasil menyimpan cart';
                    if ($request->action_button == 'checkout') {
                        $redirect_url = '/konsumen/checkout';
                    }
                } else if ($request->action_button == 'hapusall') {
                    $jual_detail_ids = $request->jual_detail_ids;
                    foreach ($jual_detail_ids as $jual_detail_id) {
                        $jual_detail = JualDetail::find($jual_detail_id);
                        $jual_detail->delete();
                    }
                    $jual_id = $request->jual_id;
                    $jual = Jual::find($jual_id);
                    $jual->delete();
                    $pesan = 'Berhasil mengosongkan cart';
                } else if (substr($request->action_button, 0, 5) == 'hapus') {
                    $jual_detail_id = substr($request->action_button, 5);
                    $jual_detail = JualDetail::find($jual_detail_id);
                    $jual_detail->delete();
                    $jual_id = $request->jual_id;
                    $jual_details = JualDetail::whereRaw("jual_id=?", [$jual_id])->get();
                    if (count($jual_details) == 0) {
                        $jual = Jual::find($jual_id);
                        $jual->delete();
                    }
                    $pesan = 'Berhasil menghapus detail cart';
                }
            }, 5);
        } catch (\Exception $e) {
            return redirect('/konsumen/order')->withErrors(['msg' => $e->getMessage()]);
        }
        return redirect($redirect_url)->with('success', $pesan);
    }
    public function getcheckout()
    {
        $alamat_kirims = AlamatKirim::whereRaw(
            "konsumen_id=? AND 1=1",
            [auth()->user()->id]
        )->orderByRaw('is_default DESC')->get();
        $jual = Jual::whereRaw(
            "konsumen_id=? AND status_jual='CART'",
            [auth()->user()->id]
        )->first();
        $jual_details = JualDetail::whereRaw("jual_id=?", [$jual->id])->get();
        $jual->total_harga = JualDetail::whereRaw(
            "jual_id=?",
            [$jual->id]
        )->sum('sub_total');
        $jual->alamat_kirim_id = AlamatKirim::whereRaw(
            "konsumen_id=? AND is_default=1",
            [auth()->user()->id]
        )->first()->id;
        if ($jual == null) return redirect('/konsumen/order')->withErrors(
            ['msg' => 'Cart masih kosong']
        );
        if (count($jual_details) == 0) return redirect('/konsumen/order')->withErrors(
            ['msg' => 'Cart masih kosong']
        );
        return view('konsumen.jual.checkout', compact(
            'jual',
            'jual_details',
            'alamat_kirims'
        ));
    }
    public function postcheckout(Request $request)
    {
        $alamat_kirim_id = $request->get('alamat_kirim_id', 0);
        $alamat_kirim = AlamatKirim::whereRaw(
            "konsumen_id=? AND id=?",
            [auth()->user()->id, $alamat_kirim_id]
        )->first();
        if ($alamat_kirim == null) return redirect('/konsumen/checkout')->withErrors(
            ['msg' => 'Alamat kirim belum dipilih!']
        );
        try {
            DB::transaction(function () use ($request, $alamat_kirim) {
                $jual = Jual::find($request->jual_id);
                $jual->status_jual = 'PESAN';
                $jual->waktu_pesan = date('Y-m-d H:i:s');
                $jual->total_harga = JualDetail::whereRaw(
                    "jual_id=?",
                    [$request->jual_id]
                )->sum('sub_total');
                $jual->alamat_kirim_id = $alamat_kirim->id;
                $jual->save();
            }, 5);
        } catch (\Exception $e) {
            return redirect('/konsumen/checkout')->withErrors(
                ['msg' => $e->getMessage()]
            );
        }
        return redirect('/konsumen/home')->with('success', 'Berhasil membuat order');
    }
    public function gettrack(Request $request, $id)
    {
        $jual = Jual::find($id);
        $jual_details = JualDetail::whereRaw("jual_id=?", [$id])->get();
        $alamat_kirim = AlamatKirim::find($jual->alamat_kirim_id);
        if ($jual == null || count($jual_details) == 0) {
            return redirect('/konsumen/home')->withErrors(
                ['msg' => 'Kode tracking tidak dikenal']
            );
        }
        return view('konsumen.jual.track', compact('jual', 'jual_details', 'alamat_kirim'));
    }
    public function postcancel($id)
    {
        try {
            $jual = Jual::find($id);
            $jual->status_jual = 'BATAL';
            $jual->waktu_batal = date('Y-m-d H:i:s');
            $jual->save();
        } catch (\Exception $e) {
            return redirect('/konsumen/home')->withErrors(['msg' => $e->getMessage()]);
        }
        return redirect('/konsumen/home')->with('success', 'Berhasil membatalkan order');
    }
}
