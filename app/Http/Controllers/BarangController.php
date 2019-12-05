<?php

namespace App\Http\Controllers;
use  Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Validator;
use App\barang as barang;
use App\kategori as kategori;

class BarangController extends Controller
{
  public function __construct()
  {
    $this->middleware('RevalidateBackHistory');
      $this->middleware('auth');
  }

  public function show()
  {

    $items = barang::join('kategoris','kategoris.kd_kategori','=','barangs.kd_kategori')
    ->orderBy('kd_brg')
    ->paginate(3);

    return view('barang',['items'=>$items]);
  }

  public function createForm()
  {

  //  $lastIDbarang = barang::orderBy('kd_brg', 'desc')->first();

    //if ( ! $lastIDbarang )

      //  $number = 0;
    //else
      //  $number = substr($lastIDbarang->kd_brg, 2);

  //  $k_brg = 'B' . sprintf('%03d', intval($number) + 1);
    $kategori = kategori::all();
      return view('create/c-brg',['kategori'=>$kategori,]);
      //'k_brg'=>$k_brg
  }



  public function store(Request $request)
  {
    $AksiBarangTambah = $request->AksiBarangTambah;
    if ($AksiBarangTambah == 'Cancel') {
      return redirect('/dt_brg');
    }elseif ($AksiBarangTambah == 'Simpan') {
      // code...

    $HargaAwal = $request->harga;
    $HargaAkhir = intval($HargaAwal);
    $stokAwal = $request->stok;
    $stokAkhir = intval($stokAwal);

    $nm = $request->nm_brg;
    $brt = $request->berat;
    $bhn = $request->bahan;
    $kat = $request->kd_kategori;

    $subNm = strtoupper(substr($nm,0,3));
    $subBrt = (string) filter_var($brt, FILTER_SANITIZE_NUMBER_INT);
    $subBhn = strtoupper(substr($bhn,0,3));
    $subKat = substr($kat,1,4);
    $Usia = substr(strtoupper($request->usia),0,2);

    $kd_brgBaru = $subNm.$Usia . $subBhn . $subBrt . $subKat;
    $cek = barang::where('kd_brg', $kd_brgBaru)->get(['kd_brg']);
    $cek2 = count($cek);
    if ($cek2 == 1 ) {
      $request->session()->flash('danger', 'Barang Sudah Ada, Silahkan Cek Lagi');
      return redirect('/dt_brg');
    }else{

        $messages =  [
            'nm_brg.string' => 'Nama barang String',
            'berat.regex' => 'Berat barang hanya boleh huruf, angka dan koma. contoh : 1.5kg',
            'nm_brg.required' => 'Nama barang masih kosong',
            'harga.required'  => 'Harga Barang Masih kosong',
            'berat.required'  => 'Berat Barang Masih kosong',
            'usia.required'  => 'usia Barang Masih kosong',
            'gambar.required' => 'Gambar Barang Masih Kosong',
            'harga.numeric' => 'Input hanya angka saja',
            'gambar.image' => 'Hanya dapat mengunggah file Image (jpeg, png, bmp, gif, atau jpg)',
        ];
        $this->validate($request,[
          'nm_brg' => 'required|string|max:255',
          'harga' => 'required|numeric',
          'berat' => 'required|regex:/^[\w .,!?()]+$/|max:6',
          'bahan' =>'required|string|max:255',
          'usia' => 'required|string|max:255',
          'gambar' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
        ],$messages);
          $image = $request->file('gambar')->store('barang','public');

        $simpan =  barang::create([
         'kd_brg' => $kd_brgBaru,
         'kd_kategori' => $request->kd_kategori,
         'nm_brg' => $request->nm_brg,
         'harga' => $HargaAkhir,
         'berat' => $request->berat,
         'bahan' =>$request->bahan,
         'usia' => $request->usia,
         'stok'=>$stokAkhir,
         'gambar' => $image,
        ]);
        $request->session()->flash('hore', 'Barang Berhasil Ditambahkan');
        return redirect('/dt_brg');
      }
    }

  }

  public function edit($kd_brg)
    {

      $kategori = kategori::all();
      $ubah = barang::find($kd_brg);

      return view('Edit/e-brg',['kategori'=>$kategori,'ubah'=>$ubah]);
    }

