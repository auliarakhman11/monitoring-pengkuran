<?php

namespace App\Http\Controllers;

use App\Models\Berkas;
use App\Models\History;
use App\Models\Pengukuran;
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
            'berkas' => Berkas::where('proses_id', 1)->where('void', 0)->where('tgl', '>=', $tgl1)->where('tgl', '<=', $tgl2)->orderBy('berkas.id', 'DESC')->get(),
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

        $berkas = Berkas::create([
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

        History::create([
            'berkas_id' => $berkas->id,
            'proses_id' => 1,
            'user_id' => Auth::id(),
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
            'berkas' => Berkas::where('proses_id', 1)->where('void', 0)->with(['pengukuran', 'pengukuran.petugas'])->orderBy('berkas.id', 'ASC')->get(),
            'petugas' => User::where('role_id', 3)->where('aktif', 1)->get(),
        ]);
    }

    public function dropBerkas($id)
    {
        Berkas::where('id', $id)->update([
            'void' => 1,
            'user_id' => Auth::id()
        ]);

        return redirect()->back()->with('success', 'Berkas berhasil dihapus');
    }

    public function addPengukuranAdmin(Request $request)
    {
        Berkas::where('id', $request->id)->update([
            'tgl_pengukuran' => $request->tgl_pengukuran
        ]);

        $petugas_id = $request->petugas_id;

        if (count($petugas_id) > 0) {

            for ($count = 0; $count < count($petugas_id); $count++) {
                if ($petugas_id[$count] == '') {
                    continue;
                }
                Pengukuran::create([
                    'berkas_id' => $request->id,
                    'petugas_id' => $petugas_id[$count],
                    'user_id' => Auth::id(),
                    'void' => 0
                ]);
            }
        }

        return redirect()->back()->with('success', 'Pengkuran berhasil dijadwalkan');
    }

    public function dropPengkuran($id)
    {
        Pengukuran::where('id', $id)->update([
            'void' => 1,
            'user_id' => Auth::id()
        ]);

        return redirect()->back()->with('success', 'Data petugas berhasil dihapus');
    }

    public function addPengukuranPetugas(Request $request)
    {
        Berkas::where('id', $request->id)->update([
            'tgl_pengukuran' => $request->tgl_pengukuran
        ]);

        Pengukuran::create([
            'berkas_id' => $request->id,
            'petugas_id' => $request->petugas_id,
            'user_id' => Auth::id(),
            'void' => 0
        ]);

        return redirect()->back()->with('success', 'Pengkuran berhasil dijadwalkan');
    }

    public function tutupBerkas(Request $request)
    {
        Berkas::where('id', $request->id)->update([
            'proses_id' => 4,
            'ket' => $request->ket,
            'user_id' => Auth::id()
        ]);

        History::where('berkas_id', $request->id)->where('selesai', NULL)->update([
            'selesai' => date('Y-m-d H:i:s')
        ]);

        History::create([
            'berkas_id' => $request->id,
            'proses_id' => 4,
            'user_id' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Berkas berhasil ditutup');
    }

    public function spsBerkas()
    {
        return view('berkas.sps_berkas', [
            'title' => 'Penjadwalan',
            'berkas' => Berkas::select('berkas.*')->selectRaw("datediff(current_date(), berkas.updated_at) as lama_tgl")->whereIn('proses_id', [1, 2])->where('void', 0)->where('tgl_pengukuran', '!=', NULL)->with(['pengukuran', 'pengukuran.petugas', 'proses'])->orderBy('proses_id', 'DESC')->orderBy('berkas.id', 'ASC')->get(),
        ]);
    }

    public function cetakSpsBerkas($id)
    {
        Berkas::where('id', $id)->update([
            'proses_id' => 2,
            'user_id' => Auth::id()
        ]);

        History::where('berkas_id', $id)->where('selesai', NULL)->update([
            'selesai' => date('Y-m-d H:i:s')
        ]);

        History::create([
            'berkas_id' => $id,
            'proses_id' => 2,
            'user_id' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'SPS dicetak');
    }

    public function pembayaranSpsBerkas($id)
    {
        Berkas::where('id', $id)->update([
            'proses_id' => 3,
            'user_id' => Auth::id()
        ]);

        History::where('berkas_id', $id)->where('selesai', NULL)->update([
            'selesai' => date('Y-m-d H:i:s')
        ]);

        History::create([
            'berkas_id' => $id,
            'proses_id' => 3,
            'user_id' => Auth::id(),
            'selesai' => date('Y-m-d H:i:s')
        ]);

        return redirect()->back()->with('success', 'SPS dibayar');
    }

    public function selesaiSpsBerkas()
    {
        return view('berkas.selesai_sps_berkas', [
            'title' => 'Penjadwalan',
            'berkas' => Berkas::select('berkas.*')->where('proses_id', 3)->where('void', 0)->where('tgl_pengukuran', '!=', NULL)->with(['pengukuran', 'pengukuran.petugas', 'proses'])->orderBy('berkas.id', 'ASC')->get(),
        ]);
    }

}
