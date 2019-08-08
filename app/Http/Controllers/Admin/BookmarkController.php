<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\User;
use App\Novel;
use App\Bookmark;

class BookmarkController extends Controller
{
    public function bookmark(Request $request)
    {
        $book = Bookmark::where('user_id', '=', Auth::user()->id)->where('novel_id', '=', $request->id)->first();
        //Bookmarkモデルに登録されていなければ、作成してsaveする
        if (!isset($book)) {
          $bookmark = new Bookmark;
          $bookmark->user_id = Auth::user()->id;
          $bookmark->novel_id = $request->id;
          //$bookmark->attach();
          $bookmark->save();
        }

        return redirect('novel/'.$request->id);
    }

    public function cancel(Request $request)
    {
        //Bookmarkモデルからデータを取得する
        $bookmark = Bookmark::where('user_id', Auth::id())->where('novel_id', $request->id)->first();

        // //投稿者本人と管理者のみ削除できる
        // $this->authorize('edit', $novel);

        //該当する小説のブックマークを解除(削除)
        $bookmark->delete();

        return redirect('novel/'.$request->id);
    }

    public function marking(Request $request)
    {
      $book = Bookmark::where('user_id', '=', Auth::user()->id)->where('novel_id', '=', $request->n)->first();
      //dd($book);

      $book->story_num = $request->s;
      $book->save();

      // //どのNovelを参照するかを決め->sort_numが一致した記事を->1つ取得
      // $posts = Novel::find($id)->stories()->where('sort_num', $sort_num)->first();
      // //dd($posts);
      //
      // $n = Novel::find($id);
      // $max = Novel::find($id)->stories()->max('sort_num');

      return redirect('novel/'.$request->n.'/story/'.$request->s);
    }

    public function noMarking(Request $request)
    {
      $book = Bookmark::where('user_id', '=', Auth::user()->id)->where('novel_id', '=', $request->n)->first();

      $book->story_num = null;
      $book->save();

      return redirect('novel/'.$request->n.'/story/'.$request->s);
    }
}
