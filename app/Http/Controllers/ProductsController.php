<?php

namespace App\Http\Controllers;

use App\Models\Bahan;
use App\Models\Delivery;
use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Harga;
use App\Models\Cabang;
use App\Models\ProdukCabang;
use App\Models\Resep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Products',
            'kategori' => Kategori::orderBy('possition', 'ASC')->get(),
            'delivery' => Delivery::all(),
            'produk' => Produk::orderBy('possition', 'ASC')->with(['kategori', 'getHarga', 'getHarga.delivery', 'produkCabang'])->where('hapus', 0)->get(),
            'bahan' => Bahan::orderBy('possition', 'ASC')->where('aktif', 'Y')->where('jenis', 1)->get(),
            'cabang' => Cabang::where('off', 0)->get()
        ];
        // $produk = Produk::with(['kategori','getHarga.delivery'])->get();
        // dd($produk[0]);
        return view('produk.index', $data);
        // $produk = Produk::with(['kategori','getHarga'])->first();

    }

    public function addProduct(Request $request)
    {
        if ($request->cabang_id) {
            $request->validate([
                'foto' => 'image|mimes:jpg,png,jpeg'
            ]);
            // if($request->file('foto')){
            //     $foto = $request->file('foto')->store('img-produk');
            // }else{
            //     $foto='';
            // }

            if ($request->hasFile('foto')) {
                $request->file('foto')->move('img-produk/', $request->file('foto')->getClientOriginalName());
                $foto = 'img-produk/' . $request->file('foto')->getClientOriginalName();
            } else {
                $foto = '';
            }


            $data = [
                'kategori_id' => $request->kategori_id,
                'nm_produk' => $request->nm_produk,
                'status' => $request->status,
                'tampil_varian' => $request->tampil_varian,
                'diskon ' => 0,
                'foto' => $foto,
                'possition' => 0,
                'hapus' => 0,
            ];
            $produk = Produk::create($data);
            if ($request->delivery_id) {
                $delivery_id = $request->delivery_id;
                $harga = $request->harga;

                for ($count = 0; $count < count($delivery_id); $count++) {
                    $delivery = [
                        'produk_id' => $produk->id,
                        'delivery_id' => $delivery_id[$count],
                        'harga' => $harga[$count]
                    ];
                    Harga::create($delivery);
                }
            }

            $cabang_id = $request->cabang_id;
            ProdukCabang::where('produk_id', $produk->id)->delete();
            for ($count = 0; $count < count($cabang_id); $count++) {


                ProdukCabang::create([
                    'produk_id' => $produk->id,
                    'cabang_id' => $cabang_id[$count]
                ]);
            }

            return redirect(route('products'))->with('success', 'Data berhasil dibuat');
        } else {
            return redirect(route('products'))->with('error', 'Masukan data cabang terlebih dahulu');
        }
    }

    public function editProduk(Request $request)
    {
        if ($request->cabang_id) {

            $request->validate([
                'foto' => 'image|mimes:jpg,png,jpeg'
            ]);
            if ($request->file('foto')) {
                $request->file('foto')->move('img-produk/', $request->file('foto')->getClientOriginalName());
                $foto = 'img-produk/' . $request->file('foto')->getClientOriginalName();
                $data = [
                    'kategori_id' => $request->kategori_id,
                    'nm_produk' => $request->nm_produk,
                    'status' => $request->status,
                    'tampil_varian' => $request->tampil_varian,
                    'foto' => $foto
                ];
            } else {
                $data = [
                    'kategori_id' => $request->kategori_id,
                    'nm_produk' => $request->nm_produk,
                    'status' => $request->status,
                    'tampil_varian' => $request->tampil_varian,
                ];
            }


            Produk::where('id', $request->id)->update($data);
            if ($request->delivery_id) {
                $delivery_id = $request->delivery_id;
                $harga = $request->harga;

                for ($count = 0; $count < count($delivery_id); $count++) {
                    $delivery = [
                        'harga' => $harga[$count]
                    ];
                    $cek = Harga::where('delivery_id', $delivery_id[$count])->where('produk_id', $request->id)->first();
                    if ($cek) {
                        Harga::where('delivery_id', $delivery_id[$count])->where('produk_id', $request->id)->update($delivery);
                    } else {
                        $delivery_insert = [
                            'produk_id' => $request->id,
                            'delivery_id' => $delivery_id[$count],
                            'harga' => $harga[$count]
                        ];
                        Harga::create($delivery_insert);
                    }
                }
            }

            $cabang_id = $request->cabang_id;
            ProdukCabang::where('produk_id', $request->id)->delete();
            for ($count = 0; $count < count($cabang_id); $count++) {


                ProdukCabang::create([
                    'produk_id' => $request->id,
                    'cabang_id' => $cabang_id[$count]
                ]);
            }

            return redirect(route('products'))->with('success', 'Data berhasil diupdate');
        } else {
            return redirect(route('products'))->with('error', 'Masukan data outlet terlebih dahulu');
        }
    }


    public function addResep(Request $request)
    {
        $produk_id = $request->produk_id;
        $bahan_id = $request->bahan_id;
        $takaran = $request->takaran;

        for ($count = 0; $count < count($bahan_id); $count++) {
            $cek = Resep::where('produk_id', $produk_id)->where('bahan_id', $bahan_id[$count])->first();
            if ($cek) {
                continue;
            }
            $data  = [
                'produk_id' => $produk_id,
                'bahan_id' => $bahan_id[$count],
                'takaran' => $takaran[$count]
            ];
            Resep::create($data);
        }

        return true;
    }

    public function dropResep(Request $request)
    {
        Resep::find($request->id)->delete();

        return true;
    }

    public function deleteProduk($id)
    {
        Produk::where('id', $id)->update([
            'hapus' => 1,
            'status' => 'OFF'
        ]);

        return redirect(route('products'))->with('success', 'Data berhasil dihapus');
    }

    public function tambahKategori(Request $request)
    {
        Kategori::create([
            'kategori' => $request->kategori,
            'possition' => 0,
        ]);

        return redirect(route('products'))->with('success_kategori', 'Data berhasil ditambah');
    }

    public function editKategori(Request $request)
    {
        Kategori::where('id', $request->id)->update([
            'kategori' => $request->kategori
        ]);

        return redirect(route('products'))->with('success_kategori', 'Data berhasil diubah');
    }

    public function getHargaResep($produk_id)
    {
        $resep = Resep::select('resep.*', 'bahan.bahan')->selectRaw("dt_harga.ttl_harga, dt_harga.ttl_qty")->where('produk_id', $produk_id)
            ->leftJoin(
                DB::raw("(SELECT bahan_id, SUM(qty) as ttl_qty, SUM(harga) as ttl_harga FROM stok where transaksi = 1 AND jenis = 2 AND void = 0 AND qty > 0 AND harga > 0 GROUP BY bahan_id) dt_harga"),
                'resep.bahan_id',
                '=',
                'dt_harga.bahan_id'
            )
            ->leftJoin('bahan', 'resep.bahan_id', '=', 'bahan.id')
            ->where('bahan.aktif', 'Y')
            ->groupBy('resep.bahan_id')
            ->get();
        return view('produk.getHargaResep', [
            'resep' => $resep,
            'produk_id' => $produk_id,
            'bahan' => Bahan::orderBy('possition', 'ASC')->where('aktif', 'Y')->where('jenis', 1)->get(),

        ])->render();
    }
}
