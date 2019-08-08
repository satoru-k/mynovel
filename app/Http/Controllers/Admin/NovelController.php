<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Novel;
use App\Story;

class NovelController extends Controller
{
    //addアクション
    public function add()
    {
      return view('admin.novel.create');
    }

    public function create(Request $request)
    {
      // Varidationを行う
      $this->validate($request, Novel::$rules);

      $novel = new Novel;

      $novel->novel_title = $request->novel_title;
      $novel->novel_introduction = $request->novel_introduction;
      $novel->novel_maincategory = $request->novel_maincategory;
      $novel->novel_subcategory = $request->novel_subcategory;
      $novel->user_id = Auth::user()->id;

      /*
      $novel->user_id = User::find($request->input('id'));

      $form = $request->all();
      */

      // フォームから送信されてきた_tokenを削除する
      //unset($form['_token']);

      // データベースに保存する
      //$novel->fill($form)->save();
      $novel->save();

      return redirect('user/'.$novel->user_id);
    }

    public function edit(Request $request)
    {
        //Novelモデルからデータを取得する
        $novel = Novel::find($request->id);
        if (empty($novel)) {
          abort(404);
        }

        //投稿者本人と管理者のみ編集できる
        $this->authorize('edit', $novel);

        return view('admin.novel.edit', ['novel_form' => $novel]);
    }

    public function update(Request $request)
    {
        //Validationをかける
        $this->validate($request, Novel::$rules);
        //Novelモデルからデータを取得する
        $novel = Novel::find($request->id);
        //送信されてきたフォームデータを格納する
        $novel_form = $request->all();

        unset($novel_form['_token']);

        //該当するデータを上書きして保存する
        $novel->fill($novel_form)->save();

        return redirect('user/'.$novel->user_id);
    }

    public function delete(Request $request)
    {
        //Novelモデルからデータを取得する
        $novel = Novel::find($request->id);

        //投稿者本人と管理者のみ削除できる
        $this->authorize('edit', $novel);

        //選択した小説を削除
        $novel->delete();

        //削除した小説とnovel_idが一致する記事を全て取得し、それらも全て削除
        $stories = Story::where('novel_id', '=', $novel->id);
        $stories->delete();

        return redirect('user/'.$novel->user_id);
    }
}
