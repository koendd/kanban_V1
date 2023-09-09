@extends('Layouts.app')

@section('title', 'Kanban statistics')

@section('content')
<div class="d-flex justify-content-between">
    <div class="ms-5 p-2">
        <h3>Status</h3>
    </div>
</div>
@if($statusStats->count() > 0)
<div class="position-relative row">
    <div class="col-6">
        <div class="table-responsive">
            <table class="table table-striped align-middle table-bordered border-dark">
                <caption>List of all statuses and the amount of tasks for each status</caption>
                <thead>
                    <tr>
                        <th scope="col" class="text-center align-middle">Id</th>
                        <th scope="col" class="text-center align-middle">Name</th>
                        <th scope="col" class="text-center align-middle d-none d-md-table-cell">Description</th>
                        <th scope="col" class="text-center align-middle">tasks</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($statusStats as $statusStat)
                    <tr>
                        <td>{{$statusStat->id}}</td>
                        <td>{{$statusStat->name}}</td>
                        <td class="d-none d-md-table-cell">{{$statusStat->description}}</td>
                        <td>{{$statusStat->tasks_count}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-6" id="statusVisChart">
    </div>
</div>
@else
@endif

<div class="d-flex justify-content-between">
    <div class="ms-5 p-2">
        <h3>Priorities</h3>
    </div>
</div>
@if($priorityStats->count() > 0)
<div class="position-relative row">
    <div class="col-6">
        <div class="table-responsive">
            <table class="table table-striped align-middle table-bordered border-dark">
                <caption>List of all priorities and the amount of tasks for each priority</caption>
                <thead>
                    <tr>
                        <th scope="col" class="text-center align-middle">Id</th>
                        <th scope="col" class="text-center align-middle">Name</th>
                        <th scope="col" class="text-center align-middle d-none d-sm-table-cell">Description</th>
                        <th scope="col" class="text-center align-middle">tasks</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($priorityStats as $priorityStat)
                    <tr>
                        <td>{{$priorityStat->id}}</td>
                        <td>{{$priorityStat->name}}</td>
                        <td>{{$priorityStat->description}}</td>
                        <td>{{$priorityStat->tasks_count}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-6" id="priorityVisChart">
    </div>
</div>
@else
@endif


<input type="hidden" value="{{ Auth::user()->api_token }}" id="token" />
<script>
window.onload = (event) => {
        console.log("on load");

        let token = $("#token").val();
        axios.get("{{route('getStatisticsDataApi', $kanbanBoard->id)}}", {params: { "api_token": token}})
        .then(function(response){
            console.log("data loaded");
            console.info(response.data);

            loadStatistics(response.data.statusStats, "#statusVisChart");
            loadStatistics(response.data.priorityStats, "#priorityVisChart");
        }).catch(function (error) {
            // handle error
            console.log(error);
        });
    }
</script>
@endSection