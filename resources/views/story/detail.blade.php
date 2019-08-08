@extends('layouts.admin')

@section('title')
{{ $posts->story_title }}
@stop

@section('content')
  <div class="container">
    <div class="text-right" id="go-bottom">
      <a class="scroll-button" href="#bottom">↓Go to Bottom</a>
    </div>
    <div class="row">
      <div class="col-md-8 mx-auto">
        <a href="{{ url('novel/'.$n->id) }}" class="mr-4" style="word-wrap:break-word;">{{ $n->novel_title }}</a>
        作者：<a href="{{ url('user/'.$n->user_id) }}">{{ $n->user->name }}</a>
        @if ($posts->chapter != null)
          <p class="mb-0">{{ $posts->chapter }}</p>
        @elseif ($ch != null)
          <p class="mb-0">{{ $ch->chapter }}</p>
        @endif
      </div>
    </div>
    <div class="row">
      <div class="col-md-8 mx-auto clearfix">
        @auth
          @if ($book->story_num == $posts->sort_num)
            <a onclick="return cancel()" href="{{ action('Admin\BookmarkController@noMarking', ['n' => $n->id, 's' => $posts->sort_num]) }}" role="button" class="float-right mt-3 btn btn-outline-secondary">しおりを解除する</a>
          @elseif ($book->novel_id != null)
            <a onclick="return bookmark()" href="{{ action('Admin\BookmarkController@marking', ['n' => $n->id, 's' => $posts->sort_num]) }}" role="button" class="float-right mt-3 btn btn-outline-secondary">しおりを挿む</a>
          @endif
        @endauth
      </div>
    </div>
    <div class="row">
      <div class="col-md-10 mt-3">
        <p class="text-right">{{ $posts->sort_num }} / {{ $max }}</p>
      </div>
    </div>
    <div class="row mb-1">
      <div class="col-md-6 mx-auto text-center">
        @if ($posts->sort_num != 1)
        <a rel="prev" href="{{$posts->sort_num-1}}" class="mr-3"><<&nbsp;前へ</a>
        @endif
        @if ($posts->sort_num != $max)
        <a rel="next" href="{{$posts->sort_num+1}}" class="mr-3">次へ&nbsp;>></a>
        @endif
      </div>
    </div>
    <div class="row">
      <div class="title col-md-6 mx-auto mt-3">
        <h1 class="text-center">{{ $posts->story_title }}</h1>
      </div>
    </div>
    <div class="row mt-4">
      <div class="s-text col-md-8 mx-auto" style="line-height:30px; font-size:16px;">
        @if ($posts->foreword)
          <p class="p-3"><?php echo $posts->foreword; ?></p>
          <hr color="#c0c0c0">
        @endif
        <p class="p-3"><?php echo $posts->story_body; ?></p>
        @if ($posts->afterword)
          <hr color="#c0c0c0">
          <p class="p-3"><?php echo $posts->afterword; ?></p>
        @endif
      </div>
    </div>
    <div class="row">
      <div class="col-md-6 mx-auto text-center">
        @if ($posts->sort_num != 1)
        <a rel="prev" href="{{$posts->sort_num-1}}" class="mr-3"><<&nbsp;前へ</a>
        @endif
        @if ($posts->sort_num != $max)
        <a rel="next" href="{{$posts->sort_num+1}}" class="mr-3">次へ&nbsp;>></a>
        @endif
        <a href="{{ url('novel/'.$n->id) }}">目次</a>
      </div>
    </div>
    <div class="text-right" id="back-top">
      <a class="scroll-button" href="#top" style="bottom:25px;">↑Back to Top</a>
    </div>
  </div>
@endsection
