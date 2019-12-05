<?php

namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'name', 'email', 'password','kd_level','alamat','no_hp','kota'
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function role()
    {
      return $this->hasOne(role::class,'kd_level');
    }
    public function barangs()
    {
      return $this->belongsToMany(barang::class,'barang_user','id','kd_brg')
              ->withPivot(['jumlah'])
              ->withTimestamps();
    }
    public function Transaksi()
    {
      return $this->hasMany(Transaction::class,'id');
    }

}
