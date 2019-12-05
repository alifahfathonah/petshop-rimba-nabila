<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User as user;
class ProfileController extends Controller
{
  public function __construct()
  {
    $this->middleware('RevalidateBackHistory');
      $this->middleware('auth');
  }
    //
    public function dash()
    {
      return view('dashboard');
    }
    public function UserProfile(Request $request)
    {


    $cek = user::find(Auth::id());
    if ($cek->no_hp==null AND $cek->alamat==null) {
      $request->session()->flash('nAlamat', 'Alamat Masih Kosong, Silahkan Ubah Profil');
      $request->session()->flash('nHP', 'Nomor Handphone / Telepon Masih Kosong, Silahkan Ubah Profil');
      $profil = user::join('roles','roles.kd_level','=','users.kd_level')->find(Auth::id());
       return view('profile',['profil'=>$profil]);
    }elseif ($cek->no_hp==null) {
      $request->session()->flash('nHP', 'Nomor Handphone / Telepon Masih Kosong, Silahkan Ubah Profil');
      $profil = user::join('roles','roles.kd_level','=','users.kd_level')->find(Auth::id());
       return view('profile',['profil'=>$profil]);
    }elseif ($cek->alamat==null ) {
      $request->session()->flash('nAlamat', 'Alamat Masih Kosong, Silahkan Ubah Profil');
      $profil = user::join('roles','roles.kd_level','=','users.kd_level')->first();
       return view('profile',['profil'=>$profil]);
    }
      $profil = user::join('roles','roles.kd_level','=','users.kd_level')->first();
       return view('profile',['profil'=>$profil]);
    }
    public function ProfileForm()
    {
      return view('Edit.e-profil');
    }
    public function PassForm(Request $request)
    {

      return view('Edit.e-pass');
    }
    public function PassChange(Request $request)
    {
      $FindUser = user::find(Auth::id());
      $opw = $request->OldPass;
      $npw = $request->NewPass;
      $AksiProfil = $request->AksiPass;
      // dd($AksiProfil);
      if ($AksiProfil == 'Cancel') {
        return redirect('/profile');
      }
      elseif ($AksiProfil == 'Simpan') {
        // code...

      // START ERROR MESSAGE

      $messages =  [
          'OldPass.alpha_num' => 'Karakter Hanya Huruf dan Angka',
          'NewPass.alpha_num' => 'Karakter Hanya Huruf dan Angka',
          'OldPass.min' => 'Password Lama Minimal 6 Digit Karakter',
          'NewPass.min' => 'Password Baru Minimal 6 Digit Karakter',
          'OldPass.required' => 'Password Lama Tidak Boleh Kosong',
          'NewPass.required'  => 'Password Baru Masih kosong',

      ];
      $this->validate($request,[
        'OldPass' => 'required|alpha_num|min:6|',
        'NewPass' => 'required|alpha_num|min:6|'
      ],$messages);
      // END ERROR MESSAGE

      if (Hash::check($opw, $FindUser->password)) {

          $FindUser->fill([
               'password' => Hash::make($npw),
             ])->save();
             $request->session()->flash('updatedpass', 'Password Berhasil Diubah, Silahkan Login Kembali Dengan Password Baru.');
        return redirect('/dashboard');
        }else {
          $request->session()->flash('Beda', 'Password Lama Berbeda, Silahkan Cek Lagi');
          return redirect()->back();
        }
      }
    }
    public function ProfileChange(Request $request)
    {
      $nama = $request->nama;
      $nope = $request->nope;
      $alamat = $request->alamat;
      $kota = $request->kota;
      $id = Auth::id();
      $AksiProfil = $request->AksiProfil;
      // START ERROR MESSAGE
      if ($AksiProfil == 'Cancel') {
        return redirect('/profile');
      }elseif ($AksiProfil == 'Simpan') {
        // code...

      $messages =  [
          'nama.string' => 'Nama Hanya Mengandung Huruf',
          'kota.regex' => 'Kota Hanya Mengandung Huruf',
          'alamat.string' => 'Alamat Hanya Mengandung Huruf,Angka, dan simbol',
          'nope.numeric' => 'Nomor Telepon Hanya Mengandung Angka',
          'nope.digits' => 'Nomor Telepon Maksimal 13 Angka',
          'nama.required' => 'Nama Tidak Boleh Kosong',
          'kota.required' => 'Kota Tidak Boleh Kosong',
          'nope.required'  => 'Nomor Telepon Masih kosong',
          'alamat.required'  => 'Alamat Masih kosong',
      ];
      $this->validate($request,[
        'nama' => 'required|string|max:255',
        'kota' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
        'alamat' => 'required|string',
        'nope' =>'required|numeric|digits_between:1,13',

      ],$messages);

        // END ERROR MESSAGE

        // $tesus = user::find($id);
        // dd($tesus);
        // dd($nama,$nope,$alamat,$id);
            $ConnUser = user::find($id);
            $ConnUser->fill([
                 'name' => $nama,
                 'no_hp' => $nope,
                 'alamat' => $alamat,
                 'kota' => $kota,
               ])->save();
            $request->session()->flash('updated', 'Profil Telah Diperbaharui');
        return redirect('/profile');
        }
    }
}
