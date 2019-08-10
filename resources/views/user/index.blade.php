@extends('layouts.adminC')

@section('title')
{{ $name }} さんのページ
@stop

@section('content')
  <div class="container">
    <div class="row">
      <h2>{{ $name }} さんのページ</h2>
      @auth
        @if (($id) === (Auth::user()->id))
          <div class="ml-auto">
            <a href="{{ action('Admin\NovelController@add') }}" role="button" class="btn btn-primary">小説作成</a>
          </div>
        @endif
      @endauth
    </div>
    <h6 class="mt-2">投稿作品<span class="ml-3">全 {{ $posts->total() }} 作品</span></h6>
    <div class="row">
      <div class="list-news col-md-12 mx-auto">
        <div class="row" style="border:1px solid #999999;">
          <table class="table" style="table-layout:fixed; margin-bottom:0; font-size:16px;">
            @if ($posts->total() != 0)
            <thead class="thead-light">
              <tr>
                <th style="width:50%; font-weight: 200;">タイトル</th>
                <th style="width:30%; font-weight: 200;">ジャンル</th>
                <th style="width:11%; font-weight: 200;">話数</th>
                <th style="width:15%; font-weight: 200;">最終更新日</th>
                @auth
                  @if (($id) === (Auth::user()->id))
                    <th style="width:7%;">
                    </th>
                  @endif
                @endauth
              </tr>
            </thead>
            @endif
            <tbody>
              @if ($posts->total() == 0)
                <tr>
                  <td style="color:#999999;">投稿作品はありません</td>
                </tr>
              @else
              @foreach($posts as $p)
                <tr>
                  <td style="word-break:break-all;"><a href="{{ url('novel/'.$p->id) }}">{{ str_limit($p->novel_title, 510) }}</a></td>
                  <td>{{ $p->novel_subcategory." [".$p->novel_maincategory."]" }}</td>
                  @if ($p->stories()->max('sort_num') != null)
                    <td>全 {{ $p->stories()->max('sort_num') }} 話@if ($p->end_check == 1)<br><span class="fin">(完結済)</span>@endif</td>
                  @else
                    <td>全 0 話@if ($p->end_check == 1)<br><span  class="fin">(完結済)</span>@endif</td>
                  @endif
                  <td>{{ $p->updated_at->format('Y年m月d日') }}</td>

                  @auth
                    @if (($p->user_id) === (Auth::user()->id))
                      <td>
                        <div>
                          <a href="{{ action('Admin\NovelController@edit', ['id' => $p->id]) }}">編集</a>
                        </div>
                        <div>
                          <a onclick="return click_alert()" href="{{ action('Admin\NovelController@delete', ['id' => $p->id]) }}">削除</a>
                        </div>
                      </td>
                    @endif
                  @endauth

                </tr>
              @endforeach
              @endif
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="pagination justify-content-end mt-3">
      {{ $posts->links() }}
    </div>
    <h6 class="mt-2">ブックマーク<span class="ml-3">全 {{ $bookmarks->total() }} 作品</span></h6>
    <div class="row">
      <div class="col-md-12 mx-auto">
        <div class="row" style="border:1px solid #999999;">
          <table class="table" style="table-layout:fixed; margin-bottom:0; font-size:16px;">
            @if (count($bookmarks) != 0)
            <thead class="thead-light">
              <tr>
                <th style="width:50%; font-weight: 200;">タイトル</th>
                <th style="width:30%; font-weight: 200;">ジャンル</th>
                <th style="width:11%; font-weight: 200;">話数</th>
                <th style="width:15%; font-weight: 200;">最終更新日</th>
                @auth
                  @if (($id) === (Auth::user()->id))
                    <th style="width:7%;">
                    </th>
                  @endif
                @endauth
              </tr>
            </thead>
            @endif
            <tbody>
              @if (count($bookmarks) == 0)
                <tr>
                  <td style="color:#999999;">ブックマークは登録されていません</td>
                </tr>
              @else
              @foreach($bookmarks as $b)
                <tr>
                  <td style="word-break:break-all;"><a href="{{ url('novel/'.$b->novel->id) }}">{{ $b->novel->novel_title }}</a><span class="ml-2">(<a href="{{ url('user/'.$b->novel->user_id) }}">{{ $b->novel->user->name }}</a>)</span></td>
                  <td>{{ $b->novel->novel_subcategory." [".$b->novel->novel_maincategory."]" }}</td>
                  @if ($b->novel->stories()->max('sort_num') != null)
                    <td>全 {{ $b->novel->stories()->max('sort_num') }} 話@if ($b->novel->end_check == 1)<br><span class="fin">(完結済)</span>@endif</td>
                  @else
                    <td>全 0 話@if ($b->novel->end_check == 1)<br><span class="fin">(完結済)</span>@endif</td>
                  @endif
                  <td>{{ $b->novel->updated_at->format('Y年m月d日') }}</td>
                  @auth
                    @if (($id) === (Auth::user()->id))
                      <td>
                      </td>
                    @endif
                  @endauth
                </tr>
              @endforeach
              @endif
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="pagination justify-content-end mt-3">
      {{ $bookmarks->links() }}
    </div>
    <div class="row mt-3">
      <div class="col-md-7 mx-auto">
        <div class="row">
          <table class="table table-bordered" style="word-break:break-all; font-size:16px;">
            <tr>
              <td width="30%">ユーザーID</td>
              <td>{{ $user->id }}</td>
            </tr>
            <tr>
              <td>ユーザー名</td>
              <td>{{ $name }}</td>
            </tr>
            @if ($profile->ruby != null)
              <tr>
                <td>フリガナ</td>
                <td>{{ $profile->ruby }}</td>
              </tr>
            @endif
            @if ($profile->gender != null)
              <tr>
                <td>性別</td>
                <td>{{ $profile->gender }}</td>
              </tr>
            @endif
            @if ($profile->blood != null)
              <tr>
                <td>血液型</td>
                <td>{{ $profile->blood }}</td>
              </tr>
            @endif
            @if ($profile->hobby != null)
              <tr>
                <td>趣味</td>
                <td>{{ $profile->hobby }}</td>
              </tr>
            @endif
            @if ($profile->job != null)
              <tr>
                <td>職業</td>
                <td>{{ $profile->job }}</td>
              </tr>
            @endif
            @if ($profile->website != null)
              <tr>
                <td>WEBサイト</td>
                <td><a href="{{ $profile->website }}">{{ $profile->website }}</a></td>
              </tr>
            @endif
            @if ($profile->introduction != null)
              <tr>
                <td>自己紹介</td>
                <td>{!! nl2br(e($profile->introduction)) !!}</td>
              </tr>
            @endif
          </table>
          @auth
              @if (($user->id) === (Auth::user()->id))
                <div class="ml-auto">
                  <a href="{{ action('Admin\UserController@edit', ['id' => $user->id]) }}">ユーザー情報編集</a>
                </div>
              @endif
          @endauth
        </div>
      </div>
    </div>
    <div class="row">
      @auth
        @if (($id) === (Auth::user()->id))
          <div class="ml-auto">
            <a onclick="return account_alert()" href="{{ action('Admin\UserController@delete', ['id' => $user->id]) }}" role="button" class="btn btn-outline-danger">退会する</a>
          </div>
        @endif
      @endauth
    </div>
  </div>
@endsection

@section('script')
<script type="text/javascript">
  //確認メッセージ
  function click_alert() {
    if (window.confirm("本当にこの小説を削除しますか？")) {
      return true;
    } else {
      <!-- window.alert('キャンセルされました'); -->
      return false;
    }
  }
  function account_alert() {
    if (window.confirm("本当に退会しますか？\n({{ $name }} さんが投稿した小説は全て消去されます)")) {
      return true;
    } else {
      <!-- window.alert('キャンセルされました'); -->
      return false;
    }
  }
</script>
@endsection
