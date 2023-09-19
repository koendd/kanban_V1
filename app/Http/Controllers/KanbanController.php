<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\KanbanBoard;
use App\Models\User;

class KanbanController extends Controller
{
    public function PreparetionKanban(KanbanBoard $kanbanBoard)
    {
        $statuses = $kanbanBoard->Statuses->where('preparetion', true)->sortBy('order_number');
        $users = User::select('name')->orderBy('name', 'asc')->get()->pluck('name')->toArray();
        return view('kanban', compact(['kanbanBoard', 'statuses', 'users']));
    }

    public function ActiveKanban(KanbanBoard $kanbanBoard)
    {
        $statuses = $kanbanBoard->Statuses->where('active', true)->sortBy('order_number');
        $users = User::select('name')->orderBy('name', 'asc')->get()->pluck('name')->toArray();
        return view('kanban', compact(['kanbanBoard', 'statuses', 'users']));
    }

    public function FinishingKanban(KanbanBoard $kanbanBoard)
    {
        $statuses = $kanbanBoard->Statuses->where('finishing', true)->sortBy('order_number');
        $users = User::select('name')->orderBy('name', 'asc')->get()->pluck('name')->toArray();
        return view('kanban', compact(['kanbanBoard', 'statuses', 'users']));
    }
}
