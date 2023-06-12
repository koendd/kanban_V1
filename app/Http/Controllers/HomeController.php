<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\KanbanBoard;

class HomeController extends Controller
{
    public function Welcome() {
        $kanbanBoards = KanbanBoard::orderBy('name', 'asc')->get();
        return view('welcome', compact('kanbanBoards'));
    }
}
