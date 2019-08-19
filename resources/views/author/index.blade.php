@extends('layouts.adminC')

@section('title', 'ユーザー一覧')

@section('content')
  <div class="container">
    <div class="row">
      <h2>ユーザー一覧</h2>
      <div class="col-md-6 ml-auto">
        <form action="{{ action('AuthorController@index') }}" method="get">
          @csrf
          <div class="form-group row">
            <div class="col-md-10">
              <input type="text" class="form-control" name="cond_name" value="{{ $cond_name }}" placeholder="ユーザー名を入力してください">
            </div>
            <div class="col-md-2">
              <input type="submit" class="btn btn-primary" value="検索">
            </div>
            <div class="col-md-7 mt-3 ml-auto">
              <span class="">投稿状況：</span>
              <select name="cond_work" onChange="this.form.submit()" class="">
                <option value="" selected>全てのユーザーを表示</option>
                <option value="1" {{$cond_work=='1'?'selected':''}}>投稿作品のないユーザーを除外</option>
                <option value="0" {{$cond_work=='0'?'selected':''}}>投稿作品があるユーザーを除外</option>
              </select>
            </div>
            <div class="col-md-5 mt-3 ml-auto">
              <span class="">並び替え：</span>
              <select name="sort" onChange="this.form.submit()" class="">
                <option value="" selected>ユーザー名昇順</option>
                <option value="name_d" {{$sort=='name_d'?'selected':''}}>ユーザー名降順</option>
                <option value="id_a" {{$sort=='id_a'?'selected':''}}>ユーザーID昇順</option>
                <option value="id_d" {{$sort=='id_d'?'selected':''}}>ユーザーID降順</option>
                <option value="work_a" {{$sort=='work_a'?'selected':''}}>投稿作品数昇順</option>
                <option value="work_d" {{$sort=='work_d'?'selected':''}}>投稿作品数降順</option>
                <option value="end_a" {{$sort=='end_a'?'selected':''}}>完結済数昇順</option>
                <option value="end_d" {{$sort=='end_d'?'selected':''}}>完結済数降順</option>
                <option value="updated_a" {{$sort=='updated_a'?'selected':''}}>最終更新日昇順</option>
                <option value="updated_d" {{$sort=='updated_d'?'selected':''}}>最終更新日降順</option>
              </select>
            </div>
          </div>
        </form>
      </div>
    </div>
    @if ($cond_name != '')
      <h6>{{ $posts->total() }} 名がヒットしました</h6>
    @else
      <h6>全 {{ $posts->total() }} 名</h6>
    @endif
    <div class="row">
      <div class="list-news col-md-12 mx-auto">
        <div class="row" style="border:1px solid #999999;">
          <table class="table" style="table-layout:fixed; margin-bottom:0;">
            <thead class="thead-light">
              <tr>
                <th style="width:10%; font-weight: 200;">ユーザーID</th>
                <th style="width:42%; font-weight: 200;">ユーザー名</th>
                <th style="width:15%; font-weight: 200;">投稿作品</th>
                <th style="width:15%; font-weight: 200;">完結済</th>
                <th style="width:15%; font-weight: 200;">最終更新日</th>
              </tr>
            </thead>
            <tbody>
              @foreach($posts as $p)
                <tr>
                  <td>{{ $p->id }}</td>
                  <td><a href="{{ url('user/'.$p->id) }}">{{ str_limit($p->name, 50) }}</a></td>
                  <td>全 {{ $p->novels()->count() }} 作品</td>
                  <td>{{ $p->novels()->count('end_check', '1') }} 作品</td>
                  @if ($p->novels()->count('updated_at') > 0)
                    <td>{{ $p->updated_at->format('Y年m月d日') }}</td>
                  @else
                    <td>-</td>
                  @endif
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="pagination justify-content-end mt-3">
      {{ $posts->appends(['cond_name' => $cond_name, 'cond_work' => $cond_work, 'sort' => $sort])->links() }}
    </div>
  </div>
@endsection
