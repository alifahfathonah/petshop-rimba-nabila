<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
  protected $guarded = [
     'created_at','updated_at',
  ];
  public $primaryKey = 'kd_trans';
    public $incrementing = false;
  protected $dates = [];

  public function tb_detail()
  {
    return $this->hasOne(tb_detail::class,'kd_trans','kd_trans');
  }
  public function User()
  {
    return $this->belongsTo(User::class,'id');
  }
}
