<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\Karyawan;

use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Karyawan',
            'karyawan' => Karyawan::where('aktif', 1)->orderBy('possition', 'ASC')->with('cabang')->get(),
            'cabang' => Cabang::all()

        ];
        return view('karyawan.index', $data);
    }

    public function addKaryawan()
    {
        Karyawan::create([
            'nama' => request('nama'),
            'status' => request('status'),
            'no_tlp' => request('no_tlp'),
            'tgl_masuk' => request('tgl_masuk'),
            'alamat' => request('alamat'),
            'cabang_id' => request('cabang_id'),
            'gapok' => request('gapok'),
            'aktif' => 1,
        ]);
        return redirect()->back()->with('success', 'Data karyawan berhasil dibuat');
    }

    public function editKaryawan(Request $request)
    {
        $data = [
            'nama' => $request->nama,
            'status' => $request->status,
            'no_tlp' => $request->no_tlp,
            'tgl_masuk' => $request->tgl_masuk,
            'alamat' => $request->alamat,
            'gapok' => $request->gapok,
            'cabang_id' => $request->cabang_id,

        ];
        Karyawan::where('id', $request->id)->update($data);

        return redirect()->back()->with('success', 'Data karyawan berhasil diubah');
    }

    public function dropKaryawan(Request $request)
    {
        // Karyawan::find($request->id)->delete();
        Karyawan::where('id', $request->id)->update([
            'aktif' => 0
        ]);
        return redirect()->back()->with('success', 'Data karyawan berhasil dihapus');
    }
}
