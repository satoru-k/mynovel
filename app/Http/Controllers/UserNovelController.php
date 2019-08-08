<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Story;
use App\Novel;
use App\User;
use App\Bookmark;

class UserNovelController extends Controller
{
    public function show($id)
    {
      //$posts = User::find($id)->novels;
      //$posts = User::find($id)->novels()->get();
      //dd($posts);

/*
      if (Novel::findOrFail($id)) {
        $posts = Novel::find($id)->get();
      } else {
        abort(404);
      }
*/
      //$posts = Story::find($id)->novels;

      $user_id = Novel::find($id)->user_id;
      $name = Novel::find($id)->user->name;
      $title = Novel::find($id)->novel_title;
      $introduction = Novel::find($id)->novel_introduction;

      $novel_id = Novel::find($id)->id;

      //$bookmark = Bookmark::where('user_id', Auth::id())->where('novel_id', $novel_id)->first();
      if (Bookmark::where('user_id', Auth::id())->where('novel_id', $novel_id)->first()) {
        $bookmark = Bookmark::where('user_id', Auth::id())->where('novel_id', $novel_id)->first();
      } else {
        $bookmark = new Bookmark;
      }

      if (Novel::findOrFail($id)) {
        $posts = Novel::find($id)->stories->sortBy('sort_num');
      } else {
        abort(404);
      }

      return view('story.index', ['novel' => Novel::findOrFail($id), 'name' => $name, 'title' => $title, 'introduction' => $introduction, 'id' => $user_id, 'novel_id' => $novel_id, 'posts' => $posts, 'bookmark' => $bookmark]);
    }
}
