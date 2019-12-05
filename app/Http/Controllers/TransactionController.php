<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\barang as barang;
use App\User as user;
use App\tb_detail as Detail;
use App\Transaction as Transaction;
use App\BarangUser as Cart;
use  Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Input;

class TransactionController extends Controller
{
  public function __construct()
  {
    $this->middleware('RevalidateBackHistory');
      $this->middleware('auth');
  }
  public function Payment(Request $request)
  {
    if (Auth::user()->kota == null  OR Auth::user()->alamat == null ) {
        $request->session()->flash('DangerKosong', 'Kota atau Alamat anda masih belum diisi, silahkan ubah profil anda.');
        return redirect()->back();
    }else {
      // code...
      $pembeli = user::findorfail(Auth::id());
      $cekStok = Cart::find(Auth::id());
      $cekStok1 = Cart::where('id', Auth::id());
      $brgStok = Barang::find($cekStok->kd_brg);
      $jBeli = $cekStok1->pluck('jumlah');
      $jStok = $brgStok->pluck('stok');
      // $tray = Cart::detach(13);
    // $pembeli->barangs()->where('barang_user.jumlah','>', 'barangs.stok')->get();
//       $detachtry = Cart::whereRaw('jumlah ', '>=', $jStok)->get();
//  dd( $detachtry);

      if ($jBeli>=$jStok) {
        $request->session()->flash('StokKurang', 'Sisa Stok Kurang Dari Jumlah !!!');
        return redirect('/cart/list/'.Auth::id());
      } else {
             $Cart = Cart::join('barangs','barangs.kd_brg','=','barang_user.kd_brg')
                ->join('users','users.id','=','barang_user.id')
                ->Where('barang_user.id', Auth::id())
                ->get(['barangs.harga','jumlah','users.id','users.kota','users.alamat','users.no_hp','users.name']);

        $auth = user::findOrFail(Auth::id());

        $kalkulasi = $auth->barangs()->sum(DB::raw('jumlah * harga'));

          $kota_usr =  strtoupper($Cart->pluck('kota')->first());
          $free = collect(['kota' => 'DEPOK','JAKARTA UTARA','JAKARTA BARAT','JAKARTA SELATAN','JAKARTA TIMUR','JAKARTA PUSAT','JAKARTA','BOGOR','TANGERANG','TANGERANG SELATAN','BEKASI']);

        return view('payment',['Cart'=>$Cart,'kota_usr'=>$kota_usr,'free'=>$free,'kalkulasi'=>$kalkulasi]);
        }
    }
  }

