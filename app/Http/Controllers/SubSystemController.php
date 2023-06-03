<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
   public function create()
   {
       $systems = System::orderBy('name_short', 'asc')->get();
       return view('SubSystems.create', compact('systems'));
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
            'system_id' => ['required', 'exists:systems,id']
        ]);
        $subSystem = new SubSystem($validatedData);
        $subSystem->save();

        return redirect()->route('home');
    }
}
