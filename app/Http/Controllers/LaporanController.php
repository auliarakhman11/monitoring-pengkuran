<?php

namespace App\Http\Controllers;

use App\Models\Berkas;
use App\Models\Pengukuran;
use App\Models\User;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function kalender(Request $request)
    {

        $dt_penjadwalan = Berkas::where('void',0)->where('tgl_pengukuran','!=',NULL)->get();

        $dt_pengukuran = []; 
        foreach ($dt_penjadwalan as $d) {
            $dt_pengukuran [] = [
                'id' => $d->id,
                'title' => $d->nm_pemohon.' ('.$d->kelurahan.')',
                'start' => $d->tgl_pengukuran
            ];
        }

        $dt_p = json_encode($dt_pengukuran);

        return view('laporan.kalender', [
            'title' => 'Kalender',
            'dt_p' => $dt_p
        ]);
    }

    public function detailPengukuran($id){
        return view('laporan.detail_pengukuran', [
            'berkas' => Berkas::where('id',$id)->with(['pengukuran','pengukuran.petugas'])->first()
        ])->render();
    }

    public function laporanPetugasUkur(Request $request){

        $petugas_ukur = User::where('role_id', 3)->where('aktif', 1)->get();
        
        if ($request->query('bulan')) {
            $bulan = $request->bulan;
            $tahun = $request->tahun;
        } else {
            $bulan = date('m');
            $tahun = date('Y');
        }

        $tgl = $tahun.'-'.$bulan.'-01';

        $last = date('t', strtotime($tgl));

        $int = (int)$last;

        $dt_periode = [];

        for ($i = 1; $i <= $int; $i++) {
            $dt_periode [] = date('d', strtotime($tahun.'-'.$bulan.'-'.$i));
        }

        $dt_pengukuran = [];

        $pengukuran = Pengukuran::select('pengukuran.berkas_id','users.name','pengukuran.petugas_id','berkas.tgl_pengukuran')->leftJoin('berkas','pengukuran.berkas_id','=','berkas.id')->leftJoin('users','pengukuran.petugas_id','=','users.id')->where('berkas.void',0)->where('berkas.proses_id','!=',4)->groupBy('berkas.tgl_pengukuran')->groupBy('pengukuran.petugas_id')->get();

        foreach ($petugas_ukur as $p) {
            $dt_tgl = [];
            for ($i = 1; $i <= $int; $i++) {
                $tanggal = date('Y-m-d', strtotime($tahun.'-'.$bulan.'-'.$i));
                $dat_pengukuran = $pengukuran->where('tgl_pengukuran',$tanggal)->where('petugas_id',$p->id)->first();
                $dt_tgl [] = [
                    'tgl' => $tanggal,
                    'keluar' => $dat_pengukuran ? 1 : 0,
                ];
            }
            $dt_pengukuran [] = [
                'petugas' => $p->name,
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
        ]);


    }

}
