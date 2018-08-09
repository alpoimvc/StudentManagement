<nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Student Management System') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- links da navbar. Os links são diferentes dependendo
                    do utilizador que está autenticado -->
                    <ul class="navbar-nav mr-auto">
                     @if( auth()->check() ) 
                     @if(Auth::user()->type == 'admin')
                     <li class="nav-item">
                     <a class="nav-link" href="/gerirAlunos"><span>Alunos</span></a>
                     </li>
                     <li class="nav-item">
                     <a class="nav-link" href="/gerirCadeiras"><span>Cadeiras</span></a>
                     </li>
                     <li class="nav-item">
                     <a class="nav-link" href="/gerirAvaliacoes"><span>Avaliações</span></a>
                     </li>
                     <li class="nav-item">
                     <a class="nav-link" href="/gerirHorarios"><span>Horários</span></a>
                     </li>
                     <li class="nav-item">
                     <a class="nav-link" href="/consultarTrabalhos"><span>Trabalhos</span></a>
                     </li>
                     @endif
                     @if(Auth::user()->type == 'aluno')
                     <li class="nav-item">
                     <a class="nav-link" href="/consultarCadeiras"><span>Consultar Cadeiras</span></a>
                     </li>
                     <li class="nav-item">
                     <a class="nav-link" href="/consultarAvaliacoes"><span>Consultar Avaliações</span></a>
                     </li>
                     <li class="nav-item">
                     <a class="nav-link" href="/consultarHorario"><span>Consultar Horário</span></a>
                     </li>
                     <li class="nav-item">
                     <a class="nav-link" href="/submeterTrabalho"><span>Submeter Trabalhos</span></a>
                     </li>
                     @endif
                     @endif
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
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