  public function update(Request $request)
  {
    $nm2 = $request->nm_brg;
    $brt2 = $request->berat;
    $bhn2 = $request->bahan;
    $kat2 = $request->kd_kategori;

    $subNm2 = strtoupper(substr($nm2,0,3));
    $subBrt2 = (string) filter_var($brt2, FILTER_SANITIZE_NUMBER_INT);
    $subBhn2 = strtoupper(substr($bhn2,0,3));
    $subKat2 = substr($kat2,1,4);
    $Usia2 = substr(strtoupper($request->usia),0,2);
    $charga = intval($request->harga);
    $kd_brgBaru2 = $subNm2.$Usia2. $subBhn2 . $subBrt2 . $subKat2;

      $up1 = barang::where('kd_brg', $request->kd_brg)->first();

      $dt_kd =barang::where('kd_brg', $kd_brgBaru2)->get()->pluck('kd_brg')->first();
      $dt_stok =barang::where('kd_brg', $kd_brgBaru2)->get()->pluck('stok')->first();
      $dt_hrg =barang::where('kd_brg', $kd_brgBaru2)->get()->pluck('harga')->first();
      $dt_nm =barang::where('kd_brg', $kd_brgBaru2)->get()->pluck('nm_brg')->first();
      if ($dt_stok == $request->stok AND $dt_hrg == $request->harga AND $dt_nm == $request->nm_brg) {
        $request->session()->flash('danger', 'Barang Sudah Ada, Silahkan Cek Lagi');
        return redirect('/dt_brg');
      }

       if ($request->hasFile('gambar')) {
        //  echo "ada gambar";
         //         pny gambar
               $HargaAwal = $request->harga;
               $HargaAkhir = intval($HargaAwal);
               $stokAwal = $request->stok;
               $stokAkhir = intval($stokAwal);
               $messages =  [
                   'nm_brg.string' => 'Nama barang String',
                   'berat.alpha_num' => 'Berat barang Alphanumeric',
                   'nm_brg.required' => 'Nama barang masih kosong',
                   'harga.required'  => 'Harga Barang Masih kosong',
                   'berat.required'  => 'Berat Barang Masih kosong',
                   'usia.required'  => 'Merk Barang Masih kosong',
                   'gambar.required' => 'Gambar Barang Masih Kosong',
                   'harga.numeric' => 'Input hanya angka saja',
                   'gambar.image' => 'Hanya dapat mengunggah file Image (jpeg, png, bmp, gif, atau jpg)'
               ];
               $this->validate($request,[
                 'nm_brg' => 'required|string|max:255',
                 'harga' => 'required|numeric',
                 'berat' => 'required|alpha_num|max:255',
                 'bahan' =>'required|string|max:255',
                 'usia' => 'required|string|max:255',
                 'gambar' => 'nullable|required|image|mimes:jpg,jpeg,png,gif|max:2048',
                     // validate also other fields here

                 ]);
                 $image1 = $request->file('gambar')->store('barang','public');


          $up1 ->fill([
               'kd_brg' => $kd_brgBaru2,
               'kd_kategori' => $request->kd_kategori,
               'nm_brg' => $request->nm_brg,
               'harga' => $HargaAkhir,
               'berat' => $request->berat,
               'bahan' =>$request->bahan,
               'usia' => $request->usia,
               'stok'=>$request->stok,
               'gambar' => $image1,
             ])->save();
             $request->session()->flash('SUCCESS', 'Kode Barang'.$kd_brgBaru2.'Berhasil Diubah');
             return redirect('/dt_brg');
       }else {
       // KALO GA ADA GAMBAR
             $up = barang::where('kd_brg', $request->kd_brg)->first();
             $nm1 = $request->nm_brg;
             $brt1 = $request->berat;
             $bhn1 = $request->bahan;
             $kat1 = $request->kd_kategori;
         
             $subNm1 = strtoupper(substr($nm1,0,3));
             $subBrt1 = (string) filter_var($brt1, FILTER_SANITIZE_NUMBER_INT);
             $subBhn1 = strtoupper(substr($bhn1,0,3));
             $subKat1 = substr($kat1,1,4);
             $Usia1 = substr(strtoupper($request->usia),0,2);

             $kd_brgBaru1 = $subNm1 .$Usia1 . $subBhn1 . $subBrt1 . $subKat1;
             $dt_kde =barang::where('kd_brg', $kd_brgBaru1)->get()->pluck('kd_brg')->first();
             $dt_stoks =barang::where('kd_brg', $kd_brgBaru1)->get()->pluck('stok')->first();
             $dt_hrga =barang::where('kd_brg', $kd_brgBaru1)->get()->pluck('harga')->first();
             $dt_nma =barang::where('kd_brg', $kd_brgBaru1)->get()->pluck('nm_brg')->first();
            
          // DD($up->nm_brg, $nm1);
           
             if( $dt_stoks == $request->stok AND $dt_hrga == $request->harga AND $dt_nma == $nm1) {
              $request->session()->flash('danger', 'Barang Sudah Ada, Silahkan Cek Lagi1');
              return redirect('/dt_brg');
            } 
            else {
                

             $HargaAwal = $request->harga;
               $HargaAkhir = intval($HargaAwal);
             $stokAwal = $request->stok;
             $stokAkhir = intval($stokAwal);
             $messages =  [
                 'nm_brg.string' => 'Nama barang String',
                 'berat.alpha_num' => 'Berat barang Alphanumeric',
                 'nm_brg.required' => 'Nama barang masih kosong',
                 'harga.required'  => 'Harga Barang Masih kosong',
                 'berat.required'  => 'Berat Barang Masih kosong',
                 'usia.required'  => 'usia Barang Masih kosong',
                 'gambar.required' => 'Gambar Barang Masih Kosong',
                 'harga.numeric' => 'Input hanya angka saja',

             ];
             $this->validate($request,[
               'nm_brg' => 'required|string|max:255',
               'harga' => 'required|numeric',
               'berat' => 'required|alpha_num|max:255',
               'bahan' =>'required|string|max:255',
               'usia' => 'required|string|max:255',

                   // validate also other fields here

               ]);

           $up->fill([
             'kd_brg' => $kd_brgBaru1,
             'kd_kategori' => $request->kd_kategori,
             'nm_brg' => $request->nm_brg,
             'harga' => $HargaAkhir,
             'harga' => $HargaAkhir,
             'berat' => $request->berat,
             'bahan' =>$request->bahan,
             'usia' => $request->usia,
             'stok'=>$request->stok,

           ])->save();
           $request->session()->flash('SUCCESS', 'Kode Barang'.$kd_brgBaru1.'Berhasil Diubah');
               return redirect('/dt_brg');
           }
         }

}

