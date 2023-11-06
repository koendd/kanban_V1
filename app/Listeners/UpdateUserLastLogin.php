<?php

namespace App\Listeners;

use App\Events\UserLogin;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Http\Request;

use Carbon\Carbon;

class UpdateUserLastLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\UserLogin  $event
     * @return void
     */
    public function handle(UserLogin $event)
    {
        //dd(request());
        $event->user->last_login_at = Carbon::now()->toDateTimeString();
        $event->user->last_login_from_ip = request()->getClientIp();
        $event->user->save();
    }
}
