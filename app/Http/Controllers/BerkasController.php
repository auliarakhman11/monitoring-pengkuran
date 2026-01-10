<?php

namespace App\Http\Controllers;

use App\Models\Berkas;
use App\Models\History;
use App\Models\Pengukuran;
use App\Models\Permohonan;
use App\Models\UploadFile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
            'berkas' => Berkas::where('proses_id', 5)->where('void', 0)->where('tgl', '>=', $tgl1)->where('tgl', '<=', $tgl2)->orderBy('berkas.id', 'DESC')->with('permohonan')->get(),
            'permohonan' => Permohonan::all(),
            'tgl1' => $tgl1,
            'tgl2' => $tgl2
        ]);
    }

    public function addBerkas(Request $request)
    {

        if ($request->hasFile('file_name')) {
            $extension = $request->file('file_name')->extension();
            $file_name = Str::random(1) . Auth::id() . date('ym') . '.' . $extension;
            $request->file('file_name')->move('file_upload/', $file_name);
        } else {
            $extension = NULL;
            $file_name = NULL;
        }

        $dt_urutan = Berkas::whereYear('tgl', date('Y'))->where('urutan', '!=', NULL)->orderBy('urutan', 'DESC')->first();

        if ($dt_urutan) {
            $urutan = $dt_urutan->urutan + 1;
        } else {
            $urutan = 1;
        }


        // $no_sistem = 'SP-' . strtoupper(Str::random(2)) . Auth::id() . date('ym');
        $no_sistem = 'SP-' . $urutan;

        $berkas = Berkas::create([
            'permohonan_id' => $request->permohonan_id,
            'kuasa' => $request->kuasa,
            'proses_id' => 5,
            'no_sistem' => $no_sistem,
            'urutan' => $urutan,
            'kelurahan' => $request->kelurahan,
            'alamat' => $request->alamat,
            'nm_pemohon' => $request->nm_pemohon,
            'no_tlp' => $request->no_tlp,
            'tgl' => $request->tgl,
            'user_id' => Auth::id(),
            'void' => 0,
            // 'file_name' => $file_name,
            // 'jenis_file' => $extension
        ]);

        History::create([
            'berkas_id' => $berkas->id,
            'proses_id' => 5,
            'user_id' => Auth::id(),
        ]);

        return redirect()->back()->with('no_sistem', $no_sistem);
    }

    public function editBerkas(Request $request)
    {
        Berkas::where('id', $request->id)->update([
            'permohonan_id' => $request->permohonan_id,
            'no_berkas' => $request->no_berkas,
            'tahun' => $request->tahun,
            'kelurahan' => $request->kelurahan,
            'alamat' => $request->alamat,
            'nm_pemohon' => $request->nm_pemohon,
            'kuasa' => $request->kuasa,
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

        $cek = Pengukuran::where('petugas_id', $request->petugas_id)->where('berkas_id', $request->id)->first();

        if (!$cek) {
            Pengukuran::create([
                'berkas_id' => $request->id,
                'petugas_id' => $request->petugas_id,
                'user_id' => Auth::id(),
                'void' => 0
            ]);
        }



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

    public function pembayaranSpsBerkas(Request $request)
    {
        Berkas::where('id', $request->id)->update([
            'proses_id' => 3,
            'no_berkas' => $request->no_berkas,
            'tahun' => $request->tahun,
            'user_id' => Auth::id()
        ]);

        History::where('berkas_id', $request->id)->where('selesai', NULL)->update([
            'selesai' => date('Y-m-d H:i:s')
        ]);

        History::create([
            'berkas_id' => $request->id,
            'proses_id' => 3,
            'user_id' => Auth::id(),
            'selesai' => date('Y-m-d H:i:s')
        ]);

        return redirect()->back()->with('success', 'SPS dibayar');
    }

    public function selesaiSpsBerkas()
    {

        if (session()->get('role_id') == 3) {
            $berkas = Berkas::select('berkas.*')->leftJoin("pengukuran", 'berkas.id', '=', 'pengukuran.berkas_id')->where('berkas.proses_id', 3)->where('berkas.void', 0)->where('berkas.tgl_pengukuran', '!=', NULL)->where('petugas_id', Auth::id())->with(['pengukuran', 'pengukuran.petugas', 'proses'])->orderBy('berkas.id', 'ASC')->groupBy('berkas.id')->get();
        } else {
            $berkas = Berkas::select('berkas.*')->where('proses_id', 3)->where('void', 0)->where('tgl_pengukuran', '!=', NULL)->with(['pengukuran', 'pengukuran.petugas', 'proses'])->orderBy('berkas.id', 'ASC')->get();
        }


        return view('berkas.selesai_sps_berkas', [
            'title' => 'Penjadwalan',
            'berkas' => $berkas,
        ]);
    }

    public function pengecekan()
    {

        return view('berkas.pengecekan', [
            'title' => 'Pengecekan',
            'berkas' => Berkas::where('proses_id', 5)->where('void', 0)->with(['uploadFile'])->orderBy('berkas.id', 'ASC')->get(),
            'petugas' => User::where('role_id', 3)->where('aktif', 1)->get(),
        ]);
    }

    public function uplaodBerkas(Request $request)
    {
        $nm_file = $request->nm_file;

        foreach ($request->file('file_name') as $index => $file) {
            $extension = $file->extension();
            $file_name = Str::random(5) . date('ymd') . '.' . $extension;
            $file->move('file_upload/', $file_name);

            UploadFile::create([
                'berkas_id' => $request->id,
                'nm_file' => $nm_file[$index],
                'file_name' => $file_name,
                'jenis_file' => $extension
            ]);
        }

        // if ($request->hasFile('file_name')) {
        //     $extension = $request->file('file_name')->extension();
        //     $file_name = Str::random(5) . date('ymd') . '.' . $extension;
        //     $request->file('file_name')->move('file_upload/', $file_name);
        // } else {
        //     $extension = NULL;
        //     $file_name = NULL;
        // }

        return redirect()->back()->with('success', 'Berkas berhasil diuplaod');
    }

    public function deleteBerkas($id)
    {
        $file = UploadFile::where('id', $id);
        $dt_file = $file->first();
        File::delete('file_upload/' . $dt_file->file_name);
        $file->delete();
        return redirect()->back()->with('success', 'File berhasil dihapus');
    }

    public function kendalaBerkas(Request $request)
    {
        Berkas::where('id', $request->id)->update([
            'kendala' => $request->kendala
        ]);

        return redirect()->back()->with('success', 'Kendala berhasil diinput');
    }

    public function lanjutPengecekan($id)
    {
        Berkas::where('id', $id)->update([
            'proses_id' => 1,
            'user_id' => Auth::id()
        ]);

        History::where('berkas_id', $id)->where('selesai', NULL)->update([
            'selesai' => date('Y-m-d H:i:s')
        ]);

        History::create([
            'berkas_id' => $id,
            'proses_id' => 1,
            'user_id' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Berkas dilanjutkan');
    }

    public function sudahDiukur($id)
    {
        Berkas::where('id', $id)->update([
            'proses_id' => 6,
            'user_id' => Auth::id()
        ]);

        History::where('berkas_id', $id)->where('selesai', NULL)->update([
            'selesai' => date('Y-m-d H:i:s')
        ]);

        History::create([
            'berkas_id' => $id,
            'proses_id' => 6,
            'user_id' => Auth::id(),
            'selesai' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->back()->with('success', 'Bidang sudah diukur');
    }

    public function importBerkas()
    {

        return view('berkas.import_data', [
            'title' => 'Import',

        ]);
    }

    public function importDataBerkas(Request $request)
    {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx;
        $spreadsheet = $reader->load($_FILES['file_excel']['tmp_name']);

        $sheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        $numrow = 1;


        foreach ($sheet as $row) {

            if ($row['A'] == "" &&  $row['B'] == "" &&  $row['C'] == "" &&  $row['D'] == "" &&  $row['E'] == "" &&  $row['F'] == "" &&  $row['G'] == "" &&  $row['H'] == "")
                continue;

            // $datetime = DateTime::createFromFormat('Y-m-d', $row['A']);
            if ($numrow > 1) {

                $no_sistem = 'SP-' . strtoupper(Str::random(2)) . Auth::id() . date('ym');

                if ($row['O'] == 'Kendala') {
                    $kendala = $row['P'];
                } else {
                    $kendala = NULL;
                }


                $berkas = Berkas::create([
                    'proses_id' => 1,
                    'no_sistem' => $no_sistem,
                    'kelurahan' => NULL,
                    'alamat' => NULL,
                    'nm_pemohon' => $row['I'],
                    'no_tlp' => NULL,
                    'tgl' => date('Y-m-d'),
                    'user_id' => Auth::id(),
                    'void' => 0,
                    'kendala' => $kendala,
                    'no_berkas' => $row['B'],
                    'tahun' => $row['C']
                    // 'file_name' => $file_name,
                    // 'jenis_file' => $extension
                ]);

                History::create([
                    'berkas_id' => $berkas->id,
                    'proses_id' => 5,
                    'user_id' => Auth::id(),
                    'selesai' => date('Y-m-d H:i:s')
                ]);

                History::create([
                    'berkas_id' => $berkas->id,
                    'proses_id' => 1,
                    'user_id' => Auth::id(),
                    'selesai' => date('Y-m-d H:i:s')
                ]);

                if ($row['N'] != "") {
                    Pengukuran::create([
                        'berkas_id' => $berkas->id,
                        'petugas_id' => $row['N'],
                        'user_id' => Auth::id(),
                        'void' => 0
                    ]);
                }
            }
            $numrow++; // Tambah 1 setiap kali looping
        }

        return redirect(route('import'))->with('success', 'Berkas berhasil diimport');
    }
}
