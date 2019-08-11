<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\User;

class AuthorController extends Controller
{
    //ユーザーindex
    public function index(Request $request)
    {
      $cond_name = $request->cond_name;
      $cond_work = $request->cond_work;

      $query = User::query();

      if ($cond_name != '') {
          //ユーザー名で検索
          $query->where('name', 'LIKE', '%'.$cond_name.'%');
      }

      //投稿作品の有無で表示・非表示
      if ($cond_work == '1') {
          $query->whereExists(function($q) {
            $q->from('novels')->whereRaw('novels.user_id = users.id');
          });
      } elseif ($cond_work == '0') {
          $query->whereNotExists(function($q) {
            $q->from('novels')->whereRaw('novels.user_id = users.id');
          });
      }

      $sort = $request->sort;

      if ($sort == 'name_d') {
        //ユーザー名降順
        $query->orderBy('name', 'desc');
      }
      if ($sort == 'id_a') {
        //ユーザーID昇順
        $query->orderBy('id', 'asc');
      }
      if ($sort == 'id_d') {
        //ユーザーID降順
        $query->orderBy('id', 'desc');
      }
      if ($sort == 'work_a') {
        //投稿作品数昇順 -> ユーザー名昇順
        $query->withCount('novels')->orderBy('novels_count', 'asc')->orderBy('name', 'asc');
      }
      if ($sort == 'work_d') {
        //投稿作品数降順 -> ユーザー名降順
        $query->withCount('novels')->orderBy('novels_count', 'desc')->orderBy('name', 'desc');
      }
      if ($sort == 'end_a') {
        //完結済数昇順 -> 投稿作品数昇順 -> ユーザー名昇順
        $query->withCount([
          'novels',
          'novels as ends_count' => function($q) {
            $q->where('end_check', '=', '1');
          }
        ])->orderBy('ends_count', 'asc')
          ->orderBy('novels_count', 'asc')
          ->orderBy('name', 'asc');
        // $query->withCount(['novels' => function($q) {
        //   $q->where('end_check', '=', '1');
        // }])->orderBy('novels_count', 'asc')->orderBy('name', 'asc');
      }
      if ($sort == 'end_d') {
        //完結済数降順 -> 投稿作品数降順 -> ユーザー名降順
        $query->withCount([
          'novels',
          'novels as ends_count' => function($q) {
            $q->where('end_check', '=', '1');
          }
        ])->orderBy('ends_count', 'desc')
          ->orderBy('novels_count', 'desc')
          ->orderBy('name', 'desc');
      }
      if ($sort == 'updated_a') {
        //最終更新日昇順 -> ユーザー名昇順
        $query->leftjoin('novels', 'users.id', '=', 'novels.user_id')
          ->select('users.id', 'name', DB::raw('max(novels.updated_at) as maxup'))
          ->groupBy('users.id')
          ->orderByRaw('max(novels.updated_at) IS NULL ASC')
          ->orderBy('maxup', 'asc')
          ->orderBy('name', 'asc');
      }
      if ($sort == 'updated_d') {
        //最終更新日降順 -> ユーザー名昇順
        $query->leftjoin('novels', 'users.id', '=', 'novels.user_id')
          ->select('users.id', 'name', DB::raw('max(novels.updated_at) as maxup'))
          ->groupBy('users.id')
          ->orderByRaw('max(novels.updated_at) IS NULL ASC')
          ->orderBy('maxup', 'desc')
          ->orderBy('name', 'asc');
      }

      if ($sort == '') {
        $posts = $query->orderBy('name', 'asc')->paginate(10);
      } else {
        $posts = $query->paginate(10);
      }

      foreach($posts as $p) {
        if ($p->novels()->count('updated_at') > 0) {
          $p->updated_at = $p->novels()->max('updated_at');
        }
      }

      return view('author.index', ['posts' => $posts, 'cond_name' => $cond_name, 'cond_work' => $cond_work, 'sort' => $sort]);

      // //旧ver
      // $cond_name = $request->cond_name;
      // if ($cond_name != '') {
      //     //検索されたら検索結果を取得する
      //     $posts = User::where('name', 'LIKE', '%'.$cond_name.'%')->orderBy('name', 'asc')->paginate(10);
      // } else {
      //     //それ以外はすべてのユーザー名を取得する
      //     $posts = User::orderBy('name', 'asc')->paginate(10);
      // }
      //
      // foreach($posts as $p) {
      //   if ($p->novels()->count('updated_at') > 0) {
      //     $p->updated_at = $p->novels()->max('updated_at');
      //   }
      // }
      //
      // return view('author.index', ['posts' => $posts, 'cond_name' => $cond_name]);
    }
}
