<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $root = new User();
        $root->name = "Root";
        $root->email = "root@koendd.be";
        $root->password = Hash::make("password");
        $root->api_token = Str::random(80);
        $root->default_kanban_board_id = 1;
        $root->save();
    }
}
