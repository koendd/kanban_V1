<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Priority;

class PrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $high = new Priority();
        $high->name = "High";
        $high->description = "These tasks shoud be carried out as soon as possible!";
        $high->order_number = 1;
        $high->color = 0xFF0000;
        $high->kanban_board_id = 1;
        $high->save();

        $medium = new Priority();
        $medium->name = "Medium";
        $medium->description = "These tasks are important but not urgent!";
        $medium->order_number = 2;
        $medium->color = 0xFFA500; 
        $medium->kanban_board_id = 1;
        $medium->save();

        $low = new Priority();
        $low->name = "Low";
        $low->description = "These tasks are not urgent!";
        $low->order_number = 3;
        $low->color = 0x3CB371;
        $low->kanban_board_id = 1;
        $low->save();
    }
}
