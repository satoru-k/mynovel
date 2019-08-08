@extends('layouts.admin')

@section('title', 'ユーザー情報の編集')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-8 mx-auto">
        <h2>ユーザー情報編集</h2>
        <form action="{{ action('Admin\UserController@update') }}" method="post" enctype="multipart/form-data">
          @csrf
          @if (count($errors) > 0)
            <ul class="validation">
              @foreach($errors->all() as $e)
                <li><span class="validation-message">{{ $e }}</span></li>
              @endforeach
            </ul>
          @endif
          <div class="form-group row">
            <label class="col-md-2 pr-1" for="email">メールアドレス</label>
            <div class="col-md-10">
              <input type="text" class="form-control" name="email" placeholder="アドレス形式で255文字以内、かつ使用されていないアドレス" value="{{ $user_form->email }}">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-2" for="name">ユーザー名</label>
            <div class="col-md-10">
              <input type="text" class="form-control" name="name" placeholder="20文字以内" value="{{ $user_form->name }}">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-2" for="ruby">フリガナ(任意)</label>
            <div class="col-md-10">
              <input type="text" class="form-control" name="ruby" placeholder="カタカナ20文字以内" value="{{ $profile_form->ruby }}">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-2" for="gender">性別(任意)</label>
            <div class="col-md-10">
              <select class="form-control" name="gender">
                <option value="">選択されていません</option>
                <option value="男性" @if($profile_form->gender=='男性') selected @endif>男性</option>
                <option value="女性" @if($profile_form->gender=='女性') selected @endif>女性</option>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-2" for="blood">血液型(任意)</label>
            <div class="col-md-10">
              <select class="form-control" name="blood" value="">
                <option value="">選択されていません</option>
                <option value="A型" @if($profile_form->blood=='A型') selected @endif>A型</option>
                <option value="B型" @if($profile_form->blood=='B型') selected @endif>B型</option>
                <option value="O型" @if($profile_form->blood=='O型') selected @endif>O型</option>
                <option value="AB型" @if($profile_form->blood=='AB型') selected @endif>AB型</option>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-2" for="hobby">趣味(任意)</label>
            <div class="col-md-10">
              <input type="text" class="form-control" name="hobby" placeholder="100文字以内" value="{{ $profile_form->hobby }}">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-2" for="job">職業(任意)</label>
            <div class="col-md-10">
              <input type="text" class="form-control" name="job" placeholder="100文字以内" value="{{ $profile_form->job }}">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-2" for="website">WEBサイト<br>(任意)</label>
            <div class="col-md-10">
              <input type="text" class="form-control" name="website" placeholder="URL形式で100文字以内、かつ有効なURL" value="{{ $profile_form->website }}">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-2" for="introduction">自己紹介<br>(任意)</label>
            <div class="col-md-10">
              <textarea class="form-control" onkeyup="ShowLength();" id="inputlength" name="introduction" rows="10" placeholder="500文字以内">{{ $profile_form->introduction }}</textarea>
              <p class="str-counter text-right"><span id="result">{{ mb_strlen($profile_form->introduction) }}</span> / 500文字</p>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-md-12 text-right">
              <input type="hidden" name="id" value="{{ $user_form->id }}">
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
</script>
@endsection
