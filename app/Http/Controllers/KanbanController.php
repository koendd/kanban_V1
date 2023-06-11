<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\KanbanBoard;

class KanbanController extends Controller
{
    public function PreparetionKanban(KanbanBoard $kanbanBoard)
    {
        $statuses = $kanbanBoard->Statuses->where('preparetion', true)->sortBy('order_number');
        return view('kanban', compact(['kanbanBoard', 'statuses']));
    }

    public function ActiveKanban(KanbanBoard $kanbanBoard)
    {
        $statuses = $kanbanBoard->Statuses->where('active', true)->sortBy('order_number');
        return view('kanban', compact(['kanbanBoard', 'statuses']));
    }

    public function FinishingKanban(KanbanBoard $kanbanBoard)
    {
        $statuses = $kanbanBoard->Statuses->where('finishing', true)->sortBy('order_number');
        return view('kanban', compact(['kanbanBoard', 'statuses']));
    }
}
