<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Story;
use App\Novel;
use App\User;
use App\Bookmark;

class UserTextController extends Controller
{
    public function show($id,$sort_num)
    {
      //どのNovelを参照するかを決め->sort_numが一致した記事を->1つ取得
      $posts = Novel::find($id)->stories()->where('sort_num', $sort_num)->first();

      //$value = $posts->story_body;
      $search = array("|", "〔", "〕", "\n");
      $replace = array("<ruby><rb>", "</rb><rp>(</rp><rt>", "</rt><rp>)</rp></ruby>", "<br>");
      //$v = str_replace($search, $replace, $posts);
      $posts->story_body = str_replace($search, $replace, $posts->story_body);
      $posts->foreword = str_replace($search, $replace, $posts->foreword);
      $posts->afterword = str_replace($search, $replace, $posts->afterword);

      $n = Novel::find($id);
      $max = Novel::find($id)->stories()->max('sort_num');

      if (Bookmark::where('user_id', '=', Auth::id())->where('novel_id', '=', $n->id)->first()) {
        $book = Bookmark::where('user_id', '=', Auth::id())->where('novel_id', '=', $n->id)->first();
      } else {
        $book = new Bookmark;
      }

      if (Novel::find($id)->stories()->where('chapter', '!=', null)) {
        $ch = Novel::find($id)->stories()->where('sort_num', '<', $posts->sort_num)->where('chapter', '!=', null)->orderBy('sort_num', 'desc')->first();
      } else {
        $ch = null;
      }

      return view('story.detail', ['posts' => $posts, 'n' => $n, 'max' => $max, 'book' => $book, 'ch' => $ch]);
    }

    // public function marking(Request $request)
    // {
    //   $book = Bookmark::where('user_id', '=', Auth::user()->id)->where('novel_id', '=', $request->n)->first();
    //   dd($book);
    //
    //   // $book->story_id = $request->s;
    //   // $book->save();
    //
    //   //どのNovelを参照するかを決め->sort_numが一致した記事を->1つ取得
    //   $posts = Novel::find($id)->stories()->where('sort_num', $sort_num)->first();
    //   //dd($posts);
    //
    //   $n = Novel::find($id);
    //   $max = Novel::find($id)->stories()->max('sort_num');
    //
    //   return redirect('novel/'.$n.'/story/'.$sort_num);
    // }
    // public function marking($id,$sort_num)
    // {
    //   //d($id);
    //   //dd($sort_num);
    //
    //   //$sort_num = Story::find($id)->sort_num;
    //   //$stories = Story::find($id)->story_title;
    //
    //   //どのNovelを参照するかを決め->sort_numが一致した記事を->1つ取得
    //   $posts = Novel::find($id)->stories()->where('sort_num', $sort_num)->first();
    //   //dd($posts);
    //
    //   $n = Novel::find($id);
    //   $max = Novel::find($id)->stories()->max('sort_num');
    //
    //   return redirect('novel/'.$n.'/story/'.$sort_num);
    // }
}
