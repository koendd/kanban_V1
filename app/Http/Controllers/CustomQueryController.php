<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class CustomQueryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contents = File::get(base_path('custom-queries.json'));
        $queries = json_decode($contents, true);
        return view('CustomQueries.index', compact('queries'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function runQuery($queryName, Request $request)
    {
        $contents = File::get(base_path('custom-queries.json'));
        $queries = json_decode($contents, true);
        if(!Arr::exists($queries, $queryName)) {
            abort(404);
        }
        $query = $queries[$queryName];
        $DBquery = $query['query'];
        
        $parameters = [];
        if(Arr::exists($query, 'parameters')) {
            $parameters = $query['parameters'];

            foreach($parameters as $key => $parameter) {
                if($parameter["inputType"] == "select") {
                    
                    if($parameter["dataType"] == "query") {
                        $DBdata = DB::select(DB::raw($parameters[$key]['query']));
                        $data = [];
                        foreach($DBdata as $record) {
                            $data = Arr::add($data, Arr::first($record), Arr::last($record));
                        }
                        $parameters[$key] = Arr::add($parameters[$key], "data", $data);
                    }
                }

                if(Arr::exists($request, $key)) {
                    $parameters[$key] = Arr::add($parameters[$key], "old_value", $request[$key]);
                    $DBquery = Str::replace(">>" . $key, $request[$key], $DBquery);
                }
            }
        }

        if(!Arr::exists($query, 'parameters')) {
            $results = DB::select(DB::raw($query['query'])->getValue(DB::connection()->getQueryGrammar()));
        }elseif (Arr::exists($query, 'parameters') && Arr::exists($request, '_token')) {
            //dd($DBquery);
            $results = DB::select(DB::raw($DBquery)->getValue(DB::connection()->getQueryGrammar()));
        } else {
            $results = null;
        }
        
        return view('CustomQueries.result', compact(['parameters', 'query', 'results']));
    }
}
