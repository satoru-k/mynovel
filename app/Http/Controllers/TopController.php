<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Novel;

class TopController extends Controller
{
    //トップページ
    public function top(Request $request)
    {
        $n_count = Novel::count();
        $u_count = User::count();

        $update_novels = Novel::orderBy('updated_at', 'desc')->take(5)->get();
        $end_novels = Novel::where('end_check', '1')->orderBy('updated_at', 'desc')->take(5)->get();
        //$create_novels = Novel::orderBy('created_at', 'desc')->take(5)->get();

        // $posts = Novel::all()->sortByDesc('updated_at');
        //
        // if (count($posts) > 0) {
        //     $headline = $posts->shift();
        // } else {
        //     $headline = null;
        // }

        return view('top', ['n_count' => $n_count, 'u_count' => $u_count, 'update_novels' => $update_novels, 'end_novels' => $end_novels]);
    }
}
