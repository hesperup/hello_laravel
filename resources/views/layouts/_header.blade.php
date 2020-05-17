<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
    <a class="navbar-brand" href="/">Weibo App</a>
      <ul class="navbar-nav justify-content-end">
        @if (Auth::check())
        <li class="nav-item"><a class="nav-link" href="#">用户列表</a></li>
        <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="butt
        {{ Auth::user()->name }}
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="{{ route('users.show', Auth::user()) }}">个
        <a class="dropdown-item" href="#">编辑资料</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" id="logout" href="#">
        <form action="{{ route('logout') }}" method="POST">
        {{ csrf_field() }}
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="{{ route('users.show', Auth::user()) }}">个
        <a class="dropdown-item" href="#">编辑资料</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" id="logout" href="#">
        <form action="{{ route('logout') }}" method="POST">
        {{ csrf_field() }}
        {{ method_field('DELETE') }}
        <button class="btn btn-block btn-danger" type="submit" name="button">
        </form>
        </a>
        </div>
        </li>
        @else
        <li class="nav-item"><a class="nav-link" href="{{ route('help') }}">帮助</a><
        <li class="nav-item" ><a class="nav-link" href="{{ route('login') }}">登录</a
        @endif
      </ul>
    </div>
</nav>