<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\KanbanBoard;
use App\Models\Priority;

class PriorityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(KanbanBoard $kanbanBoard)
    {
        $priorities = Priority::where('kanban_board_id', $kanbanBoard->id)->orderBy('order_number', 'asc')->get();
        return view('Priorities.index', compact(['priorities', 'kanbanBoard']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(KanbanBoard $kanbanBoard)
    {
        return view('Priorities.create', compact('kanbanBoard'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(KanbanBoard $kanbanBoard, Request $request)
    {
        $priority = new Priority();
        $priority->name = $request["name"];
        $priority->description = $request["description"];
        $priority->order_number = $request["order_number"];
        $priority->color = hexdec($request["color"]);
        $priority->kanban_board_id = $kanbanBoard->id;
        $priority->save();

        return redirect()->route('priorities', $kanbanBoard->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(KanbanBoard $kanbanBoard, Priority $priority)
    {
        return view('Priorities.show', compact(['kanbanBoard', 'priority']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(KanbanBoard $kanbanBoard, Priority $priority)
    {
        return view('Priorities.edit', compact(['kanbanBoard', 'priority']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(KanbanBoard $kanbanBoard, Request $request, Priority $priority)
    {
        //dd($request);
        $priority->name = $request["name"];
        $priority->description = $request["description"];
        $priority->order_number = $request["order_number"];
        $priority->color = hexdec($request["color"]);
        $priority->kanban_board_id = $kanbanBoard->id;
        $priority->save();

        return redirect()->route('priorities', $kanbanBoard->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(KanbanBoard $kanbanBoard, Priority $priority)
    {
        //
    }
}
