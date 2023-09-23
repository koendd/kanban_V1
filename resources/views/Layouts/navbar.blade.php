<nav class="navbar navbar-expand-md navbar-dark bg-dark bg-opacity-75 fixed-top @if(env('APP_ENV') != 'production' || env('APP_DEBUG')) border-bottom border-warning border-5 @endif">
    <div class="container">
        <div class="collapse navbar-collapse" id="navbarToggler">		
			<!-- left nav section -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 nav-pills">
                @isset($kanbanBoard)
                <li class="nav-item">
                    <a class="nav-link {{Route::currentRouteName() == 'prepKanban' ? 'active' : ''}}" aria-current="page" href="{{route('prepKanban', $kanbanBoard->id)}}">Preparetion</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{Route::currentRouteName() == 'home' ? 'active' : ''}}" aria-current="page" href="{{route('home', $kanbanBoard->id)}}">Active</a>
                </li> 
                <li class="nav-item">
                    <a class="nav-link {{Route::currentRouteName() == 'FinishKanban' ? 'active' : ''}}" aria-current="page" href="{{route('FinishKanban', $kanbanBoard->id)}}">Finishing</a>
                </li>
                @endisset
            </ul>
			
			<!-- right nav section -->
            <ul class="navbar-nav">
                @isset($kanbanBoard)
                <li class="nav-item me-5">
                    <a class="btn btn-outline-warning {{Route::currentRouteName() == 'createTask' ? 'active' : ''}}" role="button" aria-current="page" href="{{route('createTask', $kanbanBoard->id)}}">New task</a>
                </li>
                @endisset

                @if(env('APP_ENV') != 'production' || env('APP_DEBUG'))
                    <li class="nav-item"><span class="nav-link text-warning fw-bold">TEST environment</span></li>
                @endif

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end overflow-auto" style="max-height: 90vh;" aria-labelledby="navbarDarkDropdownMenuLink">
                        @if($kanbanBoardCount > 1)
                        <li>
                            <a class="dropdown-item" href="{{ route('welcome') }}">
                                Kanban boards
                            </a>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                        </li>
                        @endif
                        @isset($kanbanBoard)
                        <li>
                            <a class="dropdown-item" href="{{ route('tasks', $kanbanBoard->id) }}">
                                Tasks overview
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('systems', $kanbanBoard->id) }}">
                                Systems and sub&#45;systems
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('applicants', $kanbanBoard->id) }}">
                                Applicants
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('statistics', $kanbanBoard->id) }}">
                                Statistics
                            </a>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                        </li>
                        @endisset
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>