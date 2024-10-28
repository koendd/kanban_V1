<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\KanbanBoard;
use App\Models\SubSystem;
use App\Models\System;

class SubSystemController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create(KanbanBoard $kanbanBoard)
   {
       $systems = System::where('kanban_board_id', $kanbanBoard->id)->orderBy('name_short', 'asc')->get();
       return view('SubSystems.create', compact(['kanbanBoard', 'systems']));
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
            'system_id' => ['required', 'exists:systems,id']
        ]);
        $subSystem = new SubSystem($validatedData);
        $subSystem->save();

        return redirect()->route('systems', compact('kanbanBoard'));
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(KanbanBoard $kanbanBoard, SubSystem $subSystem)
    {
        return View('SubSystems.show', compact(['kanbanBoard', 'subSystem']));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(KanbanBoard $kanbanBoard, SubSystem $subSystem)
    {
        $systems = System::where('kanban_board_id', $kanbanBoard->id)->orderBy('name_short', 'asc')->get();
        return View('SubSystems.edit', compact(['kanbanBoard', 'systems', 'subSystem']));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(KanbanBoard $kanbanBoard, SubSystem $subSystem, Request $request)
    {
        $validatedData = $request->validate([
            'name_short' => ['required', 'string', 'max:50'],
            'name_full' => ['required', 'string'],
            'description' => ['string', 'nullable'],
            'system_id' => ['required', 'exists:systems,id']
        ]);

        $subSystem->name_short = $request->name_short;
        $subSystem->name_full = $request->name_full;
        $subSystem->description = $request->description;
        $subSystem->system_id = $request->system_id;
        $subSystem->save();

        return redirect()->route('systems', $kanbanBoard->id);
    }
}