  public function PaymentProses(Request $request)
  {

    if ($request->PaymentAction == 'Cancel') {
      return redirect('/');
    }

    if ($request->PaymentAction == 'Beli' AND $request->PayMethod == null) {
        $request->session()->flash('MetodePay', 'Metode Pembayaran Belum Dipilih !');
        return redirect()->back();
      } elseif ($request->PaymentAction == 'Beli' AND $request->PayMethod == 'COD') {
        $pembelii = user::findOrFail(Auth::id());
        $var1= $pembelii->barangs()->whereColumn('barang_user.jumlah', '>=','barangs.stok');
        $var2 = $var1->pluck('barang_user.kd_brg')->toArray();
          // dd($var2);
                if ($var1->count()>=1) {
                  // detach hanya jumlah beli lebih besar dari stok barang
                  $var1->detach($var2);
                  $request->session()->flash('StokKurang', 'Sisa Stok Kurang Dari Jumlah !!!');
                  return redirect('/cart/list/'.Auth::id());
                } else {
              
               
   
      $find= Cart::join('barangs','barangs.kd_brg','=','barang_user.kd_brg')
            ->join('users','users.id','=','barang_user.id')
            ->where('barang_user.id',Auth::id())
            ->get()
            ->all();

      $k_trns = 'TCD'. Auth::id() . Carbon::now()->day . Carbon::now()->month . substr(Carbon::now()->year,2,2) . Carbon::now()->micro;
        $PayAuth = user::findOrFail(Auth::id());
       $Grand = $PayAuth->barangs()->sum(DB::raw('jumlah * harga'));
       $ongkir = intval($request->ongkir);
       //
       //
       $dt_trans = Transaction::create([
         'kd_trans' => $k_trns,
         'id'=> Auth::id(),
         'ongkir' => $ongkir,
         'grand_biaya' =>$Grand,
         'total_beli' => $Grand,
         'status' => 'Belum Upload Bukti Pembayaran',
         'bukti'=> 'ini gambar'
       ]);
       $detil = [];
       foreach ($find as $pay ) {
         // echo $pay->harga * $pay->jumlah;
         $detil = Detail::create([
           'kd_trans' =>$k_trns,
           'total' => $pay->harga * $pay->jumlah,
            'kd_brg' => $pay->kd_brg,
            'jml_brg' => $pay->jumlah,
            'hrg_brg' => $pay->harga,
         ]);
       }
       foreach ($find as $key) {
         $p = barang::find($key->kd_brg);
         $w = $PayAuth->barangs->find($key->kd_brg);
         $p->update([
           'stok'=> $p->stok - $w->pivot->jumlah
         ]);
       }
     
      $PayAuth->barangs()->detach();
      $Pengguna = user::join('roles','roles.kd_level','=','users.kd_level');
      $hak = $Pengguna->findOrFail(Auth::id());
      if (strtoupper($hak->level) == strtoupper('pengguna')) {
        return redirect('/History');
      }
      return redirect('/dt_transaksi');

     }
    }elseif ($request->PaymentAction == 'Beli' AND $request->PayMethod == 'Transfer') {
      $pembelii1 = user::findOrFail(Auth::id());
        $var11= $pembelii1->barangs()->whereColumn('barang_user.jumlah', '>','barangs.stok');
        $var21 = $var11->pluck('barang_user.kd_brg')->toArray();
          // dd($var2);
                if ($var11->count()>=1) {
                  // detach hanya jumlah beli lebih besar dari stok barang
                  $var11->detach($var21);
                  $request->session()->flash('StokKurang', 'Sisa Stok Kurang Dari Jumlah Pembelian !!!');
                  return redirect('/cart/list/'.Auth::id());
                } else {
      $find= Cart::join('barangs','barangs.kd_brg','=','barang_user.kd_brg')
            ->join('users','users.id','=','barang_user.id')
            ->where('barang_user.id',Auth::id())
            ->get()
            ->all();
      $k_trns = 'TTB'. Auth::id() . Carbon::now()->day . Carbon::now()->month . substr(Carbon::now()->year,2,2) . Carbon::now()->micro;
      $PayAuth = user::findOrFail(Auth::id());
     $Grand = $PayAuth->barangs()->sum(DB::raw('jumlah * harga'));
     $ongkir = intval($request->ongkir);
     //

     $dt_trans = Transaction::create([
       'kd_trans' => $k_trns,
       'id'=> Auth::id(),
       'ongkir' => $ongkir,
       'grand_biaya' =>$Grand + $ongkir,
       'total_beli' => $Grand ,
       'status' => 'Belum Upload Bukti Pembayaran',
       'bukti'=> 'ini gambar'
     ]);
     $detil = [];
     foreach ($find as $pay ) {
       // echo $pay->harga * $pay->jumlah;
       $detil = Detail::create([
         'kd_trans' =>$k_trns ,
         'total' => $pay->harga * $pay->jumlah,
          'kd_brg' => $pay->kd_brg,
          'jml_brg' => $pay->jumlah,
          'hrg_brg' => $pay->harga,
       ]);

     }
      foreach ($find as $key) {
        $p = barang::find($key->kd_brg);
        $w = $PayAuth->barangs->find($key->kd_brg);
        $p->update([
          'stok'=> $p->stok - $w->pivot->jumlah
        ]);
      }

     $PayAuth->barangs()->detach();

     $Pengguna = user::join('roles','roles.kd_level','=','users.kd_level');
     $hak = $Pengguna->findOrFail(Auth::id());
     if (strtoupper($hak->level) == strtoupper('pengguna')) {
       return redirect('/History');
     }
     return redirect('/dt_transaksi');
  }
  }

  }
  public function RiwayatShow()
  {
    // code...

    $Riwayat = Transaction::join('users','users.id','=','transactions.id')
                ->where('transactions.id', Auth::id())
                ->paginate(10);

    return view('History',['Riwayat'=>$Riwayat]);
  }
  public function Search(Request $request)
  {
    $SearchHistory = $request->HisSearch;
    $ChkHis = Transaction::where('transactions.kd_trans', 'like', '%' . $SearchHistory . '%')->get(['kd_trans']);
    $result = count($ChkHis);
    // dd($result);
    //
    if ($result == 0 ) {
      $request->session()->flash('search', 'Riwayat Pemesanan Tidak Ada !!!');
      return redirect('/History');
    }else {
      // code...
      $SearchAuth = user::findOrFail(Auth::id());
      $dt_his = $SearchAuth->Transaksi()->where('transactions.kd_trans', 'like', '%' . $SearchHistory . '%')
                                  ->orWhere('transactions.created_at', 'like', '%' . $SearchHistory . '%')
                                  ->paginate(10);
      // $dt_his =  Transaction::join('users','users.id','=','transactions.id')
      //             // ->where('transactions.id', Auth::id())
      //             ->where('transactions.kd_trans', 'like', '%' . $SearchHistory . '%')
      //             // ->where('transactions.id', Auth::id())
      //              ->paginate(10);

      return view('Search.s-History',['SearchHistory'=>$SearchHistory,'dt_his'=>$dt_his]);
    }
  }
  public function RiwayatRincian($kd_trans)
  {
   
   
    if (Auth::user()->kd_level == '4') {
      $RincianAuth1 = Transaction::findOrFail($kd_trans);
      $dt_rincian1 = $RincianAuth1->tb_detail()->join('barangs','barangs.kd_brg', '=', 'tb_details.kd_brg')->get()->all();
      $TransAuth1 = user::findOrFail(Auth::id());
      $trans = $TransAuth1->transaksi()->findOrFail($kd_trans);
     
      return view('Rincian',['dt_rincian1'=>$dt_rincian1,'RincianAuth1'=>$RincianAuth1,'trans'=>$trans]);
    }
    $RincianAuth = Transaction::findOrFail($kd_trans);
      $dt_rincian = $RincianAuth->tb_detail()->join('barangs','barangs.kd_brg', '=', 'tb_details.kd_brg')->get()->all();
    $trans = Transaction::findOrFail($kd_trans);


    return view('Rincian',['dt_rincian'=>$dt_rincian,'RincianAuth'=>$RincianAuth,'trans'=>$trans]);

  }
  public function UpBukti(Request $request)
  {

    if ($request->hasFile('bukti')) {

        // code...

      $messages =  [
          'gambar.required' => 'Gambar Barang Masih Kosong',
          'bukti.image' => 'Hanya dapat mengunggah file Image (jpeg, png, bmp, gif, atau jpg)',
          'bukti.mimes' => 'Hanya dapat mengunggah file Image (jpeg, png, bmp, gif, atau jpg)'
      ];
      $this->validate($request,[
        'bukti' => 'nullable|required|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);
      $UpBukti = $request->file('bukti')->store('Bukti','public');
       $upload = Transaction::where('kd_trans', $request->kd_trans)->first();
       // dd($upload);
      $upload->fill([
        'status'=> 'Pemesanan Sedang Diproses',
        'bukti'=> $UpBukti
        ])->save();
        $request->session()->flash('upload', 'Bukti Transfer Berhasil di Unggah');
        return redirect('/History');

    }
    else {
      //jika file gambar tidak ada
      $request->session()->flash('NoFile', 'Bukti Transfer Belum dipilih');
      return redirect('/History');
    }

  }

  public function DataTransaksi()
  {
    $dt_transaksi = Transaction::join('users','users.id','=','transactions.id')
                    ->orderBy('transactions.kd_trans','DESC')
                    ->paginate(7);
    $restrict = user::join('roles','roles.kd_level','=','users.kd_level');
    $trans_kurir = Transaction::join('users','users.id','=','transactions.id')
                    ->where('transactions.kd_trans', 'like','TCD%')
                    ->OrderBy('transactions.kd_trans','desc')
                    ->paginate(7);
    $batas = $restrict->findOrFail(Auth::id());
    // dd($dta_transaksi->get());
    return view('DataTransaksi',['dt_transaksi'=>$dt_transaksi, 'restrict'=>$restrict,'batas'=>$batas,'trans_kurir'=>$trans_kurir]);
  }
  public function AdminSearch(Request $request)
  {
    $AdmHisSearch = $request->AdmHisSearch;
    $ChkHistory = Transaction::where('transactions.kd_trans', 'like', '%' . $AdmHisSearch . '%')
                              ->orWhere('transactions.status', 'like', '%' . $AdmHisSearch . '%')
                                ->get(['kd_trans']);
    $hsl = count($ChkHistory);
    // dd($result);
    //
    if ($hsl == 0 ) {
      $request->session()->flash('search', 'Riwayat Pemesanan Tidak Ada !!!');
      return redirect('/dt_transaksi');
    }else {
      // code...

      $dt_history = Transaction::where('transactions.kd_trans', 'like', '%' . $AdmHisSearch . '%')
                                  ->orWhere('transactions.created_at', 'like', '%' . $AdmHisSearch . '%')
                                  ->orWhere('transactions.status', 'like', '%' . $AdmHisSearch . '%')
                                  ->orderBy('created_at','DESC')
                                  ->paginate(10);
      return view('Search.s-HistoryAdmin',['AdmHisSearch'=>$AdmHisSearch,'dt_history'=>$dt_history]);
  }
}

  public function Konfirmasi(Request $request)
  {
    $FindTrans = $request->kd_trans;
    $konfirmasi = $request->Konfirmasi;
    $Hasil = Transaction::find($FindTrans);

    $Hasil->fill([
         'status' => $konfirmasi
       ])->save();

    $request->session()->flash('Berhasil', 'Status Transaksi '.$FindTrans.' Berhasil Diubah');
    return redirect('/dt_transaksi');

  }
  public function destroy($kd_trans)
  {
    $delTrans = Transaction::destroy($kd_trans);
    return redirect('/dt_transaksi');
  }
  public function report()
  {
    $RepTrans = Transaction::WHERE('status','Barang Telah Diterima Pembeli')->get();
    return view('LaporanTransaksi',['RepTrans'=>$RepTrans]);
  }
  public function reportQ(Request $request)
  {

    if ($request->AksiFilter =='Filter') {
      $CAW = $request->tgl_awal;
      $CAK = $request->tgl_akhir;
      if ($CAW > $CAK) {
        $request->session()->flash('danger', 'Tanggal Awal Lebih Besar Dari Tanggal Akhir');
        return redirect('/ReportTrans');
      } else {
        $tgawal = $request->tgl_awal;
        $tgakhir = $request->tgl_akhir;
        $joinTrans = Transaction::join('users','users.id','=','transactions.id');
        $FilTrans = Transaction::whereBetween('transactions.created_at',[$tgawal,$tgakhir])
                    ->WHERE('status','Barang Telah Diterima Pembeli')
                    ->get();
          return view('Search.s-LaporanTransaksi',['FilTrans'=>$FilTrans,'tgawal'=>$tgawal,'tgakhir'=>$tgakhir]);
      }
    }
  }
    public function PDFTrans(Request $request)
    {
      $filawal = $request->filawal;
      $filakhir = $request->filakhir;
      $getTrans = Transaction::whereBetween('transactions.created_at',[$filawal,$filakhir])->get();
      $pdfTrans = PDF::loadView('Laporan.l-transaksi',['getTrans'=>$getTrans,'filawal'=>$filawal,'filakhir'=>$filakhir])->setPaper('a4','potrait');
      $filename = 'Transaksi'.$filawal.'-'.$filakhir;
      return $pdfTrans->stream($filename.'.pdf', array("Attachment" => false));
 
      // dd($request->all());
    }



}
