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
        $systems = System::where('kanban_board_id', $kanbanBoard->id)->get();
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

        $subSystem = new System($validatedData);
        $subSystem->kanban_board_id = $kanbanBoard->id;
        $subSystem->save();

        return redirect()->route('systems', $kanbanBoard->id);
    }
}
