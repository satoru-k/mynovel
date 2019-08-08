<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    protected $guarded = array('id');

    public function user()
    {
      return $this->belongsTo('App\User');
    }

    //Novelモデルと関連付け
    public function novel()
    {
      return $this->belongsTo('App\Novel');
    }

    // //Novelモデルと関連付け
    // public function novel()
    // {
    //   return $this->hasMany('App\Novel');
    // }
}
