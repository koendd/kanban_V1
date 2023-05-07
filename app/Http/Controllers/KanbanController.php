<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Status;

class KanbanController extends Controller
{
    public function PreparetionKanban()
    {
        $statuses = Status::where('preparetion', true)->orderBy('order_number', 'asc')->get();
        return view('kanban', compact('statuses'));
    }

    public function ActiveKanban()
    {
        $statuses = Status::where('active', true)->orderBy('order_number', 'asc')->get();
        return view('kanban', compact('statuses'));
    }

    public function FinishingKanban()
    {
        $statuses = Status::where('finishing', true)->orderBy('order_number', 'asc')->get();
        return view('kanban', compact('statuses'));
    }
}
