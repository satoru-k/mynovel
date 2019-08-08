@extends('layouts.adminC')

@section('title', '小説家になりたい気がする')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-10 mx-auto mt-3">
        <h2 class="welcome text-center">Welcome to <span class="top-logo">小説家になりたい気がする</span></h2>
        <div class="text-center pt-2">
          <p class="mb-2">投稿小説総数<span class="top-count mx-1" style="font-size:16px; vertical-align:baseline;">{{ $n_count }}</span>作品
          <span class="ml-4">登録ユーザー数<span class="top-count mx-1" style="font-size:16px; vertical-align:baseline;">{{ $u_count }}</span>人</span>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-10 mx-auto" style="line-height:30px; font-size:16px;">
        <hr color="#c0c0c0">
        <p class="pl-3">本サイトは、不特定多数による投稿小説掲載サイトです。<br>投稿された小説は、<span class="top-free">誰でも、無料で、自由に、</span>閲覧できます。</p>
        <hr color="#c0c0c0">
      </div>
    </div>

    <div class="row row-eq-height">
      <div class="col-md-10 mx-auto d-flex" style="flex-wrap:wrap;">
        <div class="col-md-6">
          <p class="mt-3 ml-3 mb-2">最近更新された小説</p>
          <table class="table table-hover" border="5" bordercolor="#999999">
            <tbody>
              @foreach ($update_novels as $u)
                <tr>
                  <td class="title"><a href="{{ url('novel/'.$u->id) }}" style="font-weight:bold; font-size:larger;">{{ str_limit($u->novel_title, 40) }}</a>
                    <br><span>{{ $u->user->name }}</span>
                    <br><span style="color:#666">{{ $u->novel_subcategory." [".$u->novel_maincategory."]" }}</span>
                    <br><span style="color:#666">{{ $u->updated_at->format('Y年m月d日') }}更新</span>
                    @if ($u->end_check == 1)
                      <span class="fin ml-2">完結</span>
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <div class="col-md-6">
          <p class="mt-3 ml-3 mb-2">最近完結した小説</p>
          <table class="table table-hover" border="5" bordercolor="#999999">
            <tbody>
              @foreach ($end_novels as $e)
                <tr>
                  <td class="title"><a href="{{ url('novel/'.$e->id) }}" style="font-weight:bold; font-size:larger;">{{ str_limit($e->novel_title, 40) }}</a>
                    <br><span>{{ $e->user->name }}</span>
                    <br><span style="color:#666">{{ $e->novel_subcategory." [".$e->novel_maincategory."]" }}</span>
                    <br><span style="color:#666">{{ $e->updated_at->format('Y年m月d日') }}更新</span>
                    <span class="fin ml-2">完結</span>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-10 mx-auto" style="line-height:30px; font-size:16px;">
        <hr color="#c0c0c0">
        <h3 class="top-user text-center">ユーザーになりたい気がする</h3>
        <p class="pl-3">ユーザー登録することで、あなた専用のマイページが作られ、<span class="top-book">小説が投稿できる</span>ようになります。<br>またお気に入りの小説を登録しておく<span class="top-book">ブックマーク機能</span>、さらにその小説が読みかけであれば、その位置を記録しておく<span class="top-book">しおり機能</span>が利用可能となります。この機会に、ぜひお試しください。</p>
        <div class="button text-center">
          <a href="register" role="button" class="btn btn-primary" style="font-size:18px;">新規ユーザー登録 (無料)</a>
        </div>
        <div class="text-center mt-1">
          <a href="login" style="font-size:13px;">アカウントをお持ちの方はログイン</a>
        </div>
        <hr color="#c0c0c0">
      </div>
    </div>
  </div>
@endsection
