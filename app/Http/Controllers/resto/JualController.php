<?php

namespace App\Http\Controllers\resto;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Jual;
use App\Models\JualDetail;
use App\Models\AlamatKirim;
use App\Models\User;

class JualController extends Controller
{
    public function postproses($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $jual = Jual::find($id);
                $jual->status_jual = 'PROSES';
                $jual->waktu_proses = date('Y-m-d H:i:s');
                $jual->save();
            }, 5);
        } catch (\Exception $e) {
            return redirect('/resto/home')
                ->withErrors(['msg' => $e->getMessage()]);
        }
        return redirect('/resto/home')
            ->with('success', 'Berhasil ubah status order menjadi PROSES');
    }
    public function postsiap($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $jual = Jual::find($id);
                $jual->status_jual = 'SIAP';
                $jual->waktu_siap = date('Y-m-d H:i:s');
                $jual->save();
            }, 5);
        } catch (\Exception $e) {
            return redirect('/resto/home')
                ->withErrors(['msg' => $e->getMessage()]);
        }
        return redirect('/resto/home')
            ->with('success', 'Berhasil ubah status order menjadi SIAP');
    }
    public function postcancel($id)
    {
        try {
            $jual = Jual::find($id);
            $jual->status_jual = 'BATAL';
            $jual->waktu_batal = date('Y-m-d H:i:s');
            $jual->save();
        } catch (\Exception $e) {
            return redirect('/resto/home')
                ->withErrors(['msg' => $e->getMessage()]);
        }
        return redirect('/resto/home')
            ->with('success', 'Berhasil membatalkan order');
    }
    public function gettrack(Request $request, $id)
    {
        $jual = Jual::find($id);
        $jual_details = JualDetail::whereRaw("jual_id=?", [$id])
            ->get();
        $alamat_kirim = AlamatKirim::find($jual->alamat_kirim_id);
        if ($jual == null || count($jual_details) == 0) {
            return redirect('/resto/home')
                ->withErrors(['msg' => 'Kode tracking tidak dikenal']);
        }
        return view(
            'resto.jual.track',
            compact('jual', 'jual_details', 'alamat_kirim')
        );
    }
}
$jual = Jual::find($id);
$jual_details = JualDetail::whereRaw("jual_id=?", [$id])->get();
$alamat_kirim = AlamatKirim::find($jual->alamat_kirim_id);
$kurir = User::find($jual->kurir_id);
if ($jual == null || count($jual_details) == 0) {
    return redirect('/resto/home')
        ->withErrors(['msg' => 'Kode tracking tidak dikenal']);
}
return view(
    'resto.jual.track',
    compact('jual', 'jual_details', 'alamat_kirim', 'kurir')
);
