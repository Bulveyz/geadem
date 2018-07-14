<nav class="navbar navbar-trans container navbar-expand-lg navbar-dark">
  <h1><a class="navbar-brand" href="#">Geadem</a></h1>

    <div class="ico navbar-toggler border-0 p-0" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false">
      <div class="toggle-icon">
        <span class="bar"></span>
        <span class="bar"></span>
        <span class="bar"></span>
      </div>
  </div>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto">
      @if(auth()->check())
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Записи
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="/threads">Все</a>
            <a class="dropdown-item" href="/threads?my=1">Мои</a>
            <a class="dropdown-item" href="/threads?popular=1">Популярные</a>
            <a class="dropdown-item" href="/threads?unpopular=1">Без ответов</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="/thread/create">Создать</a>
          </div>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Каналы
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            @foreach(\App\Channel::where('access', 'All')->get() as $channel)
              <a class="dropdown-item" href="/channel/{{$channel->slug}}">{{$channel->name}}</a>
            @endforeach
          </div>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            {{auth()->user()->name}}
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="/profile">Профиль</a>
            <a class="dropdown-item" href="/settings">Настройки</a>
            <a class="dropdown-item" href="/logout">Выйти</a>
          </div>
        </li>
        @else
        <li class="nav-item {{ (Request::is('/') ? 'active' : '') }}">
          <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="btn btn-outline-light {{ (Request::is('login') ? 'active' : '') }}" href="/login">LogIn</a>
        </li>
      @endif
    </ul>
  </div>
</nav>