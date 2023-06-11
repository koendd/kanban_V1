@extends('Layouts.app')

@section('content')
<div class="row my-1" id="kanbanBoard">
    @foreach($statuses as $status)
    <div class="col w-auto h-100">
        <div class="card h-100 bg-transparent">
            <div class="card-header text-center" style="background-color: rgba({{$status->redColorValue()}}, {{$status->greenColorValue()}}, {{$status->blueColorValue()}}, 0.7 );">
                {{$status->name}}
                <span id="status{{$status->id}}Count">&#35;{{$status->Tasks->count()}}</span>
            </div>
            <div class="card-body overflow-auto drop-class" style="background-color: rgba({{$status->redColorValue()}}, {{$status->greenColorValue()}}, {{$status->blueColorValue()}}, 0.5)" ondrop="drop(event)" ondragover="allowDrop(event)" ondragenter="dragEnter(event)" ondragleave="dragLeave(event)" id="status{{$status->id}}">
                @foreach($status->Tasks as $task)
                <div class="card mb-2" style="opacity: .9" draggable="true" ondragstart="drag(event)" id="task{{$task->id}}">
                    <div class="card-header text-center cursor-pointer" style="background-color: rgba({{$task->priority->redColorValue()}}, {{$task->priority->greenColorValue()}}, {{$task->priority->blueColorValue()}}, 0.7 )">
                        {{$task->name}}
                    </div>
                    <div class="card-body">
                        @if($task->system)
                        <div>
                            <p class="m-0 fw-bold">System:</p>
                            <p class="m-0 ps-3">
                                {{$task->system->name_short}}
                                @if($task->subSystem)
                                 &#45; {{$task->subSystem->name_short}}
                                @endif
                            </p>
                        </div>
                        @endif
                        @if($task->description)
                        <div>
                            <p class="m-0 fw-bold">Description:</p>
                            <p class="m-0 ps-3">{{$task->description}}</p>
                        </div>
                        @endif
                        @if($task->deadline)
                        <div>
                            <p class="m-0 fw-bold">Deadline:</p>
                            <p class="m-0 ps-3">{{$task->deadline}}</p>
                        </div>
                        @endif
                        @if($task->Users->count())
                        <div>
                            <p class="m-0 fw-bold">Users:</p>
                            <p class="m-0 ps-3">
                                @foreach($task->Users as $user)
                                {{$user->name}}<br>
                                @endforeach
                            </p>
                        </div>
                        @endif
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-primary w-100" onclick="showTask({{$task->id}})">
                            Open task
                        </button>

                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Modal -->
