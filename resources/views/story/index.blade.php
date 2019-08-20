@extends('layouts.admin')

@section('title')
{{ $title }}
@stop

@section('content')
  <div class="container">
    <div class="text-right" id="go-bottom">
      <a class="scroll-button" href="#bottom">↓Go to Bottom</a>
    </div>
    <div class="row">
      <div class="col-md-8 mx-auto mb-3 clearfix">
        @auth
          @if ($bookmark->story_num != null)
            <span class="marking mr-2">§</span><a href="{{ url('novel/'.$novel_id.'/story/'.$bookmark->story_num) }}">続き({{$bookmark->story_num}}ページ目)から読む</a>
          @endif

          @if (($id) === (Auth::user()->id))
            <a href="{{ action('Admin\StoryController@add', ['id' => $novel_id]) }}" role="button" class="float-right btn btn-primary">物語投稿</a>
          @elseif ($bookmark->novel_id != null)
            <a onclick="return cancel()" href="{{ action('Admin\BookmarkController@cancel', ['id' => $novel_id]) }}" role="button" class="float-right btn btn-outline-danger">ブックマーク解除</a>
          @else
            <a onclick="return bookmark()" href="{{ action('Admin\BookmarkController@bookmark', ['id' => $novel_id]) }}" role="button" class="float-right btn btn-outline-success">ブックマーク登録</a>
          @endif
        @endauth
      </div>
    </div>
    <div class="row">
      <div class="title col-md-6 mx-auto mt-3">
        <h1 class="text-center">{{ $title }}</h1>
      </div>
    </div>
    <div class="row">
      <div class="col-md-8 mx-auto my-3">
        <div class="text-right">
          <p class="author">作者：<a href="{{ url('user/'.$id) }}">{{ str_limit($name, 50) }}</a></p>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="introduction col-md-8 mx-auto mb-3">
        <p>{!! nl2br(e($introduction)) !!}</p>
      </div>
    </div>
    <div class="row">
      <div class="col-md-8 mx-auto">
        <div class="row">
          <table class="table table-hover" style="table-layout:fixed; font-size:16px;">
            <tbody>
              @foreach($posts as $p)
                @if ($p->chapter != null && $p->sort_num == 1)
                  <tr class="chapter" style="pointer-events:none;">
                    <td style="width:200px; font-size:105%; font-weight:bold; word-break: break-all;">{{ $p->chapter }}</td>
                    <td style="width:60px;"></td>
                    @auth
                      @if (($p->user_id) === (Auth::user()->id))
                        <td style="width:10px;"></td>
                      @endif
                    @endauth
                  </tr>
                @elseif ($p->chapter != null)
                  <tr class="chapter" style="pointer-events:none;">
                    <td style="width:200px; font-size:105%; font-weight:bold; word-break: break-all; border-style:none; padding-top:30px;">{{ $p->chapter }}</td>
                  </tr>
                @endif
                <tr>
                  <td class="story" style="width:200px; word-break: break-all;"><a href="{{ url('novel/'.$novel_id.'/story/'.$p->sort_num) }}">{{ $p->story_title }}</a>@if ($bookmark->story_num == $p->sort_num)<span class="marking ml-2">§</span>@endif</td>
                  <td style="width:60px;">{{ $p->updated_at->format('Y/m/d H:i') }}</td>
                  @auth
                    @if (($p->user_id) === (Auth::user()->id))
                      <td style="width:10px;">
                        <div>
                          <a href="{{ action('Admin\StoryController@edit', ['id' => $p->id]) }}">編集</a>
                        </div>
                        <div>
                          <a onclick="return click_alert()" href="{{ action('Admin\StoryController@delete', ['id' => $p->id]) }}">削除</a>
                        </div>
                      </td>
                    @endif
                  @endauth
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="text-right" id="back-top">
      <a class="scroll-button" href="#top" style="bottom:25px;">↑Back to Top</a>
    </div>
  </div>
@endsection

@section('script')
<script type="text/javascript">
  //確認メッセージ
  function click_alert() {
    if (window.confirm("本当にこの話を削除しますか？")) {
      return true;
    } else {
      <!-- window.alert('キャンセルされました'); -->
      return false;
    }
  }
  function cancel() {
    if (window.confirm("この小説をブックマークから外しますか？")) {
      return true;
    } else {
      return false;
    }
  }
  function bookmark() {
    if (window.confirm("この小説をブックマークに追加しますか？")) {
      return true;
    } else {
      return false;
    }
  }
</script>
@endsection
