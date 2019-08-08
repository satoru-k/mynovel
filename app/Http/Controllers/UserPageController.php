<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Auth;
use App\Novel;
use App\User;
use App\Story;
use App\Profile;
use App\Bookmark;

class UserPageController extends Controller
{
    public function show($id,Request $request)
    {
      if (User::findOrFail($id)) {
        $posts = User::find($id)->novels()->orderBy('updated_at', 'desc')->paginate(5, ["*"], 'p_page')->appends(['b_page' => $request->input('b_page')]);
      } else {
        abort(404);
      }

      $name = User::find($id)->name;
      $user_id = User::find($id)->id;

      if (Novel::find($id)) {
        $max = Novel::find($id)->stories()->max('sort_num');
      } else {
        $max = null;
      }

      // if (User::find($id)) {
      //   $profile = User::find($id)->profiles()->get();
      // } else {
      //   $profile = null;
      // }
      if (Profile::where('user_id', '=', $user_id)->first()) {
        $profile = Profile::where('user_id', '=', $user_id)->first();
      } else {
        $profile = new Profile;
      }

      $bookmarks = User::find($id)->bookmarks()->orderBy('created_at', 'desc')->paginate(5, ["*"], 'b_page')->appends(['p_page' => $request->input('p_page')]);

      // $bookmarks_id = User::find($id)->bookmarks()->select('novel_id')->get();
      //
      // $query = Novel::query();
      // $bookmarks = Novel::whereIn('id', $bookmarks_id)
      // ->with(['bookmarks' => function($query) use($user_id) {
      //   $query->where('user_id', '=', $user_id);
      //   $query->orderBy('created_at', 'desc');
      // }])->paginate(5, ["*"], 'b_page')->appends(['p_page' => $request->input('p_page')]);
      //
      // $bookmarks = Novel::novel_sort(Auth::user(),Novel::all());
      // dd($bookmarks);

      return view('user.index', ['posts' => $posts, 'user' => User::findOrFail($id), 'name' => $name, 'id' => $user_id, 'max' => $max, 'profile' => $profile, 'bookmarks' => $bookmarks]);
    }
}
