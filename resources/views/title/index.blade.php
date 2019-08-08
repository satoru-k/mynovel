@extends('layouts.adminC')

@section('title', '作品一覧')

@section('content')
  <div class="container">
    <div class="row">
      <h2>投稿作品一覧</h2>
      <div class="col-md-6 ml-auto">
        <form action="{{ action('TitleController@index') }}" method="get">
          @csrf
          <div class="form-group row">
            <select id="search" name="search" style="margin-left:15px; width:70px;">
              <option value="s1" selected>作品</option>
              <option value="s2">作者</option>
            </select>
            <div id="s1" name="search_type" class="col-md-10">
                <input type="text" class="form-control" name="cond_title" value="{{ $cond_title }}" placeholder="作品タイトルを入力してください">
            </div>
            <div id="s2" name="search_type" class="col-md-10" style="display:none;">
                <input type="text" class="form-control" name="cond_name" value="{{ $cond_name }}" placeholder="作者名を入力してください">
            </div>
            <div class="col-md-5 mt-2">
              <select class="parent form-control" name="cond_maincategory" value="">
                <option value="" selected disabled style="display:none;">大ジャンル</option>
                <option value="">選択されていません</option>
                <option value="ファンタジー" @if($cond_maincategory=='ファンタジー') selected @endif>ファンタジー</option>
                <option value="恋愛" @if($cond_maincategory=='恋愛') selected @endif>恋愛</option>
                <option value="文芸" @if($cond_maincategory=='文芸') selected @endif>文芸</option>
                <option value="SF" @if($cond_maincategory=='SF') selected @endif>SF</option>
                <option value="その他" @if($cond_maincategory=='その他') selected @endif>その他</option>
                <option value="ノンジャンル" @if($cond_maincategory=='ノンジャンル') selected @endif>ノンジャンル</option>
              </select>
            </div>
            <div class="col-md-5 mt-2">
              <select class="children form-control" id="novel_subcategory" name="cond_subcategory" value="" disabled>
                <option value="" selected disabled style="display:none;">小ジャンル</option>
                <option value="" data-val='ファンタジー'>選択されていません</option>
                <option value="ハイファンタジー" data-val='ファンタジー' @if($cond_subcategory=='ハイファンタジー') selected @endif>ハイファンタジー</option>
                <option value="ローファンタジー" data-val='ファンタジー' @if($cond_subcategory=='ローファンタジー') selected @endif>ローファンタジー</option>
                <option value="" data-val='恋愛'>選択されていません</option>
                <option value="異世界" data-val='恋愛' @if($cond_subcategory=='異世界') selected @endif>異世界</option>
                <option value="現実世界" data-val='恋愛' @if($cond_subcategory=='現実世界') selected @endif>現実世界</option>
                <option value="" data-val='文芸'>選択されていません</option>
                <option value="純文学" data-val='文芸' @if($cond_subcategory=='純文学') selected @endif>純文学</option>
                <option value="ヒューマンドラマ" data-val='文芸' @if($cond_subcategory=='ヒューマンドラマ') selected @endif>ヒューマンドラマ</option>
                <option value="歴史" data-val='文芸' @if($cond_subcategory=='歴史') selected @endif>歴史</option>
                <option value="推理" data-val='文芸' @if($cond_subcategory=='推理') selected @endif>推理</option>
                <option value="ホラー" data-val='文芸' @if($cond_subcategory=='ホラー') selected @endif>ホラー</option>
                <option value="アクション" data-val='文芸' @if($cond_subcategory=='アクション') selected @endif>アクション</option>
                <option value="コメディー" data-val='文芸' @if($cond_subcategory=='コメディー') selected @endif>コメディー</option>
                <option value="" data-val='SF'>選択されていません</option>
                <option value="VRゲーム" data-val='SF' @if($cond_subcategory=='VRゲーム') selected @endif>VRゲーム</option>
                <option value="宇宙" data-val='SF' @if($cond_subcategory=='宇宙') selected @endif>宇宙</option>
                <option value="空想科学" data-val='SF' @if($cond_subcategory=='空想科学') selected @endif>空想科学</option>
                <option value="パニック" data-val='SF' @if($cond_subcategory=='パニック') selected @endif>パニック</option>
                <option value="" data-val='その他'>選択されていません</option>
                <option value="童話" data-val='その他' @if($cond_subcategory=='童話') selected @endif>童話</option>
                <option value="詩" data-val='その他' @if($cond_subcategory=='詩') selected @endif>詩</option>
                <option value="エッセイ" data-val='その他' @if($cond_subcategory=='エッセイ') selected @endif>エッセイ</option>
                <option value="リプレイ" data-val='その他' @if($cond_subcategory=='リプレイ') selected @endif>リプレイ</option>
                <option value="その他" data-val='その他' @if($cond_subcategory=='その他') selected @endif>その他</option>
                <option value="" data-val='ノンジャンル'>選択されていません</option>
                <option value="ノンジャンル" data-val='ノンジャンル' @if($cond_subcategory=='ノンジャンル') selected @endif>ノンジャンル</option>
              </select>
            </div>
            <div class="col-md-2 mt-2">
              <input type="submit" class="btn btn-primary" value="検索">
            </div>
            <div class="col-md-6 mt-3 ml-auto">
              <span class="">執筆状況：</span>
              <select name="cond_end" onChange="this.form.submit()" class="">
                <option value="" selected>全ての作品を表示</option>
                <option value="1" {{$cond_end=='1'?'selected':''}}>完結済の作品だけ表示</option>
                <option value="0" {{$cond_end=='0'?'selected':''}}>完結済の作品を除外</option>
              </select>
            </div>
            <div class="col-md-5 mt-3 ml-auto">
              <span class="">並び替え：</span>
              <select name="sort" onChange="this.form.submit()" class="">
                <option value="" selected>タイトル昇順</option>
                <option value="title_d" {{$sort=='title_d'?'selected':''}}>タイトル降順</option>
                <option value="category_a" {{$sort=='category_a'?'selected':''}}>大ジャンル昇順</option>
                <option value="category_d" {{$sort=='category_d'?'selected':''}}>大ジャンル降順</option>
                <option value="s-category_a" {{$sort=='s-category_a'?'selected':''}}>小ジャンル昇順</option>
                <option value="s-category_d" {{$sort=='s-category_d'?'selected':''}}>小ジャンル降順</option>
                <option value="wasuu_a" {{$sort=='wasuu_a'?'selected':''}}>話数昇順</option>
                <option value="wasuu_d" {{$sort=='wasuu_d'?'selected':''}}>話数降順</option>
                <option value="updated_a" {{$sort=='updated_a'?'selected':''}}>最終更新日昇順</option>
                <option value="updated_d" {{$sort=='updated_d'?'selected':''}}>最終更新日降順</option>
                <option value="author_a" {{$sort=='author_a'?'selected':''}}>作者昇順</option>
                <option value="author_d" {{$sort=='author_d'?'selected':''}}>作者降順</option>
              </select>
            </div>
          </div>
        </form>
      </div>
    </div>
    @if ($cond_title != '' or $cond_name != '' or $cond_maincategory != '')
      <h6>{{ $posts->total() }} 作品がヒットしました</h6>
    @else
      <h6>全 {{ $posts->total() }} 作品</h6>
    @endif
    <div class="row">
      <div class="list-news col-md-12 mx-auto">
        <div class="row" style="border:1px solid #999999;">
          <table class="table" style="table-layout:fixed; margin-bottom:0;">
            <thead class="thead-light">
              <tr>
                <th style="width:42%; font-weight: 200;">タイトル</th>
                <th style="width:30%; font-weight: 200;">ジャンル</th>
                <th style="width:11%; font-weight: 200;">話数</th>
                <th style="width:15%; font-weight: 200;">最終更新日</th>
                <th style="width:15%; font-weight: 200;">作者</th>
              </tr>
            </thead>
            <tbody>
              @foreach($posts as $p)
                <tr>
                  <td style="word-break:break-all;"><a href="{{ url('novel/'.$p->id) }}">{{ $p->novel_title }}</a></td>
                  <td>{{ $p->novel_subcategory." [".$p->novel_maincategory."]" }}</td>
                  <td>全 {{ $p->stories()->count('sort_num') }} 話
                    @if ($p->end_check == 1)
                      <br><span class="fin">(完結済)</span>
                    @endif
                  </td>
                  <td>{{ $p->updated_at->format('Y年m月d日') }}</td>
                  <td style="word-break:break-all;">
                    <a href="{{ url('user/'.$p->user->id) }}">{{ $p->user->name }}</a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="pagination justify-content-end mt-3">
      {{ $posts->appends(['cond_title' => $cond_title, 'cond_name' => $cond_name, 'cond_maincategory' => $cond_maincategory, 'cond_subcategory' => $cond_subcategory, 'cond_end' => $cond_end, 'sort' => $sort])->links() }}
    </div>
  </div>
@endsection
