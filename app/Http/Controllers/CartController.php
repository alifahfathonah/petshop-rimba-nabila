<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\barang as barang;
use App\User as user;
use App\BarangUser as Cart;
use  Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
ini_set('max_execution_time', 180);
class CartController extends Controller
{
  public function __construct()
  {
    $this->middleware('RevalidateBackHistory');
      $this->middleware('auth');

  }
  //  public function dumping()
  //  {

    //  $dumpBrg = barang::join('kategoris','kategoris.kd_kategori','=','barangs.kd_kategori')
    //  ->orderBy('kd_brg')
    //  ->paginate(3);

  //    return view('dump',['dumpBrg'=>$dumpBrg]);
    //  $brg = barang::find('PROTUN500001');
    //  dd($brg->user);
    //  $userq = user::where('id', 3)->first();
    //  $kd1 = ['WHIOCE250001','PROTUN500001'];

    //  $jml = 1;
     //$user->barangs()->detach($kd1,['jumlah'=>$jml]);
    //$user = user::find(3);
     //$asd = $user->barangs()->get();
     //foreach ($user->barangs as $show)
    //{
      //echo $show->kd_brg;
    //  echo $show->pivot->jumlah;
    //  echo $user->created_at;
  //   }


     public function addToCart(Request $request)
     {
            $CartAdd = $request->CartBarang;
            $userr = user::findOrFail(Auth::id());
            $prod = barang::findOrFail($CartAdd);
            $z = $request->all();
            $checkProc = $userr->barangs()->find($CartAdd);
           
            // dd($prod->stok);
            if ($prod->stok <= 0) {
              $request->session()->flash('Sold', 'Stok Habis');
                return redirect()->back();
            }
          if ($checkProc == True) {
            $request->session()->flash('danger', 'Barang Sudah ada di keranjang');
            return redirect()->back();
          }
            else
          {
            $userr->barangs()->attach($prod,['jumlah'=>1]);
            $request->session()->flash('success', 'Barang Telah Masuk ke Keranjang');
            return redirect()->back();
          }


  }
     public function cartShow(Request $request , $id)
     {


       $uid = user::findOrFail(Auth::id());
       $brg_total = $uid->barangs()->sum(DB::raw('jumlah * harga'));

       $rowttl = Cart::where('barang_user.id',Auth::id())->get(['kd_brg']);
       $row = count($rowttl);
       if ($row < 1) {
          $request->session()->flash('CartKosong', 'Tidak ada barang di keranjang ');
          return redirect('/');
       }
      return view('cart',['uid' => $uid,'brg_total'=>$brg_total]);

    }
    public function tesFun()
    {
      return view('dump');
    }

    public function plus(Request $request)

    {



      $action = Input::get('aksi', 'none');
      $usr = user::findOrFail(Auth::id());
      $barang = $request->kod_barang;
      $CartCek = Cart::find($usr)->where('kd_brg',$barang)->pluck('jumlah')->first();
      $StokCek = Barang::where('kd_brg',$barang)->first();
      // if ($CartCek == 1) {
      //   echo "1";
      // }else {
      //   echo "bkn";
      // }

      // if ($CartCek > $StokCek->stok) {
      //   echo $CartCek .'>'.$StokCek->stok;
      // } else {
      //   echo " normal";
      // }
        // dd($StokCek->stok);


        if($action=='up'){
          if ($CartCek >= $StokCek->stok) {
            $request->session()->flash('dangerplus', 'Stok Kurang Dari Jumlah Pembelian');
            return redirect()->back();
          } else {
            //increment
            $usr->barangs()->first()->pivot->where('barang_user.kd_brg',$barang)->increment('barang_user.jumlah');
            return Redirect::to(URL::previous());
          }
           
        }else if($action=='down'){
           //decrement
           if ($CartCek == 1) {
             $request->session()->flash('danger', 'Jumlah Barang Tidak Bisa Dikurangi Lagi, Silahkan Hapus Barang Dari Keranjang');
             return Redirect::to(URL::previous());
           }else {
             $usr->barangs()->first()->pivot->where('barang_user.kd_brg',$barang)->decrement('barang_user.jumlah');
             return Redirect::to(URL::previous());
           }




        }else {
          echo "tidak";
        }

    }
    public function remove(Request $request)
    {
        $ussr = user::findOrFail(Auth::id());
        $ussr->barangs()->detach($request->kd_brg);
        return redirect()->back();
    }
    public function CartProc(Request $request)
    {
      $CartAction = Input::get('CartAction', 'none');
      if ($CartAction == 'back') {
        return redirect('/');
      }elseif ($CartAction == 'Checkout') {
        $Cart = Cart::join('barangs','barangs.kd_brg','=','barang_user.kd_brg')
              ->join('users','users.id','=','barang_user.id')
              ->Where('barang_user.id', Auth::id())
              ->get(['barangs.harga','jumlah','users.id','users.kota','users.alamat','users.no_hp','users.name']);

       $auth = user::findOrFail(Auth::id());

       $kalkulasi = $auth->barangs()->sum(DB::raw('jumlah * harga'));

        $kota_usr =  strtoupper($Cart->pluck('kota')->first());
        $free = collect(['kota' => 'DEPOK','JAKARTA UTARA','JAKARTA BARAT','JAKARTA SELATAN','JAKARTA TIMUR','BOGOR','TANGERANG','TANGERANG SELATAN','BEKASI']);

      return redirect('/transaksi/pembayaran');

      }

    }


}