<div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalTitle"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-2">
                    <div class="mb-3 row">
                        <label for="modalDescription" class="col-sm-2 col-form-label">Description</label>
                        <div class="col-sm-10"><textarea class="form-control" id="modalDescription" disabled ></textarea></div>
                    </div>
                    <div class="mb-3 row">
                        <label for="modalUsers" class="col-sm-2 col-form-label">Users</label>
                        <div class="col-sm-4"><input class="form-control" id="modalUsers" disabled /></div>
                        <label for="modalApplicant" class="col-sm-2 col-form-label">Applicant</label>
                        <div class="col-sm-4"><input class="form-control" id="modalApplicant" disabled /></div>
                    </div>
                    <div class="mb-3 row">
                        <label for="modalSystem" class="col-sm-2 col-form-label">System</label>
                        <div class="col-sm-4"><input class="form-control" id="modalSystem" disabled /></div>
                        <label for="modalSubSystem" class="col-sm-2 col-form-label">Sub-system</label>
                        <div class="col-sm-4"><input class="form-control" id="modalSubSystem" disabled /></div>
                    </div>
                    <div class="mb-3 row">
                        <label for="modalPriority" class="col-sm-2 col-form-label">Priority</label>
                        <div class="col-sm-4"><input class="form-control" id="modalPriority" disabled /></div>
                        <label for="modalStatus" class="col-sm-2 col-form-label">Status</label>
                        <div class="col-sm-4"><input class="form-control" id="modalStatus" disabled /></div>
                    </div>
                    <div class="mb-3 row">
                        <label for="modalDeadline" class="col-sm-2 col-form-label">Deadline</label>
                        <div class="col-sm-4"><input class="form-control" id="modalDeadline" disabled /></div>
                        <label for="modalType" class="col-sm-2 col-form-label">Type</label>
                        <div class="col-sm-4"><input class="form-control" id="modalType" disabled /></div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-md-6 offset-md-2">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <a href="#" class="btn btn-warning" id="modalEditBtn">Edit</a>
                        </div>
                    </div>
                </div>
                <div class="border-top">
                    <div class="mb-3 mt-2 row">
                        <label for="modalnewLogEntry" class="col-sm-2 col-form-label">New log entry</label>
                        <div class="col-sm-8"><textarea class="form-control" id="modalNewLogEntry" maxlength="1000"></textarea></div>
                        <div class="col-sm-2"><button type="button" class="btn btn-primary" onclick="addNewLogEntry()">Add log</button></div>
                    </div>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Date</th>
                            <th scope="col">User</th>
                            <th scope="col">Log entry</th>
                            </tr>
                        </thead>
                        <tbody id="modalLogEntries" class="table-group-divider">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" value="{{ Auth::user()->api_token }}" id="token" />


