<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\KanbanBoard;

class HomeController extends Controller
{
    public function Welcome() {
        $kanbanBoards = KanbanBoard::orderBy('name', 'asc')->get();
        
        if($kanbanBoards->count() == 1)
            return redirect()->route('home', $kanbanBoards->first()->id);

        return view('welcome', compact('kanbanBoards'));
    }
}
