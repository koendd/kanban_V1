<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\KanbanBoard;
use App\Models\Applicant;

class ApplicantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(KanbanBoard $kanbanBoard)
    {
        $applicants = Applicant::where('kanban_board_id', $kanbanBoard->id)->orderBy('name', 'asc')->get();
        return view('Applicants.index', compact(['kanbanBoard', 'applicants']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(KanbanBoard $kanbanBoard)
    {
        return View('Applicants.create', compact('kanbanBoard'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(KanbanBoard $kanbanBoard, Request $request)
    {
        $applicant = new Applicant();
        $applicant->name = $request["name"];
        $applicant->kanban_board_id = $kanbanBoard->id;
        $applicant->save();
        return redirect()->route('applicants', $kanbanBoard->id);
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
    public function edit(KanbanBoard $kanbanBoard, Applicant $applicant)
    {
        return view('Applicants.edit', compact(['kanbanBoard', 'applicant']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(KanbanBoard $kanbanBoard, Applicant $applicant, Request $request)
    {
        $applicant->name = $request["name"];
        $applicant->save();
        return redirect()->route('applicants', $kanbanBoard->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
