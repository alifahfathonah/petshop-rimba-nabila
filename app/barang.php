<?php

namespace App;
use App\User as user;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
class barang extends Model
{
  protected $guarded = [
     'created_at','updated_at',
  ];
  public $primaryKey = 'kd_brg';
  public $incrementing = false;
  protected $touches = ['users'];


  public function kategori()
  {
    return $this->hasOne('app\kategori','kd_brg');
  }
  public function users()
  {
    return $this->belongsToMany(user::class,'barang_user','kd_brg','id')
      ->withPivot(['jumlah'])
      ->withTimestamps();
  }

}
