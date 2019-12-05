<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/




Route::get('/','PetController@show');
  Route::get('/SearchProduk', 'PetController@Search');
  Route::get('/kontak', 'PetController@kontak');
  Route::get('/about', 'PetController@about');

Route::group(['middleware' => 'is.registered'], function () {
    // Route   Cart

     Route::post('/cart/add/{kd_brg}', 'CartController@addToCart')->name('cart.add');
     Route::get('/cart/list/{id}', 'CartController@cartShow')->name('cart.show');
     Route::patch('/cart/list/{id}', 'CartController@plus')->name('cart.incr');
     Route::post('/cart/list/{id}/{kd_brg}', 'CartController@remove')->name('cart.remove');
     Route::post('/cart/Proc', 'CartController@CartProc')->name('cart.proses');
      Route::get('/dump', 'CartController@tesFun');
     Route::post('/dump', 'CartController@plus');
    //Route::patch('/cart/plus/{id}/{kd_brg}',[
        //'uses' => 'CartController@plus'
  //  ])->name('cart.plus');
     //Route::patch('/cart/plus/{id}/{kd_brg}', 'CartController@plus')->name('cart.plus');
             //  ROUTE Payment
             Route::get('/transaksi/pembayaran', 'TransactionController@payment')->name('Payment.form');
             Route::put('/transaksi/pembayaran/proses', 'TransactionController@PaymentProses')->name('Payment.proses');
             Route::get('/History', 'TransactionController@RiwayatShow')->name('Show.Riwayat');
            
             Route::get('/SearchRiwayat', 'TransactionController@Search');

});

Route::group(['middleware'=>['is.owner' OR 'is.admin' OR 'is.registered' OR 'is.kurir']],function (){
  //Route Profile
    Route::get('/profile', 'ProfileController@UserProfile');
    Route::get('/profile/edit/{id}', 'ProfileController@ProfileForm');
    Route::put('/profile/eprof', 'ProfileController@ProfileChange');
    Route::get('/profile/editpass/{id}', 'ProfileController@PassForm');
    Route::post('/profile/epw', 'ProfileController@PassChange');

    //rincian
    Route::get('/Rincian/{kd_trans}', 'TransactionController@RiwayatRincian')->name('Rincian.Riwayat');
    Route::put('/Rincian/Upload', 'TransactionController@UpBukti')->name('Rincian.UploadBukti');

});
Route::group(['middleware'=>['is.owner' OR 'is.admin' OR 'is.kurir']],function (){
  //Route transaksi

  Route::get('/dt_transaksi', 'TransactionController@DataTransaksi')->name('Show.DataTransaksi');
  Route::get('/CariPesanan', 'TransactionController@AdminSearch')->name('Search.DataTransaksiAdmin');
  Route::put('/Transaksi/{kd_trans}', 'TransactionController@Konfirmasi')->name('Konfirmasi.Transaksi');
  });
Route::group(['middleware'=>['is.admin']],function (){

    //Route Kategori
    Route::get('/dt_kategori', 'KategoriController@show');
    Route::get('/create/kategori', 'KategoriController@create');
    Route::get('/SearchKategori', 'KategoriController@Search');
    Route::post('/dt_kategori/add', 'KategoriController@store');
    Route::get('/kategori/edit/{kd_kategori}', 'KategoriController@edit');
    Route::patch('/dt_kategori/prosesEdit', 'KategoriController@update');
    Route::delete('/kategori/{kd_kategori}', 'KategoriController@destroy');

    //Route Barang
    Route::get('/dt_brg', 'BarangController@show');
    Route::get('/create/barang', 'BarangController@createForm');
    Route::post('/dt_brg', 'BarangController@store');
    Route::get('/barang/{kd_brg}/edit', 'BarangController@edit');
    Route::put('/barang/update/{kd_brg}', 'BarangController@update');
    Route::get('/stok/{kd_brg}/edit', 'BarangController@editStok');
    Route::put('/dt_brg', 'BarangController@updateStok');
    Route::delete('/barang/{kd_brg}', 'BarangController@destroy');
    Route::get('/SearchBarang', 'BarangController@Search');



});
Route::group(['middleware' => 'is.owner'], function () {
  //Route User
  Route::get('/dt_user', 'UserController@show');
  // Route::get('/user/role/{id}', 'UserController@EditJabatan');
  // Route::post('/user/role/{id}', 'UserController@UpJabatan');
  Route::put('/user/role/{id}', 'UserController@UpJabatan');
  Route::delete('/user/{id}', 'UserController@destroy');
  Route::get('/SearchUser', 'UserController@Search');
  Route::delete('/transaksi/{kd_trans}', 'TransactionController@destroy');
  //Route Laporan
      //Route Laporan Transaksi
      Route::post('/ReportTrans/Download/Transaksi', 'TransactionController@PDFTrans');
    Route::get('/ReportTrans', 'TransactionController@report');
    Route::post('/ReportTrans/Search', 'TransactionController@reportQ');
    // Route Laporan Barang
    Route::post('/ReportBarang/Download/Barang', 'BarangController@PDFBar');
    Route::get('/ReportBarang', 'BarangController@repoBarang');
    Route::post('/ReportBarang/Search', 'BarangController@FilBarang');

});


Auth::routes();
Route::get('/dashboard', 'HomeController@index');
