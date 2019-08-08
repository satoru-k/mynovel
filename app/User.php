<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
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
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * 現在のユーザー、または引数で渡されたIDが管理者かどうかを返す
     *
     * @param  number  $id  User ID
     * @return boolean
     */
    public function isAdmin($id = null) {
        $id = ($id) ? $id : $this->id;
        return $id == config('admin_id');
    }

    //Novelモデルと関連付け
    public function novels()
    {
      return $this->hasMany('App\Novel');
    }

    //Storyモデルと関連付け
    public function stories()
    {
      return $this->hasMany('App\Story');
    }

    //Profileモデルと関連付け
    public function profiles()
    {
      return $this->hasMany('App\Profile');
    }

    //Bookmarkモデルと関連付け
    public function bookmarks()
    {
      return $this->hasMany('App\Bookmark');
    }

    // public function updates()
    // {
    //   return $this->hasOne('App\Novel')->max('updated_at');
    // }
}
