<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\KanbanBoard;
use App\Models\User;

class KanbanController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kanbanBoards = KanbanBoard::orderBy('name', 'asc')->get();
        return view('KanbanBoards.index', compact('kanbanBoards'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View('KanbanBoards.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $kanbanBoard = new KanbanBoard();
        $kanbanBoard->name = $request["name"];
        $kanbanBoard->description = $request["description"];
        $kanbanBoard->save();
        return redirect()->route('kanbanboards');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(KanbanBoard $kanbanBoard)
    {
        return view('KanbanBoards.edit', compact('kanbanBoard'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(KanbanBoard $kanbanBoard, Request $request)
    {
        $kanbanBoard->name = $request["name"];
        $kanbanBoard->description = $request["description"];
        $kanbanBoard->save();
        return redirect()->route('kanbanboards');
    }
}
