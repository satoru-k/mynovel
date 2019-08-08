<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Story;
use App\Novel;
use App\Bookmark;
use Carbon\Carbon;

class StoryController extends Controller
{
  //addアクション
  public function add(Request $request)
  {
    //Novelモデルからデータを取得する
    $form = Novel::find($request->id);

    //その小説の投稿者本人と管理者のみ物語を投稿できる
    $this->authorize('edit', $form);

    $num = Novel::find($request->id)->stories->sortBy('sort_num');

    //return view('admin.story.create');
    return view('admin.story.create', ['form' => $form, 'num' => $num]);
  }

  public function create(Request $request, Novel $novel)
  {
    // Varidationを行う
    $this->validate($request, Story::$rules);

    //$form = Novel::find($request->id);
    //$form = $request->all();

    $story = new Story;
    $story->user_id = Auth::user()->id;
    $story->story_title = $request->story_title;
    $story->story_body = $request->story_body;
    $story->foreword = $request->foreword;
    $story->afterword = $request->afterword;
    $story->chapter = $request->chapter;
    $story->novel_id = $request->id;
    //$story->sort_num = Story::where('novel_id', $story->novel_id)->count()+1;

    //選択した位置に割り込み投稿
    if ($request->num != null) {
      $story->sort_num = $request->num;
      $stories = Novel::find($request->id)->stories()->where('sort_num', '>=', $request->num)->get();
      foreach ($stories as $s) {
        $s->sort_num += 1;
        $s->timestamps = false;
        $s->save();
      }
    } else {
      $story->sort_num = Story::where('novel_id', $story->novel_id)->count()+1;
    }

    //storyを投稿すると同時に、そのnovelのupdated_atを上書き
    $update = Novel::find($request->id);
    $update->updated_at = Carbon::now();
    $update->save();

    // //一番上に割り込み投稿
    // $story->sort_num = 1;
    // $stories = Novel::find($request->id)->stories()->get();
    // foreach ($stories as $s) {
    //   $s->sort_num += 1;
    //   $s->save();
    // }

    // //フォームから送信されてきた_tokenを削除する
    // unset($form['_token']);

    $story->save();

    return redirect('novel/'.$story->novel_id);
    //return redirect()->route('novel', ['id' => $story->novel_id]);
  }

  public function edit(Request $request)
  {
      //Storyモデルからデータを取得する
      $story = Story::find($request->id);
      if (empty($story)) {
        abort(404);
      }

      //投稿者本人と管理者のみ編集できる
      $this->authorize('edit', $story);

      return view('admin.story.edit', ['story_form' => $story]);
  }

  public function update(Request $request)
  {
      //Validationをかける
      $this->validate($request, Story::$rules);
      //モデルからデータを取得する
      $story = Story::find($request->id);
      //送信されてきたフォームデータを格納する
      $story_form = $request->all();

      unset($story_form['_token']);

      //該当するデータを上書きして保存する
      $story->fill($story_form)->save();

      //storyを更新すると同時に、そのnovelのupdated_atを上書き
      $update = Novel::find($story->novel_id);
      $update->updated_at = Carbon::now();
      $update->save();

      return redirect('novel/'.$story->novel_id);
  }

  public function delete(Request $request)
  {
      //Storyモデルからデータを取得する
      $story = Story::find($request->id);

      //投稿者本人と管理者のみ削除できる
      $this->authorize('edit', $story);

      //選択した物語を削除
      $story->delete();

      if (count(Story::where('novel_id', '=', $story->novel_id)->get()) != 0) {
        /* 削除した記事とnovel_idが一致するものを取得
           ->その中から、削除した記事よりもsort_numが大きいもののみを取得 */
        $stories = Story::where('novel_id', '=', $story->novel_id)->where('sort_num', '>', $story->sort_num)->get();
        //上記で取得した記事のsort_numを全て-1してsaveする
        foreach ($stories as $s) {
          $s->sort_num -= 1;
          $s->timestamps = false;
          $s->save();
        }
      }

      //削除後、sort_numの最大値を取得
      $max = Story::where('novel_id', '=', $story->novel_id)->max('sort_num');

      if (count(Bookmark::where('novel_id', '=', $story->novel_id)->get()) != 0) {
        //story_num(しおりを挿んだ位置)がsort_numの最大値を超えていたら、
        $mark = Bookmark::where('novel_id', '=', $story->novel_id)->where('story_num', '>', $max)->get();
        //しおりを解除
        foreach ($mark as $m) {
          $m->story_num = null;
          $m->timestamps = false;
          $m->save();
        }
      }

      return redirect('novel/'.$story->novel_id);
  }
}
