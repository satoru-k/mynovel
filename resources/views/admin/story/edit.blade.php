@extends('layouts.admin')

@section('title', '物語の編集')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-8 mx-auto">
        <h2>物語編集</h2>
        <div class="row mt-3 mb-2">
          <label class="ruby-system col-md-2 pr-0" for="story_title">※ルビ機能について</label>
          <div class="col-md-10">
            <span id="text"><a class="ruby-system-link" style="vertical-align:super;" href="javascript:void(0)" onclick="changeTxt()">>>詳細を見る</a></span>
          </div>
        </div>
        <form action="{{ action('Admin\StoryController@update') }}" method="post" enctype="multipart/form-data">
          @csrf
          @if (count($errors) > 0)
            <ul class="validation">
              @foreach($errors->all() as $e)
                <li><span class="validation-message">{{ $e }}</span></li>
              @endforeach
            </ul>
          @endif
          <div class="form-group row">
            <label class="col-md-2" for="story_title">タイトル</label>
            <div class="col-md-10">
              <input type="text" class="form-control" name="story_title" placeholder="255文字以内" value="{{ $story_form->story_title }}">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-2" for="foreword">前書き(任意)</label>
            <div class="col-md-10">
              <textarea class="form-control" onkeyup="ShowLength(1);" id="inputlength-1" name="foreword" rows="3"placeholder="500文字以内">{{ $story_form->foreword }}</textarea>
              <p class="str-counter text-right mb-0"><span id="result-1">{{ mb_strlen($story_form->foreword) }}</span> / 500文字</p>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-2" for="story_body">本文</label>
            <div class="col-md-10">
              <textarea class="form-control" onkeyup="ShowLength(2);" id="inputlength-2" name="story_body" rows="20"placeholder="20000文字以内">{{ $story_form->story_body }}</textarea>
              <p class="str-counter text-right mb-0"><span id="result-2">{{ mb_strlen($story_form->story_body) }}</span> / 20000文字</p>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-2" for="afterword">後書き(任意)</label>
            <div class="col-md-10">
              <textarea class="form-control" onkeyup="ShowLength(3);" id="inputlength-3" name="afterword" rows="3" placeholder="500文字以内">{{ $story_form->afterword }}</textarea>
              <p class="str-counter text-right mb-0"><span id="result-3">{{ mb_strlen($story_form->afterword) }}</span> / 500文字</p>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-2 pr-0" for="chapter">章タイトル(任意)</label>
            <div class="col-md-10">
              <input type="text" class="form-control" name="chapter" placeholder="50文字以内" value="{{ $story_form->chapter }}">
            </div>
          </div>
          <div class="form-group row">
            <div class="col-md-12 text-right">
              <input type="hidden" name="id" value="{{ $story_form->id }}">
              <input type="submit" class="btn btn-primary" value="更新">
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@section('script')
<script type="text/javascript">
  //文字カウンター 複数箇所ver
  function ShowLength(num) {
    //入力内容を取得
    var val = document.getElementById("inputlength-" + num).value;
    //改行を2文字(++)としてカウント
    val = val.replace(/\r\n/g, "++");
    val = val.replace(/\r/g, "++");
    val = val.replace(/\n/g, "++");
    //文字数を出力
    document.getElementById("result-" + num).innerHTML = val.length;
  }

  //ルビ機能詳細
  function changeTxt() {
    document.getElementById("text").innerHTML="<p class='ruby-system'>前書き、後書き、本文では、ルビ(ふりがな)機能をご利用いただけます。<br>ルビを振りたい文字の始点に半角縦線<span class='ruby-symbol'>|</span>を入れ、終点に<span class='ruby-symbol'>〔〕</span>で囲んだルビを記入することで反映されます。</p>";
  }
</script>
@endsection
