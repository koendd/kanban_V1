<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('manage_kanban_boards', function (User $user) {return $user->Role->can_manage_kanban_boards;});
        Gate::define('manage_kanban_content', function (User $user) {return $user->Role->can_manage_kanban_content;});
        Gate::define('manage_tasks', function (User $user) {return $user->Role->can_manage_tasks;});
        Gate::define('manage_task_logs', function (User $user) {return $user->Role->can_manage_task_logs;});
        Gate::define('use_multiple_kanban_boards', function (User $user) {return $user->Role->can_use_multiple_kanban_boards;});
    }
}
