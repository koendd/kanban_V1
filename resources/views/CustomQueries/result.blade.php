@extends('Layouts.app')

@section('title', 'Custom queries')

@section('content')
<div>
    <div class="p-2">
        <h1>Custom query: <span class="text-primary">{{$query['name']}}</span></h1>
    </div>
    @if($parameters)
    <div class="p-2">
        <form method='get' class="row gy-2 gx-3 align-items-center">
            @csrf

            <div class="row mb-1 justify-content-center">
                @foreach($parameters as $paramKey => $param)
                <div class="col-md-3">
                    <div class="input-group">
                        <div class="input-group-text" style="width: 7rem;">{{$param['title']}}</div>
                        @if($param['inputType'] == "select")
                        <select class="form-select" name="{{$paramKey}}" required>
                            <option value="" disabled @if(!Arr::exists($param, 'old_value')) selected @endif>Select a value</option>
                            @foreach($param["data"] as $key => $value)
                            <option value="{{$key}}" @if(Arr::exists($param, 'old_value') and $param['old_value'] == $key) selected @endif>{{$value}}</option>
                            @endforeach
                        </select>
                        @else
                        <input type="{{$param['inputType']}}" name="{{$paramKey}}" class="form-control" required @if(Arr::exists($param, 'old_value')) value="{{$param['old_value']}}" @endif/>
                        @endif
                    </div>
                </div>
                @endforeach
                <div class="d-grid gap-2 col-1">
                    <button type="submit" class="btn btn-primary ">Run query</button>
                </div>
            </div>
        </form>
    </div>        
    @endif
</div>

@if(is_array($results))
<div class="position-relative row">
    <div class="col-6 offset-md-3">
        @if(count($results) > 0)
        <div class="table-responsive">
            <table class="table table-striped align-middle table-bordered border-dark">
                <caption>Results of custom query&colon; &quot;{{$query['name']}}&quot;&comma; {{count($results)}} in total.</caption>
                <thead>
                    <tr>
                        @foreach($query['tableHeaders'] as $key => $headerName)
                        <th scope="col" class="text-center align-middle">{{$headerName}}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($results as $result)
                    <tr>
                        @foreach($query['tableHeaders'] as $key => $headerName)
                        <td class="text-center align-middle">{{$result->$key}}</td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="fs-5">There are no results for this query.</p>
        @endif
    </div>
</div>
@else
@endif
@endsection