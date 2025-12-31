<?php

namespace App\Http\Controllers;

use App\Models\Berkas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BerkasController extends Controller
{
    public function loket(Request $request)
    {

        if ($request->query('tgl1')) {
            $tgl1 = $request->tgl1;
            $tgl2 = $request->tgl2;
        } else {
            $tgl1 = date('Y-m-d');
            $tgl2 = date('Y-m-d');
        }

        return view('berkas.loket', [
            'title' => 'Loket',
            'berkas' => Berkas::where('proses_id', 1)->where('void', 0)->where('tgl', '>=', $tgl1)->where('tgl', '<=', $tgl2)->get(),
            'tgl1' => $tgl1,
            'tgl2' => $tgl2
        ]);
    }

    public function addBerkas(Request $request)
    {

        if ($request->hasFile('file_name')) {
            $extension = $request->file('file_name')->extension();
            $file_name = Str::random(5) . date('ymd') . '.' . $extension;
            $request->file('file_name')->move('file_upload/', $file_name);
        } else {
            $extension = NULL;
            $file_name = NULL;
        }

        Berkas::create([
            'proses_id' => 1,
            'no_berkas' => $request->no_berkas,
            'tahun' => $request->tahun,
            'kelurahan' => $request->kelurahan,
            'alamat' => $request->alamat,
            'nm_pemohon' => $request->nm_pemohon,
            'no_tlp' => $request->no_tlp,
            'tgl' => $request->tgl,
            'user_id' => Auth::id(),
            'void' => 0,
            'file_name' => $file_name,
            'jenis_file' => $extension
        ]);

        return redirect()->back()->with('success', 'Berkas berhasil dibuat');
    }

    public function editBerkas(Request $request)
    {
        Berkas::where('id', $request->id)->update([
            'no_berkas' => $request->no_berkas,
            'tahun' => $request->tahun,
            'kelurahan' => $request->kelurahan,
            'alamat' => $request->alamat,
            'nm_pemohon' => $request->nm_pemohon,
            'no_tlp' => $request->no_tlp,
            'tgl' => $request->tgl,
            'user_id' => Auth::id()
        ]);

        return redirect()->back()->with('success', 'Berkas berhasil diedit');
    }

    public function penjadwalan()
    {

        return view('berkas.penjadwalan', [
            'title' => 'Penjadwalan',
            'berkas' => Berkas::where('proses_id', 1)->where('void', 0)->with(['pengukuran', 'pengukuran.petugas'])->get(),
            'petugas' => User::where('role_id', 3)->where('aktif', 1)->get(),
        ]);
    }

    public function dropBerkas(Request $request)
    {
        Berkas::where('id', $request->id)->update([
            'void' => 1,
            'user_id' => Auth::id()
        ]);

        return redirect()->back()->with('success', 'Berkas berhasil dihapus');
    }
}