  public function destroy(Request $request,$kd_brg)
  {
   
    $qwe = barang::where('kd_brg',$kd_brg);
    if ($qwe->exists()) {
      $del = barang::destroy($kd_brg);
      return redirect('/dt_brg');
    } else {
      $request->session()->flash('danger', 'Barang Tidak ditemukan');
      return redirect('/dt_brg');
    }
   
  }

  public function editStok($kd_brg)
    {
      $ubahStok = barang::find($kd_brg);
      return view('Edit/e-stok',['ubahStok'=>$ubahStok]);
    }
    public function updateStok(Request $request)
      {
        $AksiStok = $request->AksiStok;
        if ($AksiStok=='Cancel') {
          return redirect('/dt_brg');
        }
          $ubahStoko = barang::find($request->kd_brg);
          $stk = $ubahStoko->stok;
          $stokInt = intval($stk);
          $stokTbh = $request->stok;
          $stokIntBr = intval($stokTbh);
          $stoko = $stokInt + $stokIntBr;
        $messages =  [
            'stok.numeric' => 'Input Stok Hanya Angka !!!',
            'stok.required' => 'Kolom Stok Masih Kosong',
        ];
        $rules =[
          'stok' => 'required|numeric',
          ];
        $this->validate($request,$rules,$messages);
      $ubahStoko->fill([
        'stok'=>$stoko,
      ])->save();

      $request->session()->flash('SUCCESS', 'Stok Kode Barang '.$request->kd_brg.' Berhasil Ditambah');
        return redirect('/dt_brg');
      }
      public function repoBarang()
      {
        $RepBarang = Barang::all();
        return view('LaporanBarang',['RepBarang'=>$RepBarang]);
      }
      public function FilBarang (Request $request)
      {
        if ($request->AksiFilter =='Filter') {
          $CAW = $request->tgl_awal;
          $CAK = $request->tgl_akhir;
          if ($CAW > $CAK) {
            $request->session()->flash('danger', 'Tanggal Awal Lebih Besar Dari Tanggal Akhir');
            return redirect('/ReportBarang');
          } else {
          $tgawal = $request->tgl_awal;
          $tgakhir = $request->tgl_akhir;
     
          $FilBar = Barang::whereBetween('barangs.updated_at',[$tgawal,$tgakhir])->get();
    
            return view('Search.s-LaporanBarang',['FilBar'=>$FilBar,'tgawal'=>$tgawal,'tgakhir'=>$tgakhir]);
          }
        }
      }
      public function PDFBar(Request $request)
    {
      $filawal = $request->filawal;
      $filakhir = $request->filakhir;
      $getBar = Barang::whereBetween('barangs.updated_at',[$filawal,$filakhir])->get();
      $pdfTrans = \PDF::loadView('Laporan.l-barang',['getBar'=>$getBar,'filawal'=>$filawal,'filakhir'=>$filakhir])->setPaper('a4','potrait');
      $filename = 'Barang'.$filawal.'-'.$filakhir;
      return $pdfTrans->stream($filename.'.pdf');
      // dd($request->all());
    }

      public function Search(Request $request)
      {
        $SearchBarang = $request->BarSearch;
        $ChkBar = barang::where('barangs.nm_brg', 'like', '%' . $SearchBarang . '%')->get(['kd_brg']);
        $result = count($ChkBar);
        // dd($result);
        if ($result == 0 ) {
          $request->session()->flash('search', 'Barang Yang Dicari Tidak Ada !!!');
          return redirect('/dt_brg');
        }else {
          // code...

          $dt_bar =  barang::join('kategoris','kategoris.kd_kategori','=','barangs.kd_kategori')
                      ->where('barangs.nm_brg', 'like', '%' . $SearchBarang . '%')
                      ->paginate(5);

          return view('Search.s-barang',['SearchBarang'=>$SearchBarang,'dt_bar'=>$dt_bar]);
        }
      }

  // public function dumping(Request $request)
  // {
  //   $file = 'asd';
  //   //$request->file('gambar')->store('public/img/barang','public');
  //   return view('dump',['file'=>$file]);
  // }
  //
  // public function dumps(Request $request)
  // {
  //
  //   $path = $request->file('gambar')->store('gambar','public');
  //
  //       return $path;
  //
  //
  // }

}
