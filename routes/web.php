<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RajaOngkirController;
use App\Http\Controllers\RajaOngkirControllerV2;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get("/", function () {
    //return view('welcome');
    return redirect()->route("backend.login");
});

Route::get("/", function () {
    //return view('welcome');
    return redirect()->route("beranda");
});
Route::get("/backend/beranda", [BerandaController::class, "berandaBackend"])
    ->name("backend.beranda")
    ->middleware("auth");
Route::get("backend/login", [LoginController::class, "loginBackend"])->name(
    "backend.login",
);
Route::post("backend/login", [
    LoginController::class,
    "authenticateBackend",
])->name("backend.login");
Route::post("backend/logout", [LoginController::class, "logoutBackend"])->name(
    "backend.logout",
);

// Route::resource('backend/user', UserController::class)->middleware('auth');
Route::resource("backend/user", UserController::class, [
    "as" => "backend",
])->middleware("auth");

// Route untuk Customer
Route::resource("backend/customer", CustomerController::class, [
    "as" => "backend",
])->middleware("auth");

// Route untuk laporan user
Route::get("backend/laporan/formuser", [UserController::class, "formUser"])
    ->name("backend.laporan.formuser")
    ->middleware("auth");
Route::post("backend/laporan/cetakuser", [UserController::class, "cetakUser"])
    ->name("backend.laporan.cetakuser")
    ->middleware("auth");

// Route untuk Kategori
Route::resource("backend/kategori", KategoriController::class, [
    "as" => "backend",
])->middleware("auth");

// Route untuk Produk
Route::resource("backend/produk", ProdukController::class, [
    "as" => "backend",
])->middleware("auth");

// Route untuk laporan produk
Route::get("backend/laporan/formproduk", [
    ProdukController::class,
    "formProduk",
])
    ->name("backend.laporan.formproduk")
    ->middleware("auth");
Route::post("backend/laporan/cetakproduk", [
    ProdukController::class,
    "cetakProduk",
])
    ->name("backend.laporan.cetakproduk")
    ->middleware("auth");

// Route untuk menambahkan foto
Route::post("foto-produk/store", [ProdukController::class, "storeFoto"])
    ->name("backend.foto_produk.store")
    ->middleware("auth");

// Route untuk menghapus foto
Route::delete("foto-produk/{id}", [ProdukController::class, "destroyFoto"])
    ->name("backend.foto_produk.destroy")
    ->middleware("auth");

// Frontend
Route::get("/beranda", [BerandaController::class, "index"])->name("beranda");

//detail produk
Route::get("/produk/detail/{id}", [ProdukController::class, "detail"])->name(
    "produk.detail",
);

//produkKategori
Route::get("/produk/kategori/{id}", [
    ProdukController::class,
    "produkKategori",
])->name("produk.kategori");

//produkAll
Route::get("/produk/all", [ProdukController::class, "produkAll"])->name(
    "produk.all",
);

//API Google
Route::get("/auth/redirect", [CustomerController::class, "redirect"])->name(
    "auth.redirect",
);
Route::get("/auth/google/callback", [
    CustomerController::class,
    "callback",
])->name("auth.callback");

// Logout
Route::post("/logout", [CustomerController::class, "logout"])->name(
    "customer.logout",
);

// Route untuk menampilkan halaman akun customer
// Route::get('/customer/akun/{id}', [CustomerController::class, 'akun'])->name('customer.akun')->middleware('is.customer');
// Route::put('/customer/akun/{id}/update', [CustomerController::class, 'updateAkun'])->name('customer.akun.update')->middleware('is.customer');

// Group route untuk customer
Route::middleware("is.customer")->group(function () {
    // Route untuk menampilkan halaman akun customer
    Route::get("/customer/akun/{id}", [
        CustomerController::class,
        "akun",
    ])->name("customer.akun");

    // Route untuk mengupdate data akun customer
    Route::put("/customer/updateakun/{id}", [
        CustomerController::class,
        "updateAkun",
    ])->name("customer.updateakun");

    // Route untuk menambahkan produk ke keranjang
    Route::post("add-to-cart/{id}", [
        OrderController::class,
        "addToCart",
    ])->name("order.addToCart");
    Route::get("cart", [OrderController::class, "viewCart"])->name(
        "order.cart",
    );

    Route::post("cart/update/{id}", [
        OrderController::class,
        "updateCart",
    ])->name("order.updateCart");
    Route::post("remove/{id}", [
        OrderController::class,
        "removeFromCart",
    ])->name("order.remove");

    Route::post("select-shipping", [
        OrderController::class,
        "selectShipping",
    ])->name("order.select-shipping");
    Route::post("update-ongkir", [
        OrderController::class,
        "updateOngkir",
    ])->name("order.update-ongkir");
    Route::get("select-payment", [
        OrderController::class,
        "selectPayment",
    ])->name("order.selectpayment");

    Route::post("order/complete", [OrderController::class, "complete"])->name(
        "order.complete",
    );
    Route::get("history", [OrderController::class, "orderHistory"])->name(
        "order.history",
    );
});

// Route untuk mendapatkan daftar ongkir
Route::get("/list-ongkir", function () {
    $response = Http::withHeaders([
        "key" => "33S9fgW844c6677b076eca94evmCaqRa",
    ])->get("https://rajaongkir.komerce.id/api/v1/destination/province"); //ganti 'province' atau 'city'
    dd($response->json());
});

Route::get("/cek-ongkir", function () {
    return view("ongkir");
});

Route::get("/provinces", [RajaOngkirController::class, "getProvinces"]);
Route::get("/cities", [RajaOngkirController::class, "get_Cities"]);
Route::post("/cost", [RajaOngkirController::class, "getCost"]);

Route::get("/cek", [RajaOngkirController::class, "index"]);
//route to get cities based on province ID App\Http\Controllers\
Route::get("/cities/{provinceId}", [RajaOngkirController::class, "getCities"]);
//route to get districts based on city ID
Route::get("/districts/{cityId}", [
    RajaOngkirController::class,
    "getDistricts",
]);
//route to post shipping cost
Route::post("/check-ongkir", [RajaOngkirController::class, "checkOngkir"]);

// cek_raja_ongkir_v2
Route::get("/cek-ongkir", function () {
    return view("cek-ongkir");
});
Route::get("/ongkir/get-destination", [
    RajaOngkirControllerV2::class,
    "getDestination",
]);
Route::post("/ongkir/calculate", [
    RajaOngkirControllerV2::class,
    "calculateOngkir",
]);

//Manajemen Pemesanan
Route::get("/pesanan/proses", [OrderController::class, "statusProses"])->name(
    "pesanan.proses",
);
Route::get("/pesanan/detail/{id}", [
    OrderController::class,
    "statusDetail",
])->name("pesanan.detail");
Route::put("/pesanan/update/{id}", [
    OrderController::class,
    "statusUpdate",
])->name("pesanan.update");
Route::get("/pesanan/invoice/{id}", [
    OrderController::class,
    "invoiceBackend",
])->name("pesanan.invoice");

// Route untuk laporan pesanan
Route::get("backend/laporan/formpesanan", [
    OrderController::class,
    "formPesanan",
])
    ->name("backend.laporan.formpesanan")
    ->middleware("auth");
Route::post("backend/laporan/cetakpesanan", [
    OrderController::class,
    "cetakPesanan",
])
    ->name("backend.laporan.cetakpesanan")
    ->middleware("auth");
