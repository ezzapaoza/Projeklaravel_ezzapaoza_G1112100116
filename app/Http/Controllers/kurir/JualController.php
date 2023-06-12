<?php

namespace App\Http\Controllers\kurir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Jual;
use App\Models\JualDetail;
use App\Models\AlamatKirim;


class JualController extends Controller
{
    public function postantar($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $jual = Jual::find($id);
                $jual->status_jual = 'ANTAR';
                $jual->waktu_antar = date('Y-m-d H:i:s');
                $jual->kurir_id = auth()->user()->id;
                $jual->save();
            }, 5);
        } catch (\Exception $e) {
            return redirect('/kurir/home')
                ->withErrors(['msg' => $e->getMessage()]);
        }
        return redirect('/kurir/home')
            ->with('success', 'Berhasil ubah status order menjadi ANTAR');
    }
    public function posttiba($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $jual = Jual::find($id);
                $jual->status_jual = 'TIBA';
                $jual->waktu_tiba = date('Y-m-d H:i:s');
                $jual->save();
            }, 5);
        } catch (\Exception $e) {
            return redirect('/kurir/home')
                ->withErrors(['msg' => $e->getMessage()]);
        }
        return redirect('/kurir/home')
            ->with('success', 'Berhasil ubah status order menjadi TIBA');
    }
    public function postrate(Request $request, $id)
    {
        try {
            DB::transaction(function () use ($id, $request) {
                $jual = Jual::find($id);
                $jual->konsumen_rate = $request->get('konsumen_rate', 1);
                $jual->save();
            }, 5);
        } catch (\Exception $e) {
            return redirect('/kurir/home')
                ->withErrors(['msg' => $e->getMessage()]);
        }
        return redirect('/kurir/home')
            ->with('success', 'Berhasil beri rating konsumen');
    }
}
