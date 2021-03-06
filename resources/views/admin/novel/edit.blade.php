@extends('layouts.admin')

@section('title', '小説の編集')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-8 mx-auto">
        <h2>小説編集</h2>
        <form action="{{ action('Admin\NovelController@update') }}" method="post" enctype="multipart/form-data">
          @csrf
          @if (count($errors) > 0)
            <ul class="validation">
              @foreach($errors->all() as $e)
                <li><span class="validation-message">{{ $e }}</span></li>
              @endforeach
            </ul>
          @endif
          <div class="form-group row">
            <div class="col-md-12 text-right">
              <input type="hidden" name="end_check" value="">
              <input type="checkbox" name="end_check" value="1" @if($novel_form->end_check=='1') checked @endif>
              <span>完結済</span>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-2" for="novel_title">タイトル</label>
            <div class="col-md-10">
              <input type="text" class="form-control" name="novel_title" placeholder="255文字以内" value="{{ $novel_form->novel_title }}">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-2" for="novel_maincategory">大ジャンル</label>
            <div class="col-md-10">
              <select class="parent form-control" name="novel_maincategory" value="">
                <option value="" selected="selected">選択されていません</option>
                <option value="ファンタジー" @if($novel_form->novel_maincategory=='ファンタジー') selected @endif>ファンタジー</option>
                <option value="恋愛" @if($novel_form->novel_maincategory=='恋愛') selected @endif>恋愛</option>
                <option value="文芸" @if($novel_form->novel_maincategory=='文芸') selected @endif>文芸</option>
                <option value="SF" @if($novel_form->novel_maincategory=='SF') selected @endif>SF</option>
                <option value="その他" @if($novel_form->novel_maincategory=='その他') selected @endif>その他</option>
                <option value="ノンジャンル" @if($novel_form->novel_maincategory=='ノンジャンル') selected @endif>ノンジャンル</option>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-2" for="novel_subcategory">小ジャンル</label>
            <div class="col-md-10">
              <select class="children form-control" name="novel_subcategory" value="" id="novel_subcategory" disabled>
                <option value="" selected="selected">選択されていません</option>
                <option value="ハイファンタジー" data-val='ファンタジー' @if($novel_form->novel_subcategory=='ハイファンタジー') selected @endif>ハイファンタジー</option>
                <option value="ローファンタジー" data-val='ファンタジー' @if($novel_form->novel_subcategory=='ローファンタジー') selected @endif>ローファンタジー</option>
                <option value="異世界" data-val='恋愛' @if($novel_form->novel_subcategory=='異世界') selected @endif>異世界</option>
                <option value="現実世界" data-val='恋愛' @if($novel_form->novel_subcategory=='現実世界') selected @endif>現実世界</option>
                <option value="純文学" data-val='文芸' @if($novel_form->novel_subcategory=='純文学') selected @endif>純文学</option>
                <option value="ヒューマンドラマ" data-val='文芸' @if($novel_form->novel_subcategory=='ヒューマンドラマ') selected @endif>ヒューマンドラマ</option>
                <option value="歴史" data-val='文芸' @if($novel_form->novel_subcategory=='歴史') selected @endif>歴史</option>
                <option value="推理" data-val='文芸' @if($novel_form->novel_subcategory=='推理') selected @endif>推理</option>
                <option value="ホラー" data-val='文芸' @if($novel_form->novel_subcategory=='ホラー') selected @endif>ホラー</option>
                <option value="アクション" data-val='文芸' @if($novel_form->novel_subcategory=='アクション') selected @endif>アクション</option>
                <option value="コメディー" data-val='文芸' @if($novel_form->novel_subcategory=='コメディー') selected @endif>コメディー</option>
                <option value="VRゲーム" data-val='SF' @if($novel_form->novel_subcategory=='VRゲーム') selected @endif>VRゲーム</option>
                <option value="宇宙" data-val='SF' @if($novel_form->novel_subcategory=='宇宙') selected @endif>宇宙</option>
                <option value="空想科学" data-val='SF' @if($novel_form->novel_subcategory=='空想科学') selected @endif>空想科学</option>
                <option value="パニック" data-val='SF' @if($novel_form->novel_subcategory=='パニック') selected @endif>パニック</option>
                <option value="童話" data-val='その他' @if($novel_form->novel_subcategory=='童話') selected @endif>童話</option>
                <option value="詩" data-val='その他' @if($novel_form->novel_subcategory=='詩') selected @endif>詩</option>
                <option value="エッセイ" data-val='その他' @if($novel_form->novel_subcategory=='エッセイ') selected @endif>エッセイ</option>
                <option value="リプレイ" data-val='その他' @if($novel_form->novel_subcategory=='リプレイ') selected @endif>リプレイ</option>
                <option value="その他" data-val='その他' @if($novel_form->novel_subcategory=='その他') selected @endif>その他</option>
                <option value="ノンジャンル" data-val='ノンジャンル' @if($novel_form->novel_subcategory=='ノンジャンル') selected @endif>ノンジャンル</option>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-2" for="novel_introduction">あらすじ</label>
            <div class="col-md-10">
              <textarea class="form-control" onkeyup="ShowLength();" id="inputlength" name="novel_introduction" rows="20" placeholder="500文字以内">{{ $novel_form->novel_introduction }}</textarea>
              <p class="str-counter text-right mb-0"><span id="result">{{ mb_strlen($novel_form->novel_introduction) }}</span> / 500文字</p>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-md-12 text-right">
              <input type="hidden" name="id" value="{{ $novel_form->id }}">
              <input type="submit" class="btn btn-primary" value="更新" onclick="undisabled();">
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@section('script')
<script type="text/javascript">
  //文字カウンター
  function ShowLength( str ) {
    //入力内容を取得
    var val = document.getElementById("inputlength").value;
    //改行を2文字(++)としてカウント
    val = val.replace(/\r\n/g, "++");
    val = val.replace(/\r/g, "++");
    val = val.replace(/\n/g, "++");
    //文字数を出力
    document.getElementById("result").innerHTML = val.length;
  }

  //送信直前にdisabledを解除
  function undisabled()
  {
    document.getElementById("novel_subcategory").disabled = false ;
    return true;
  }
</script>
@endsection
