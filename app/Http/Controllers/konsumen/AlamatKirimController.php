<?php

namespace App\Http\Controllers\konsumen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\AlamatKirim;

class AlamatKirimController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $alamatkirims = AlamatKirim::whereRaw("konsumen_id=?", [auth()->user()->id])
            ->paginate();
        $is_no_default = AlamatKirim::whereRaw(
            "konsumen_id=? AND is_default=1",
            [auth()->user()->id]
        )->first() == null;
        return view('konsumen.alamatkirim.index', compact(['alamatkirims', 'is_no_default']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('konsumen.alamatkirim.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        Validator::make($request->all(), [
            'nama_penerima' => 'required',
            'alamat' => 'required'
        ], [
            'nama_penerima.required' => 'Nama penerima harus diisi!',
            'alamat.required' => 'alamat harus diisi!',

        ])->validate();
        try {
            $alamat_kirim = new AlamatKirim();
            $alamat_kirim->nama_penerima = $request->nama_penerima;
            $alamat_kirim->alamat = $request->alamat;
            $alamat_kirim->konsumen_id = auth()->user()->id;
            $alamat_kirim->is_default = 0;
            $alamat_kirim->save();
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['msg' => $e->getMessage()]);
        }
        return redirect('/konsumen/alamatkirim')->with('success', 'Berhasil tambah data');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $alamat_kirim = AlamatKirim::find($id);
        return view('konsumen.alamatkirim.edit', compact(['alamat_kirim']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        Validator::make($request->all(), [
            'nama_penerima' => 'required',
            'alamat' => 'required'
        ], [
            'nama_penerima.required' => 'Nama penerima harus diisi!',
            'alamat.required' => 'Alamat harus diisi!'
        ])->validate();
        try {
            $alamat_kirim = AlamatKirim::find($id);
            $alamat_kirim->nama_penerima = $request->nama_penerima;
            $alamat_kirim->alamat = $request->alamat;
            $alamat_kirim->save();
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['msg' => $e->getMessage()]);
        }
        return redirect('/konsumen/alamatkirim')->with('success', 'Berhasil ubah data');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $alamat_kirim = AlamatKirim::find($id);
            $alamat_kirim->delete();
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['msg' => $e->getMessage()]);
        }
        return redirect('/konsumen/alamatkirim')->with('success', 'Berhasil hapus data');
    }
    public function default($id)
    {
        //
        try {
            $default_lama = AlamatKirim::whereRaw(
                "konsumen_id=? AND is_default=1",
                [auth()->user()->id]
            )->first();
            if ($default_lama != null) {
                $default_lama->is_default = 0;
                $default_lama->save();
            }
            $default_baru = AlamatKirim::find($id);
            $default_baru->is_default = 1;
            $default_baru->save();
        } catch (\Exception $e) {
            return redirect()->back()->withInput()
                ->withErrors(['msg' => $e->getMessage()]);
        }
        return redirect('/konsumen/alamatkirim')
            ->with('success', 'Berhasil ubah alamat default');
    }
}