<script>
    let calledTaskId;

    function allowDrop(ev) {
        ev.preventDefault();
    }

    function dragEnter(ev) {
        ev.preventDefault();
        if (ev.target.id.includes("status")) {
            ev.target.classList.add("drop-space");
        }
    }

    function dragLeave(ev) {
        ev.preventDefault();
        if (ev.target.id.includes("status")) {
            ev.target.classList.remove("drop-space");
        }
    }

    function drag(ev) {
        ev.dataTransfer.setData("task", ev.target.id);
        ev.dataTransfer.setData("prevStatusId", document.querySelector("#" + ev.target.id).parentNode.id);
    }

    function drop(ev) {
        let token = document.querySelector("#token").value;
        if(ev.target.id.includes("status")) {
            ev.preventDefault();
            var data = ev.dataTransfer.getData("task");
            ev.target.appendChild(document.getElementById(data));

            let newStatusId = ev.target.id.replace(/.*status/g,"");
            let taskId = data.replace(/.*task/g,"");

            axios.post("{{route('updateTaskStatusApi')}}", {api_token: token, task_id: taskId, status_id: newStatusId})
                .then((response) => {
                    ev.target.classList.remove("drop-space");
                    document.querySelector("#status" + newStatusId + "Count").innerHTML = "#" + response.data.length;

                    if("#status" + newStatusId != "#" + ev.dataTransfer.getData("prevStatusId")){
                        let prevStatusCount = document.querySelector("#" + ev.dataTransfer.getData("prevStatusId") + "Count").innerHTML;
                        prevStatusCount = parseInt(prevStatusCount.replace("#", ""));
                        prevStatusCount -= 1;
                        document.querySelector("#" + ev.dataTransfer.getData("prevStatusId") + "Count").innerHTML = "#" + prevStatusCount;
                    }
                }).catch((err) => {
                    console.error("update error");
                });
        }
    }

    function showTask(taskId) {
        let token = document.querySelector("#token").value;
        axios.get("/api/task/" + taskId, {params: { "api_token": token}})
            .then((response) => {
                //console.log(response.data);

                calledTaskId = response.data.id;

                document.querySelector("#modalTitle").textContent = "";
                document.querySelector("#modalDescription").value = "";
                document.querySelector("#modalDeadline").value = "";
                document.querySelector("#modalUsers").value = "";
                document.querySelector("#modalApplicant").value = "";
                document.querySelector("#modalSystem").value = "";
                document.querySelector("#modalSubSystem").value = "";
                document.querySelector("#modalPriority").value = "";
                document.querySelector("#modalStatus").value = "";
                document.querySelector("#modalType").value = "";
                document.querySelector("#modalEditBtn").setAttribute('href', '/task/edit/' + calledTaskId);

                let usersString = "";
                response.data.users.forEach((user, index) => {
                    if(index > 0)
                        usersString += ", ";
                    usersString += user.name;
                });
                let applicantString = "";
                if(response.data.applicant != null)
                    applicantString = response.data.applicant.name;
                let systemString = response.data.system.name_short;
                if(response.data.system.name_full != "")
                    systemString += " - " + response.data.system.name_full;
                let subSystemString = "";
                if(response.data.sub_system != null) {
                    subSystemString = response.data.sub_system.name_short;
                    if(response.data.sub_system.name_full != "")
                        subSystemString += " - " + response.data.sub_system.name_full;
                }

                document.querySelector("#modalTitle").textContent = response.data.name;
                document.querySelector("#modalDescription").value = response.data.description;
                document.querySelector("#modalDeadline").value = response.data.deadline;
                document.querySelector("#modalUsers").value = usersString;
                document.querySelector("#modalApplicant").value = applicantString;
                document.querySelector("#modalSystem").value = systemString;
                document.querySelector("#modalSubSystem").value = subSystemString;
                document.querySelector("#modalPriority").value = response.data.priority.name;
                document.querySelector("#modalPriority").style.color = "#" + response.data.priority.color.toString(16);
                document.querySelector("#modalStatus").value = response.data.status.name;
                document.querySelector("#modalStatus").style.color = "#" + response.data.status.color.toString(16);
                document.querySelector("#modalType").value = response.data.task_type.name;

                let modalLogEntries = document.querySelector("#modalLogEntries");
                modalLogEntries.innerHTML = null;
                response.data.task_logs.forEach((log) => {
                    let row = modalLogEntries.insertRow(0);
                    let idCell = row.insertCell(0);
                    let dateCell = row.insertCell(1);
                    let userCell = row.insertCell(2);
                    let descriptionCell = row.insertCell(3);

                    idCell.innerHTML = log.id;
                    dateCell.innerHTML = new Date(log.created_at).toLocaleDateString();
                    userCell.innerHTML = log.user.name;
                    descriptionCell.innerHTML = descriptioneParser(log.description);
                });
            })
            .catch((err) => {
                console.error("task info error");
                console.log(err);
            });

        var modal = new bootstrap.Modal(document.querySelector('#taskModal'));
		modal.show();
    }

    function addNewLogEntry() {
        let token = document.querySelector("#token").value;
        let entryDescription = document.querySelector("#modalNewLogEntry").value;
        axios.post("{{route('addTaskLogEntryApi')}}", {api_token: token, task_id: calledTaskId, entry_description: entryDescription})
            .then((response) => {
                document.querySelector("#modalNewLogEntry").value = "";
                let modalLogEntries = document.querySelector("#modalLogEntries");
                modalLogEntries.innerHTML = null;
                response.data.forEach((log) => {
                    let row = modalLogEntries.insertRow(0);
                    let idCell = row.insertCell(0);
                    let dateCell = row.insertCell(1);
                    let userCell = row.insertCell(2);
                    let descriptionCell = row.insertCell(3);

                    idCell.innerHTML = log.id;
                    userCell.innerHTML = log.user.name;
                    dateCell.innerHTML = new Date(log.created_at).toLocaleDateString();
                    descriptionCell.innerHTML = descriptioneParser(log.description);
                });
            }).catch((err) => {
                console.error("update error");
            });
    }

    function descriptioneParser(string) {
        let username = "{{Auth::user()->name}}";
        string = string.replace(/(?:\r\n|\r|\n)/g, '<br>');
        var regex = new RegExp('(\\W|^)@('+username+')(\\W|$)', 'ig');
        return string.replace(regex, '$1<span class="label radius text-danger">@$2</span>$3');
    }
</script>
@endsection