<?php

namespace App\Http\Controllers;

use App\Models\Berkas;
use App\Models\Pengukuran;
use App\Models\StatusPu;
use App\Models\User;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function kalender(Request $request)
    {

        $dt_penjadwalan = Berkas::where('void', 0)->where('tgl_pengukuran', '!=', NULL)->get();

        $dt_pengukuran = [];
        foreach ($dt_penjadwalan as $d) {
            $dt_pengukuran[] = [
                'id' => $d->id,
                'title' => $d->nm_pemohon . ' (' . $d->kelurahan . ')',
                'start' => $d->tgl_pengukuran
            ];
        }

        $dt_p = json_encode($dt_pengukuran);

        return view('laporan.kalender', [
            'title' => 'Kalender',
            'dt_p' => $dt_p
        ]);
    }

    public function detailPengukuran($id)
    {
        return view('laporan.detail_pengukuran', [
            'berkas' => Berkas::where('id', $id)->with(['pengukuran', 'pengukuran.petugas'])->first()
        ])->render();
    }

    public function laporanPetugasUkur(Request $request)
    {


        $petugas_ukur = User::where('role_id', 3)->where('aktif', 1)->get();

        if ($request->query('bulan')) {
            $bulan = $request->bulan;
            $tahun = $request->tahun;
        } else {
            $bulan = date('m');
            $tahun = date('Y');
        }

        $tgl = $tahun . '-' . $bulan . '-01';

        $last = date('t', strtotime($tgl));

        $int = (int)$last;

        $dt_periode = [];

        for ($i = 1; $i <= $int; $i++) {
            $dt_periode[] = date('d', strtotime($tahun . '-' . $bulan . '-' . $i));
        }

        $dt_pengukuran = [];

        $pengukuran = Pengukuran::select('pengukuran.berkas_id', 'users.name', 'pengukuran.petugas_id', 'berkas.tgl_pengukuran')->leftJoin('berkas', 'pengukuran.berkas_id', '=', 'berkas.id')->leftJoin('users', 'pengukuran.petugas_id', '=', 'users.id')->where('berkas.void', 0)->where('berkas.proses_id', '!=', 4)->groupBy('berkas.tgl_pengukuran')->groupBy('pengukuran.petugas_id')->get();

        $statusPu = StatusPu::whereMonth('tgl', $bulan)->whereYear('tgl', $tahun)->orderBy('tgl', 'ASC')->groupBy('tgl')->groupBy('petugas_id')->groupBy('status')->with(['petugas'])->get();

        foreach ($petugas_ukur as $p) {
            $dt_tgl = [];
            for ($i = 1; $i <= $int; $i++) {
                $tanggal = date('Y-m-d', strtotime($tahun . '-' . $bulan . '-' . $i));
                $dat_pengukuran = $pengukuran->where('tgl_pengukuran', $tanggal)->where('petugas_id', $p->id)->first();
                $status_1 = $statusPu->where('tgl', $tanggal)->where('petugas_id', $p->id)->where('status', 1)->first();
                $status_2 = $statusPu->where('tgl', $tanggal)->where('petugas_id', $p->id)->where('status', 2)->first();
                $status_3 = $statusPu->where('tgl', $tanggal)->where('petugas_id', $p->id)->where('status', 3)->first();


                if ($status_1 || $status_2 || $status_3) {
                    $status = $status_1 ? '' : ($status_2 ? 'Sibuk' : 'Cuti');
                } elseif ($dat_pengukuran) {
                    $status = 'Sibuk';
                } else {

                    if (date('D', strtotime($tahun . '-' . $bulan . '-' . $i)) == 'Sun') {
                        $status = 'Minggu';
                    } elseif (date('D', strtotime($tahun . '-' . $bulan . '-' . $i)) == 'Sat') {
                        $status = 'Sabtu';
                    } else {
                        $status = '';
                    }
                }

                $dt_tgl[] = [
                    'tgl' => $tanggal,
                    'status' => $status
                ];
            }
            $dt_pengukuran[] = [
                'petugas' => strtoupper($p->name),
                'dt_tgl' => $dt_tgl,
            ];
        }


        return view('laporan.laporan_petugas_ukur', [
            'title' => 'Laporan Petugas Ukur',
            'dt_pengukuran' => $dt_pengukuran,
            'dt_periode' => $dt_periode,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'tgl' => $tgl,
            'petugas' => User::where('role_id', 3)->where('aktif', 1)->get(),
            'list_status' => StatusPu::whereMonth('tgl', $bulan)->whereYear('tgl', $tahun)->with(['petugas'])->orderBy('tgl', 'ASC')->get()
        ]);
    }

    public function addStatusPu(Request $request)
    {
        StatusPu::create([
            'petugas_id' => $request->petugas_id,
            'tgl' => $request->tgl,
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Status berhasil diubah');
    }

    public function dropStatusPu($id)
    {
        StatusPu::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Status berhasil dihapus');
    }

    public function laporanKendala()
    {
        return view('laporan.laporan_kendala', [
            'title' => 'Laporan Berkas Kendala',
            'berkas' => Berkas::where('void', 0)->where('kendala', '!=', NULL)->whereNotIn('proses_id', [6, 4])->with(['uploadFile', 'pengukuran', 'pengukuran.petugas'])->get(),
        ]);
    }

    public function laporanSudahDiukur()
    {
        return view('laporan.laporanSudahDiukur', [
            'title' => 'Laporan Berkas Kendala',
            'berkas' => Berkas::where('void', 0)->where('proses_id', 6)->with(['uploadFile', 'pengukuran', 'pengukuran.petugas'])->get(),
        ]);
    }

    public function laporanPerproses()
    {
        $berkas = Berkas::where('void', 0)->where('proses_id', '!=', 4)->get();

        $berkas_masuk = $berkas->count();
        $menunggu_penjadwalan = $berkas->where('tgl_pengukuran', NULL)->count();
        $sudah_penjadwalan = $berkas->where('tgl_pengukuran', '!=', NULL)->where('proses_id', '!=', 6)->count();
        $sudah_dikur = $berkas->where('proses_id', 6)->count();

        return view('laporan.laporanPerproses', [
            'title' => 'Laporan Berkas Kendala',
            'berkas_masuk' => $berkas_masuk,
            'menunggu_penjadwalan' => $menunggu_penjadwalan,
            'sudah_penjadwalan' => $sudah_penjadwalan,
            'sudah_dikur' => $sudah_dikur,
        ]);
    }
}
