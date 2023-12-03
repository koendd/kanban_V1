<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Output\OutputInterface;
use Illuminate\Support\Str;

use App\Models\User;

class UserUpdateApiTokens extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:update-api-tokens';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the api tokens for all users';

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
        $verbosityLevel = $this->getOutput()->getVerbosity();

        if($verbosityLevel >= OutputInterface::VERBOSITY_VERBOSE){
            $this->newLine();
            $this->warn("\t###########################");
            $this->warn("\t# Running in verbose mode #");
            $this->warn("\t###########################");
            $this->newLine();
        }

        $users = User::get();
        foreach($users as $u) {
            $user = User::find($u->id);

            if($verbosityLevel >= OutputInterface::VERBOSITY_VERBOSE){
                $this->line("Updating API-token for user: " . $user->name);
            }
            
            $user->api_token = Str::random(80);
            $user->save();
        }

        
        if($verbosityLevel >= OutputInterface::VERBOSITY_VERBOSE){
            $this->newLine();
            $this->info("All API-tokens are renewed!");
            $this->newLine();
        }

        return 0;
    }
}
