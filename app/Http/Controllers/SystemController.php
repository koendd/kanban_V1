<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Models\KanbanBoard;
use App\Models\System;

class SystemController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(KanbanBoard $kanbanBoard)
    {
        $systems = System::where('kanban_board_id', $kanbanBoard->id)->orderBy("name_short", 'asc')->get();
        return view('Systems.index', compact(['kanbanBoard', 'systems']));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create(KanbanBoard $kanbanBoard)
   {
       return view('Systems.create', compact('kanbanBoard'));
   }

   /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(KanbanBoard $kanbanBoard, Request $request)
    {
        $validatedData = $request->validate([
            'name_short' => ['required', 'string', 'max:50'],
            'name_full' => ['required', 'string'],
            'description' => ['string', 'nullable'],
            'kanban_board_id' => ['required', 'exists:kanban_boards,id']
        ]);

        if($kanbanBoard->id != $request->kanban_board_id)
            return redirect()->route('createSystem', $request->kanban_board_id)->withErrors(['kanban_board_id' => true])->withInput();

        $system = new System($validatedData);
        $system->kanban_board_id = $kanbanBoard->id;
        $system->save();

        return redirect()->route('systems', $kanbanBoard->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(KanbanBoard $kanbanBoard, System $system)
    {
        return View('Systems.show', compact(['kanbanBoard', 'system']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(KanbanBoard $kanbanBoard, System $system)
    {
        return view('Systems.edit', compact(['kanbanBoard', 'system']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(KanbanBoard $kanbanBoard, Request $request, System $system)
    {
        $validatedData = $request->validate([
            'name_short' => ['required', 'string', 'max:50'],
            'name_full' => ['required', 'string'],
            'description' => ['string', 'nullable'],
            'kanban_board_id' => ['required', 'exists:kanban_boards,id']
        ]);

        if($kanbanBoard->id != $request->kanban_board_id)
            return redirect()->route('editSystem', $request->kanban_board_id)->withErrors(['kanban_board_id' => true])->withInput();

        $system->name_short = $request->name_short;
        $system->name_full = $request->name_full;
        $system->description = $request->description;
        $system->save();

        return redirect()->route('systems', $kanbanBoard->id);
    }
}
