<nav class="navbar navbar-expand-md navbar-dark bg-dark bg-opacity-75 fixed-top nav-border @if(env('APP_ENV') != 'production' || env('APP_DEBUG')) border-bottom border-warning border-5 @endif">
    <div class="container">
        <div class="collapse navbar-collapse" id="navbarToggler">		
			<!-- left nav section -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 nav-pills">
                @isset($kanbanBoard)
                <li class="nav-item">
                    <a class="nav-link {{Route::currentRouteName() == 'prepKanban' ? 'active' : ''}}" aria-current="page" href="{{route('prepKanban', $kanbanBoard->id)}}" title="Get the part of the kanban whose statuses are part of &quot;preparation&quot;.">Preparetion</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{Route::currentRouteName() == 'home' ? 'active' : ''}}" aria-current="page" href="{{route('home', $kanbanBoard->id)}}" title="Get the part of the kanban whose statuses are part of &quot;active&quot;.">Active</a>
                </li> 
                <li class="nav-item">
                    <a class="nav-link {{Route::currentRouteName() == 'FinishKanban' ? 'active' : ''}}" aria-current="page" href="{{route('FinishKanban', $kanbanBoard->id)}}" title="Get the part of the kanban whose statuses are part of &quot;finished&quot;.">Finishing</a>
                </li>
                @endisset
            </ul>
			
			<!-- right nav section -->
            <ul class="navbar-nav ms-auto">
                @isset($kanbanBoard)
                @can('manage_tasks')
                <li class="nav-item me-5">
                    <a class="btn btn-outline-warning {{Route::currentRouteName() == 'createTask' ? 'active' : ''}}" role="button" aria-current="page" href="{{route('createTask', $kanbanBoard->id)}}" title="Create a new task.">New task</a>
                </li>
                @endcan
                @endisset

                @if(env('APP_ENV') != 'production' || env('APP_DEBUG'))
                    <li class="nav-item" title="This applicantion is currently not in production mode!"><span class="nav-link text-warning fw-bold">TEST environment</span></li>
                @endif

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end overflow-auto" style="max-height: 90vh;" aria-labelledby="navbarDarkDropdownMenuLink">
                        @can('use_multiple_kanban_boards')
                        @if($kanbanBoardCount > 1 && Route::currentRouteName() != "welcome")
                        <li>
                            <a class="dropdown-item" href="{{ route('welcome') }}" title="Go to the home screen, here you can change the kanban board you are working in.">
                                Home
                            </a>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                        </li>
                        @endif
                        @endcan
                        @isset($kanbanBoard)
                        <li>
                            <a class="dropdown-item" href="{{ route('tasks', $kanbanBoard->id) }}" title="Get a list of all task with options to filter in these tasks.">
                                Tasks overview
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('statistics', $kanbanBoard->id) }}" title="Get statistics for the current kanban board.">
                                Statistics
                            </a>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                        </li>
                        @endif
                        <li>
                            <h5 class="dropdown-header">Configuration</h5>
                        </li>
                        @canany(['manage_kanban_boards', 'manage_kanban_content'])
                        <li>
                            <a class="dropdown-item" href="{{ route('kanbanboards') }}" title="Manage the kanban boards.">
                                Kanban boards
                            </a>
                        </li>
                        @endcanany
                        @isset($kanbanBoard)
                        <li>
                            <a class="dropdown-item" href="{{ route('statuses', $kanbanBoard->id) }}" title="Manage statuses.">
                                Statuses
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('priorities', $kanbanBoard->id) }}" title="Manage statuses.">
                                Priorities
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('systems', $kanbanBoard->id) }}" title="Manage systems and sub&#45;systems.">
                                Systems and sub&#45;systems
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('applicants', $kanbanBoard->id) }}" title="Manage applicants">
                                Applicants
                            </a>
                        </li>
                        @endisset
                        <li>
                            <div class="dropdown-divider"></div>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('customQueries') }}" title="Run custom queries">
                                Custom queries
                            </a>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('password_change') }}" title="Change your password">
                                Change password
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" title="Log out from this application">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                        </li>
                        <li>
                            <div class="dropdown-item-text">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="darkModeSwitch" checked aria-label="Switch between light and dark mode" data-bs-toggle="tooltip" data-bs-placement="top" title="Switch between light and dark mode">
                                    <label class="form-check-label" for="darkModeSwitch">Dark Mode</label>                 
                                </div>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>