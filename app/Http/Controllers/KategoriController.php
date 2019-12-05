<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\kategori as kategori;

class KategoriController extends Controller
{
  public function __construct()
  {
    $this->middleware('RevalidateBackHistory');
      $this->middleware('auth');
  }
  public function show()
  {
    $kategoris = kategori::orderBy('kd_kategori','ASC')
    ->paginate(5);
    return view('kategori',['kategoris'=>$kategoris]);
  }
  public function create()
  {
    $lastIDkategori = kategori::orderBy('kd_kategori', 'desc')->first();

    if ( ! $lastIDkategori )

        $number = 0;
    else
        $number = substr($lastIDkategori->kd_kategori, 2);

    $kd_kat = 'K' . sprintf('%03d', intval($number) + 1);


      return view('create/c-kat',['kd_kat'=>$kd_kat]);
  }
  public function store(Request $request)
  {
    $AksiKategori = $request->AksiKategori;
    if ($AksiKategori == 'Cancel') {
      return redirect('/dt_kategori');
    }else{
      // code...
      $cariKat = strtolower($request->nm_kategori);
      $kd_kate = $request->kd_kategori;
      $cekKat = kategori::where('nm_kategori', $cariKat)->orWhere('nm_kategori', $kd_kate)->count();
      // $cAsal = strtolower($cekKat->nm_kategori);
      // dd(  $cekKat );
      if ($cekKat >= 1) {
        $request->session()->flash('dangerkat', 'Kategori Sudah Ada, Silahkan Cek Lagi');
        return redirect('/dt_kategori');
      } else{
          $messages =  [
              'nm_kategori.string' => 'Nama Kategori Hanya Mengandung Huruf',
              'nm_kategori.required' => 'Nama Kategori Masih Kosong',
          ];
          $this->validate($request,[
            'nm_kategori' => 'required|string|max:255',
          ],$messages);


      $simpan =  kategori::create([
       'kd_kategori' => $request->kd_kategori,
       'nm_kategori' => $request->nm_kategori,
     ]);
     $request->session()->flash('hore', 'Kategori Berhasil Ditambah');
       return redirect('/dt_kategori');
     }
    }
  }

  public function edit($kd_kategori)
    {
      $ubahKat = kategori::find($kd_kategori);
      return view('Edit/e-kat',['ubahKat'=>$ubahKat]);
    }

    public function update(Request $request)
    {
      $AksiKatEdit = $request->AksiKatEdit;
      if ($AksiKatEdit == 'Cancel') {
        return redirect('/dt_kategori');
      }elseif ($AksiKatEdit == 'Simpan') {
        // code...
        $cek = kategori::where('nm_kategori', $request->nm_kategori)->get(['nm_kategori']);
        $cek2 = count($cek);
        if ($cek2 >= 1 ) {
          $request->session()->flash('dangerkat', 'Kategori Sudah Ada, Silahkan Cek Lagi');
          return redirect('/dt_kategori');
        }else{
        $messages =  [
            'nm_kategori.regex' => 'Nama Kategori Hanya Boleh Huruf',
            'nm_kategori.required' => 'Nama kategori masih kosong',
            
        ];
        $rules = [
          'nm_kategori' => 'required|regex:/^[\pL\s\-]+$/u',
        ];
        $this->validate($request,$rules,$messages);

          $kod_kat = $request->kd_kategori;
          $nm_kat = $request->nm_kategori;
          $upKat = Kategori::find($kod_kat);
          // dd($request->all());
          $upKat->fill([
            'nm_kategori' => $nm_kat,
          ])->save();
          $request->session()->flash('horeUpdate', 'Kategori Berhasil Diubah');
          return redirect('/dt_kategori');
        }
      }
    }




    public function destroy(Request $request,$kd_kategori)
    {
    
      $qwe = kategori::where('kd_kategori',$kd_kategori);
      if ($qwe->exists()) {
        $delKat = Kategori::destroy($kd_kategori);
        return redirect('/dt_kategori');
      } else {
        $request->session()->flash('dangerkat', 'Kategori Tidak ditemukan');
        return redirect('/dt_kategori');
      }

    
    }


    public function Search(Request $request)
    {
      $SearchKategori = $request->KatSearch;

      $ChkKat = kategori::where('kategoris.nm_kategori', 'like', '%' . $SearchKategori . '%')->get(['kd_kategori']);
      $hasil = count($ChkKat);

      if ($hasil == 0 ) {
        $request->session()->flash('search', 'Kategori Yang Dicari Tidak Ada !!!');
        return redirect('/dt_kategori');
      }else{
        $dt_kat = kategori::where('kategoris.nm_kategori', 'like', '%' . $SearchKategori . '%')
                    ->paginate(5);

        return view('Search.s-kategori',['SearchKatergori'=>$SearchKategori,'dt_kat'=>$dt_kat]);
      }
    }


}
