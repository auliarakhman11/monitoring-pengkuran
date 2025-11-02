<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Daftar Pembayaran',
            'pembayaran' => Pembayaran::all()
        ];
        return view('pembayaran.index', $data);
    }

    public function addPembayaran(Request $request)
    {
        Pembayaran::create([
            'pembayaran' => $request->pembayaran,
            'aktif' => $request->aktif,

        ]);
        return redirect()->back()->with('success', 'Data pembayaran berhasil dibuat');
    }

    public function editPembayaran(Request $request)
    {
        $data = [
            'pembayaran' => $request->pembayaran,
            'aktif' => $request->aktif,
        ];
        Pembayaran::where('id', $request->id)->update($data);

        return redirect()->back()->with('success', 'Data pembayaran berhasil diubah');
    }
}
