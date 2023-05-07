<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\KanbanBoard;

class KanbanBoardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kb = new KanbanBoard();
        $kb->name = "First board";
        $kb->description = "This is the first created kanban board";
        $kb->save();
    }
}
