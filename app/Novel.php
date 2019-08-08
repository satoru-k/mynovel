<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Novel extends Model
{
    protected $guarded = array('id');
    // protected $fillable = [
    //   'novel_title', 'novel_maincategory', 'novel_subcategory'
    // ];

    public static $rules = array(
      'novel_title' => 'required|max:255',
      'novel_introduction' => 'required|max:500',
      'novel_maincategory' => 'required',
      'novel_subcategory' => 'required',
    );

    public function user()
    {
      return $this->belongsTo('App\User');
    }

    public function users()
    {
      return $this->belongsTo('App\User');
    }

    //Storyモデルと関連付け
    public function stories()
    {
      return $this->hasMany('App\Story');
    }

    //Bookmarkモデルと関連付け
    public function bookmarks()
    {
      return $this->hasMany('App\Bookmark');
    }

    // //Bookmarkモデルと関連付け
    // public function books()
    // {
    //   return $this->belongsTo('App\Bookmark');
    // }

    // public static function novel_sort($user,$novels)
    // {
    //   $array_novel = array();
    //   $array_bookmark = array();
    //   foreach($novels as $n) {
    //     $b = $n->bookmarks()->where('user_id', $user->id)->first();
    //     if ($b != null) {
    //       array_push($array_bookmark,$b);
    //     }
    //   }
    //   $sort_bookmark = $array_bookmark;
    //   foreach ($sort_bookmark as $sb) {
    //     array_push($array_novel,$sb->novel());
    //   }
    //   return $array_novel;
    // }
}
