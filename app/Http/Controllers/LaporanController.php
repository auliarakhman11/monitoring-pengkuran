<?php

namespace App\Http\Controllers;

use App\Models\Berkas;
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

}
