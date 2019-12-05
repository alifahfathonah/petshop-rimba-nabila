<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\user as user;
use App\role as role;
use Illuminate\Support\Facades\Auth;
class UserController extends Controller
{
  public function __construct()
  {
    $this->middleware('RevalidateBackHistory');
      $this->middleware('auth');
  }
  public function show()
  {

    $users = user::join('roles','roles.kd_level','=','users.kd_level')
    ->orderBy('id')
    ->paginate(10);

    $UserAuthentikasi = user::join('roles','roles.kd_level','=','users.kd_level');
    $UserVerified = $UserAuthentikasi->findOrFail(Auth::id());
      $Rolee = role::all();

  return view('users',['users'=>$users, 'UserAuthentikasi'=>$UserAuthentikasi, 'UserVerified'=>$UserVerified,'Rolee'=>$Rolee]);
  }

  public function Search(Request $request)
  {
    $SearchUser = $request->UseSearch;
    $ChkUse= user::where('users.name', 'like', '%' . $SearchUser . '%')->get(['id']);
    $chkRole = role::where('level', 'like', '%' .$SearchUser.'%')->get(['kd_level']);
    // dd($chkRole,$ChkUse);
    $countUser = count($ChkUse);
    $countRole = count($chkRole);
    // dd($countRole,$countUser);
    if ($countUser < 1 AND $countRole < 1) {
      $request->session()->flash('danger', 'User / Posisi Yang Dicari Tidak Ada !!');
      return redirect('/dt_user');
    }
    $Roleee = role::all();
    $dt_use =  user::join('roles','roles.kd_level','=','users.kd_level')
                ->where('users.name', 'like', '%' . $SearchUser . '%')
                ->orWhere('roles.level', 'like', '%' . $SearchUser . '%')
                ->paginate(10);

    return view('Search.s-user',['SearchUser'=>$SearchUser,'dt_use'=>$dt_use,'Roleee'=>$Roleee]);
  }

      public function destroy($id)
      {
        $delUse = user::destroy($id);
        // $Uf = user::where('id', $id)->destroy();
        return redirect('/dt_user');
      }
      public function UpJabatan(Request $request, $id)
      {
        $qwe = user::where('id',$id);
        if ($qwe->exists()) {
          $JabUse = user::find($id);
          $jabatan = $request->jabatan;
          $JabUse->fill([
            'kd_level'=>$jabatan,
          ])->save();
          $request->session()->flash('updated', 'Hak Akses '.$JabUse->email.' Berhasil Diubah');
          return redirect()->back();
        } else {
          $request->session()->flash('danger', 'Pengguna Tidak Ditemukan');
          return redirect()->back();
      }
    }


}
