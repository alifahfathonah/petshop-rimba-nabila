<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class kategori extends Model
{
  protected $guarded = [
     'created_at','updated_at',
  ];
  public $primaryKey = 'kd_kategori';
  public $incrementing = false;
    public function barang()
    {
      return $this->belongsTo('app\barang','kd_kategori') ;
    }
}
