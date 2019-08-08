<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\User;

class AuthorController extends Controller
{
    //作者index
    public function index(Request $request)
    {
      $cond_name = $request->cond_name;
      $cond_work = $request->cond_work;

      $query = User::query();

      if ($cond_name != '') {
          $query->where('name', 'LIKE', '%'.$cond_name.'%');
      }
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
        $query->orderBy('name', 'desc');
      }
      if ($sort == 'id_a') {
        $query->orderBy('id', 'asc');
      }
      if ($sort == 'id_d') {
        $query->orderBy('id', 'desc');
      }
      if ($sort == 'work_a') {
        $query->withCount('novels')->orderBy('novels_count', 'asc')->orderBy('name', 'asc');
      }
      if ($sort == 'work_d') {
        $query->withCount('novels')->orderBy('novels_count', 'desc')->orderBy('name', 'desc');
      }
      if ($sort == 'end_a') {
        $query->withCount(['novels' => function($q) {
          $q->where('end_check', '=', '1');
        }])->orderBy('novels_count', 'asc')->orderBy('name', 'asc');
      }
      if ($sort == 'end_d') {
        $query->withCount(['novels' => function($q) {
          $q->where('end_check', '=', '1');
        }])->orderBy('novels_count', 'desc')->orderBy('name', 'desc');
      }
      if ($sort == 'updated_a') {
        $query->leftjoin('novels', 'users.id', '=', 'novels.user_id')
          ->select('users.id', 'name', DB::raw('max(novels.updated_at) as maxup'))
          ->groupBy('users.id')
          ->orderBy('maxup', 'asc');
      }
      if ($sort == 'updated_d') {
        $query->leftjoin('novels', 'users.id', '=', 'novels.user_id')
          ->select('users.id', 'name', DB::raw('max(novels.updated_at) as maxup'))
          ->groupBy('users.id')
          ->orderBy('maxup', 'desc');
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
