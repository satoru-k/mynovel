<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Novel;

class TitleController extends Controller
{
    //作品index
    public function index(Request $request)
    {
      $search = $request->search;
      $cond_title = $request->cond_title;
      $cond_name = $request->cond_name;
      $cond_maincategory = $request->cond_maincategory;
      $cond_subcategory = $request->cond_subcategory;
      $cond_end = $request->cond_end;

      $query = Novel::query();

      if ($cond_title != '') {
          $query->where('novel_title', 'LIKE', '%'.$cond_title.'%');
      }
      if ($cond_name != '') {
          //作者名で検索
          $query->whereHas('user', function ($query) use ($cond_name) {
            $query->where('name', 'LIKE', '%'.$cond_name.'%');
          });
      }
      if ($cond_maincategory != '') {
          $query->where('novel_maincategory', $cond_maincategory);
      }
      if ($cond_subcategory != '') {
          $query->where('novel_subcategory', $cond_subcategory);
      }
      if ($cond_end == '1') {
          $query->where('end_check', '1');
      } elseif ($cond_end == '0') {
          $query->where('end_check', null);
      }

      $sort = $request->sort;

      if ($sort == 'title_d') {
        $query->orderBy('novel_title', 'desc');
      }
      if ($sort == 'category_a') {
        $query->orderBy('novel_maincategory', 'asc');
      }
      if ($sort == 'category_d') {
        $query->orderBy('novel_maincategory', 'desc');
      }
      if ($sort == 's-category_a') {
        $query->orderBy('novel_subcategory', 'asc');
      }
      if ($sort == 's-category_d') {
        $query->orderBy('novel_subcategory', 'desc');
      }
      if ($sort == 'wasuu_a') {
        $query->withCount('stories')->orderBy('stories_count', 'asc');
      }
      if ($sort == 'wasuu_d') {
        $query->withCount('stories')->orderBy('stories_count', 'desc')->orderBy('novel_title', 'desc');
      }
      if ($sort == 'updated_a') {
        $query->orderBy('updated_at', 'asc');
      }
      if ($sort == 'updated_d') {
        $query->orderBy('updated_at', 'desc');
      }
      if ($sort == 'author_a') {
        $query->with('users')
          ->join('users', 'novels.user_id', '=', 'users.id')
          ->orderBy('users.name', 'asc');
      }
      if ($sort == 'author_d') {
        $query->with('users')
          ->join('users', 'novels.user_id', '=', 'users.id')
          ->orderBy('users.name', 'desc')
          ->orderBy('novel_title', 'desc');
      }

      if ($sort == '') {
        $posts = $query->orderBy('novel_title', 'asc')->paginate(10);
      } else {
        $posts = $query->paginate(10);
      }

      return view('title.index', ['posts' => $posts, 'cond_title' => $cond_title, 'cond_name' => $cond_name, 'cond_maincategory' => $cond_maincategory, 'cond_subcategory' => $cond_subcategory, 'cond_end' => $cond_end, 'sort' => $sort, 'search' => $search]);

      // //旧ver
      // $cond_title = $request->cond_title;
      // if ($cond_title != '') {
      //     //検索されたら検索結果を取得する
      //     $posts = Novel::where('novel_title', 'LIKE', '%'.$cond_title.'%')->orderBy('updated_at', 'desc')->paginate(10);
      // } else {
      //     //それ以外はすべての作品を取得する
      //     $posts = Novel::orderBy('updated_at', 'desc')->paginate(10);
      //     //$posts = Novel::all()->sortByDesc('updated_at');
      // }
      //   return view('title.index', ['posts' => $posts, 'cond_title' => $cond_title]);
    }
}
