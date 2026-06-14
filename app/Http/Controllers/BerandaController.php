<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;

class BerandaController extends Controller
{
    //membuat function berandaBackend
    public function berandaBackend()
    {
        //Ambil data produk dari database
        $dataProduk = Produk::select("nama_produk", "stok")->limit(10)->get();

        //Pecah data menjadi 2 array terpisah untuk dilempar ke grafik
        $nama_produk = $dataProduk->pluck("nama_produk");
        $stok_produk = $dataProduk->pluck("stok");

        return view(
            "backend.v_beranda.index",
            [
                "judul" => "Halaman Beranda",
            ],
            compact("nama_produk", "stok_produk"),
        );
    }

    public function index()
    {
        $produk = Produk::where("status", 1)
            ->orderBy("updated_at", "desc")
            ->paginate(6);
        return view("v_beranda.index", [
            "judul" => "Halaman Beranda",
            "produk" => $produk,
        ]);
    }
}
