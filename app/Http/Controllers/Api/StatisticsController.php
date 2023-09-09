<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\KanbanBoard;
use App\Models\Status;
use App\Models\Priority;

class StatisticsController extends Controller
{
    public function getStatisticsData(KanbanBoard $kanbanBoard)
    {
        $statusStats = Status::withCount('tasks')->where('kanban_board_id', $kanbanBoard->id)->get();
        $priorityStats = Priority::withCount('tasks')->where('kanban_board_id', $kanbanBoard->id)->get();

        return ["statusStats" => $statusStats, "priorityStats" => $priorityStats];
    }
}
