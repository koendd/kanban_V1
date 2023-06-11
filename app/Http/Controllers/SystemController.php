<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
    public function index()
    {
        $systems = System::get();
        return view('Systems.index', compact('systems'));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {
       $kanbanBoards = KanbanBoard::orderBy('name', 'asc')->get();
       return view('Systems.create', compact('kanbanBoards'));
   }

   /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name_short' => ['required', 'string', 'max:50'],
            'name_full' => ['required', 'string'],
            'description' => ['string', 'nullable'],
            'kanban_board_id' => ['required', 'exists:kanban_boards,id']
        ]);
        $subSystem = new System($validatedData);
        $subSystem->save();

        return redirect()->route('system');
    }
}
