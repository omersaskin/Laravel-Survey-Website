@if (Auth::check())
  <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="{{route('survey.index')}}">Anketor</a>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    @if ($token == "user")
      <form action="{{route('searchUser')}}" method="POST" class="w-100">
        @csrf
        <input class="form-control form-control-dark w-100" type="text" name="arama" placeholder="Kullanıcı Ara" aria-label="Search">
      </form>
      @elseif($token == "admin")
        <form action="{{route('searchAdmin')}}" method="POST" class="w-100">
          @csrf
          <input class="form-control form-control-dark w-100" type="text" name="arama" placeholder="Kullanıcı Ara" aria-label="Search">
        </form>
    @endif
    <ul class="navbar-nav px-3">
      <li class="nav-item text-nowrap">
        <a class="nav-link" href="{{route('signout')}}">Çıkış</a>
      </li>
    </ul>
  </header>
@endif