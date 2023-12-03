<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\KanbanBoard;
use App\Models\Status;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(KanbanBoard $kanbanBoard)
    {
        $statuses = Status::where('kanban_board_id', $kanbanBoard->id)->orderBy('order_number', 'asc')->get();
        return view('Statuses.index', compact(['statuses', 'kanbanBoard']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(KanbanBoard $kanbanBoard)
    {
        return View('Statuses.create', compact('kanbanBoard'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(KanbanBoard $kanbanBoard, Request $request)
    {
        $status = new Status();
        $status->name = $request["name"];
        $status->description = $request["description"];
        $status->order_number = $request["order_number"];
        $status->preparetion = $request->has('preparetion') ? true : false;
        $status->active = $request->has('active') ? true : false;
        $status->finishing = $request->has('finishing') ? true : false;
        $status->color = hexdec($request["color"]);
        $status->kanban_board_id = $kanbanBoard->id;
        $status->save();

        return redirect()->route('statuses', $kanbanBoard->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(KanbanBoard $kanbanBoard, Status $status)
    {
        return View('Statuses.show', compact(['kanbanBoard', 'status']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(KanbanBoard $kanbanBoard, Status $status)
    {
        return View('Statuses.edit', compact(['kanbanBoard', 'status']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(KanbanBoard $kanbanBoard, Request $request, Status $status)
    {
        $status->name = $request["name"];
        $status->description = $request["description"];
        $status->order_number = $request["order_number"];
        $status->preparetion = $request->has('preparetion') ? true : false;
        $status->active = $request->has('active') ? true : false;
        $status->finishing = $request->has('finishing') ? true : false;
        $status->color = hexdec($request["color"]);
        $status->kanban_board_id = $kanbanBoard->id;
        $status->save();

        return redirect()->route('statuses', $kanbanBoard->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(KanbanBoard $kanbanBoard, Status $status)
    {
        //
    }
}
