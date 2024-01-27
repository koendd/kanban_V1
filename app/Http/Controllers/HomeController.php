<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\KanbanBoard;

class HomeController extends Controller
{
    public function Welcome() {
        if(!Auth::User()->Role->can_use_multiple_kanban_boards) {
            return redirect()->route('home', Auth::User()->default_kanban_board_id);
        }

        $kanbanBoards = KanbanBoard::orderBy('name', 'asc')->get();
        
        if($kanbanBoards->count() == 1)
            return redirect()->route('home', $kanbanBoards->first()->id);

        return view('welcome', compact('kanbanBoards'));
    }
}
