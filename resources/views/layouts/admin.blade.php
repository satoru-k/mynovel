<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Scripts -->
     {{-- Laravel標準で用意されているJavascriptを読み込む --}}
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    {{-- Laravel標準で用意されているCSSを読み込む --}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    {{-- 自作したCSSを読み込む --}}
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">

    <!-- favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}">

  </head>
  <body>
    <div id="app">
      {{-- 画面上部に表示するナビゲーションバー --}}
      <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <div class="container">
          <a class="navbar-brand" href="{{ url('/') }}">
            <h3 class="">小説家になりたい気がする</h3>
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
              @auth
                <li class="nav-item"><a class="nav-link mr-2" href="{{ url('user/'.Auth::user()->id) }}">マイページ</a></li>
              @else
                <li class="nav-item"><a class="nav-link mr-2" href="{{ url('login') }}">マイページ</a></li>
              @endauth
              <li class="nav-item"><a class="nav-link mr-2" href="{{ url('title') }}">投稿作品一覧</a></li>
              <li class="nav-item"><a class="nav-link mr-2" href="{{ url('author') }}">ユーザー一覧</a></li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
              <a class="nav-link mr-2" href="{{ route('register') }}">{{ __('messages.Register') }}</a>
              {{-- ログインしていなかったらログイン画面へのリンクを表示 --}}
              @guest
                <li><a class="nav-link" href="{{ route('login') }}">{{ __('messages.Login') }}</a></li>
              {{-- ログインしていたらユーザー名とログアウトボタンを表示 --}}
              @else
                <li class="nav-item dropdown">
                  <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::user()->name }} <span class="caret"></span>
                  </a>

                  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                      {{ __('messages.Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      @csrf
                    </form>
                  </div>
                </li>
              @endguest
            </ul>
          </div>
        </div>
      </nav>
      {{-- ここまでナビゲーションバー --}}

      <main class="py-4">
        @yield('content')
      </main>
    </div>

    @yield('script')
  </body>
</html>
