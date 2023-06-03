<nav class="navbar navbar-expand-md navbar-dark bg-dark bg-opacity-75 fixed-top @if(env('APP_ENV') != 'production' || env('APP_DEBUG')) border-bottom border-warning border-5 @endif">
    <div class="container">
        <div class="collapse navbar-collapse" id="navbarToggler">		
			<!-- left nav section -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 nav-pills">
            <li class="nav-item">
                    <a class="nav-link {{Route::currentRouteName() == 'prepKanban' ? 'active' : ''}}" aria-current="page" href="{{route('prepKanban')}}">Preparetion</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{Route::currentRouteName() == 'home' ? 'active' : ''}}" aria-current="page" href="{{route('home')}}">Active</a>
                </li> 
                <li class="nav-item">
                    <a class="nav-link {{Route::currentRouteName() == 'FinishKanban' ? 'active' : ''}}" aria-current="page" href="{{route('FinishKanban')}}">Finishing</a>
                </li>
            </ul>
			
			<!-- right nav section -->
            <ul class="navbar-nav">
                <li class="nav-item me-5">
                    <a class="btn btn-outline-warning {{Route::currentRouteName() == 'createTask' ? 'active' : ''}}" role="button" aria-current="page" href="{{route('createTask')}}">New task</a>
                </li>

                @if(env('APP_ENV') != 'production' || env('APP_DEBUG'))
                    <li class="nav-item"><span class="nav-link text-warning fw-bold">TEST environment</span></li>
                @endif

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end overflow-auto" style="max-height: 90vh;" aria-labelledby="navbarDarkDropdownMenuLink">
                        <li>
                            <a class="dropdown-item" href="{{ route('systems') }}">
                                Systems and sub&#45;systems
                            </a>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                        </li>
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