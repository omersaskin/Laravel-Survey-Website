<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3">
      <ul class="nav flex-column">
        @if (isset($token))
          @if ($token == 'admin')
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="{{route('survey.adminIndex')}}">
                Anket Listele
              </a>
            </li>      
              <li class="nav-item">
                <a class="nav-link" aria-current="page" href="{{route('survey.create')}}">
                  Anket Oluştur
                </a>
              </li>
        @elseif($token == 'user')
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="{{route('survey.index')}}">
              Anket Listele
            </a>
          </li>
        @endif
      @endif
      </ul>
    </div>
  </nav>