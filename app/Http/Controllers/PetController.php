<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\barang as barang;
use App\kategori as kategori;

class PetController extends Controller
{
    public function show()
    {
   
      $barangs =  barang::join('kategoris','kategoris.kd_kategori','=','barangs.kd_kategori')
                  ->orderBy('kd_brg')
                  ->paginate(9);
   
      return view('index',['barangs'=>$barangs]);
    }
    public function Search(Request $request)
    {
      $SearchData = $request->ProSearch;

      $dt_pro =  barang::join('kategoris','kategoris.kd_kategori','=','barangs.kd_kategori')
                  ->where('barangs.nm_brg', 'like', '%' . $SearchData . '%')
                  ->orWhere('kategoris.nm_kategori', 'like', '%' . $SearchData . '%')
                  ->get();

      return view('Search.s-index',['SearchData'=>$SearchData,'dt_pro'=>$dt_pro]);
    }
    public function kontak()
    {
      return view('kontak');
    }
    public function about()
    {
      return view('about');
    }
}
