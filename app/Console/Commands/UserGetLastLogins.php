<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\User;

class UserGetLastLogins extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:get-last-logins';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display all users and the time and ip from there last login.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = User::select(["name", "last_login_at", "last_login_from_ip"])->orderBy("name", "asc")->get();

        $this->table(
            ["Name", "Last login at", "Last login from ip"],
            $users
        );
        return 0;
    }
}
