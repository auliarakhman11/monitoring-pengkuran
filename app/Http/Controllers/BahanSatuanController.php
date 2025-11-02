<?php

namespace App\Http\Controllers;

use App\Models\Bahan;
use App\Models\JenisBahan;
use App\Models\Satuan;
use Illuminate\Http\Request;

class BahanSatuanController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Daftar Bahan',
            'bahan' => Bahan::where('aktif', 'Y')->where('jenis', 1)->orderBy('possition', 'ASC')->with(['satuan', 'jenisBahan'])->get(),
            'satuan' => Satuan::all(),
            'jenis_bahan' => JenisBahan::all(),
        ];
        return view('bahan.index', $data);
    }


    public function addSatuan(Request $request)
    {
        $cek = Satuan::where('satuan', $request->satuan)->first();
        if ($cek) {
            return redirect(route('bahanSatuan'))->with('error', 'Satuan sudah ada');
        } else {
            $data = [
                'satuan' => $request->satuan,
            ];
            Satuan::create($data);
            return redirect(route('bahanSatuan'))->with('success', 'Data berhasil dibuat');
        }
    }

    public function addBahan(Request $request)
    {

        $cek = Bahan::where('bahan', $request->bahan)->where('jenis', 1)->where('aktif', 'Y')->first();

        if ($cek) {
            return redirect(route('bahanSatuan'))->with('error', 'Bahan sudah ada');
        } else {
            $data = [
                'satuan_id' => $request->satuan_id,
                'bahan' => $request->bahan,
                'jenis_bahan_id' => $request->jenis_bahan_id,
                'possition' => 0,
                'jenis' => 1
            ];
            $bahan = Bahan::create($data);


            return redirect(route('bahanSatuan'))->with('success', 'Data berhasil dibuat');
        }
    }

    public function editBahan(Request $request)
    {
        $data = [
            'satuan_id' => $request->satuan_id,
            'bahan' => $request->bahan,
            'jenis_bahan_id' => $request->jenis_bahan_id,
        ];
        Bahan::where('id', $request->id)->update($data);


        return redirect(route('bahanSatuan'))->with('success', 'Data berhasil diubah');
    }

    public function editSatuan(Request $request)
    {
        $data = [
            'satuan' => $request->satuan,
        ];
        Satuan::where('id', $request->id)->update($data);
        return redirect(route('bahanSatuan'))->with('success', 'Data berhasil diubah');
    }

    public function dropDataBahan(Request $request)
    {
        $data = [
            'aktif' => 'T'
        ];

        Bahan::where('id', $request->id)->update($data);
        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }

    public function barangKebutuhan()
    {
        $data = [
            'title' => 'Daftar Barang Kebutuhan',
            'bahan' => Bahan::where('aktif', 'Y')->where('jenis', 2)->orderBy('possition', 'ASC')->with(['satuan'])->get(),
            'satuan' => Satuan::all(),
        ];
        return view('bahan.barang_kebutuhan', $data);
    }

    public function addBarangKebutuhan(Request $request)
    {

        $cek = Bahan::where('bahan', $request->bahan)->where('jenis', 2)->where('aktif', 'Y')->first();

        if ($cek) {
            return redirect(route('bahanSatuan'))->with('error', 'Bahan sudah ada');
        } else {
            $data = [
                'satuan_id' => $request->satuan_id,
                'bahan' => $request->bahan,
                'jenis_bahan_id' => 2,
                'possition' => 0,
                'jenis' => 2
            ];
            $bahan = Bahan::create($data);


            return redirect(route('barangKebutuhan'))->with('success', 'Data berhasil dibuat');
        }
    }

    public function editBarangKebutuhan(Request $request)
    {
        $data = [
            'satuan_id' => $request->satuan_id,
            'bahan' => $request->bahan,
        ];
        Bahan::where('id', $request->id)->update($data);


        return redirect(route('barangKebutuhan'))->with('success', 'Data berhasil diubah');
    }
}
