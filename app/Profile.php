<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $guarded = array('id');

    // public static $rules = array(
    //   'ruby' => 'max:255',
    //   'hobby' => 'max:255',
    //   'job' => 'max:255',
    //   'website' => 'max:255|url|active_url|nullable',
    //   'introduction' => 'max:255',
    // );

    public function user()
    {
      return $this->belongsTo('App\User');
    }
}
