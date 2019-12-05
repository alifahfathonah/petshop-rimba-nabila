<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tb_detail extends Model
{

  protected $fillable = [
     'kd_trans', 'kd_brg', 'hrg_brg','jml_brg','total','created_at','updated_at'
  ];
  public function Transaction()
  {
     return  $this->belongsTo(Transaction::class,'kd_trans'); // default
  }
  public function Barangs()
  {
     return  $this->belongsToMany(barang::class,'kd_brg'); // default
  }
}
