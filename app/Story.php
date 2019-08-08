<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    protected $guarded = array('id');

    public static $rules = array(
      'story_title' => 'required|max:255',
      'story_body' => 'required|max:20000',
      'foreword' => 'max:500',
      'afterword' => 'max:500',
      'chapter' => 'max:50',
    );

    public function user()
    {
      return $this->belongsTo('App\User');
    }

    //Novelモデルと関連付け
    public function novels()
    {
      return $this->belongsTo('App\Novel');
    }
}
