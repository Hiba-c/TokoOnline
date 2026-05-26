<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RajaOngkirController extends Controller
{
    public function index()
    {
        // Mengambil data provinsi dari API Raja Ongkir
        $response = Http::withHeaders([
            //headers yang diperlukan untuk API Raja Ongkir
            "Accept" => "application/json",
            "key" => env("RAJAONGKIR_API_KEY"), //config('rajaongkir.api_key'),
        ])->get("https://rajaongkir.komerce.id/api/v1/destination/province");

        // Memeriksa apakah permintaan berhasil
        if ($response->successful()) {
            // Mengambil data provinsi dari respons JSON
            // Jika 'data' tidak ada, inisialisasi dengan array kosong
            $provinces = $response->json()["data"] ?? [];
        }

        // returning the view with provinces data
        return view("ongkir2", compact("provinces"));
    }

    public function getCities($provinceId)
    {
        // Mengambil data kota berdasarkan ID provinsi dari API Raja Ongkir
        $response = Http::withHeaders([
            //headers yang diperlukan untuk API Raja Ongkir
            "Accept" => "application/json",
            "key" => env("RAJAONGKIR_API_KEY"),
        ])->get(
            "https://rajaongkir.komerce.id/api/v1/destination/city/{$provinceId}",
        );

        if ($response->successful()) {
            // Mengambil data kota dari respons JSON
            // Jika 'data' tidak ada, inisialisasi dengan array kosong
            return response()->json($response->json()["data"] ?? []);
        }
    }

    /**
     * Mengambil data kecamatan berdasarkan ID kota
     *
     * @param int $cityId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDistricts($cityId)
    {
        // Mengambil data kecamatan berdasarkan ID kota dari API Raja Ongkir
        $response = Http::withHeaders([
            //headers yang diperlukan untuk API Raja Ongkir
            "Accept" => "application/json",
            "key" => env("RAJAONGKIR_API_KEY"),
        ])->get(
            "https://rajaongkir.komerce.id/api/v1/destination/district/{$cityId}",
        );

        if ($response->successful()) {
            // Mengambil data kecamatan dari respons JSON
            // Jika 'data' tidak ada, inisialisasi dengan array kosong
            return response()->json($response->json()["data"] ?? []);
        }
    }

    /**
     * Menghitung ongkos kirim berdasarkan data yang diberikan
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkOngkir(Request $request)
    {
        $response = Http::asForm()
            ->withHeaders([
                //headers yang diperlukan untuk API Raja Ongkir
                "Accept" => "application/json",
                "key" => env("RAJAONGKIR_API_KEY"),
            ])
            ->post(
                "https://rajaongkir.komerce.id/api/v1/calculate/domestic-cost",
                [
                    "origin" => 501, // ID kecamatan 3855 (ganti sesuai kebutuhan)
                    "destination" => $request->input("district_id"), // ID kecamatan tujuan
                    "weight" => $request->input("weight"), // Berat dalam gram
                    "courier" => $request->input("courier"), // Kode kurir (jne, tiki, pos)
                ],
            );

        if ($response->successful()) {
            // Mengambil data ongkos kirim dari respons JSON
            // Jika 'data' tidak ada, inisialisasi dengan array kosong
            return $response->json()["data"] ?? [];
        }
    }
    //atas baru, bawah modul
    public function getProvinces()
    {
        $response = Http::withHeaders([
            "key" => env("RAJAONGKIR_API_KEY"),
        ])->get(env("RAJAONGKIR_BASE_URL") . "/province");

        return response()->json($response->json());
    }
    public function get_Cities(Request $request)
    {
        $provinceId = $request->input("province_id");
        $response = Http::withHeaders([
            "key" => env("RAJAONGKIR_API_KEY"),
        ])->get(env("RAJAONGKIR_BASE_URL") . "/city", [
            "province" => $provinceId,
        ]);

        return response()->json($response->json());
    }

    public function getCost(Request $request)
    {
        $origin = $request->input("origin");
        $destination = $request->input("destination");
        $weight = $request->input("weight");
        $courier = $request->input("courier");

        $response = Http::withHeaders([
            "key" => env("RAJAONGKIR_API_KEY"),
        ])->post(env("RAJAONGKIR_BASE_URL") . "/cost", [
            "origin" => $origin,
            "destination" => $destination,
            "weight" => $weight,
            "courier" => $courier,
        ]);

        return response()->json($response->json());
    }
}
