<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\KanbanBoard;
use App\Models\Status;
use App\Models\Priority;
use App\Models\TaskType;

class StatisticsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function getFullStatistics(KanbanBoard $kanbanBoard)
    {
        $statusStats = Status::withCount('tasks')->where('kanban_board_id', $kanbanBoard->id)->get();
        $priorityStats = Priority::withCount('tasks')->where('kanban_board_id', $kanbanBoard->id)->get();

        return view('Statistics.fullStatistics', compact(['kanbanBoard', 'statusStats', 'priorityStats']));;
    }
}
