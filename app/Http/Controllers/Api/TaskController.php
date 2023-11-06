<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Task;
use App\Models\TaskLog;
use App\Models\System;
use App\Models\Applicant;
use App\Models\Priority;
use App\Models\Status;
use App\Models\TaskType;

class TaskController extends Controller
{
    public function updateStatus(Request $request)
    {
        $task = Task::findOrFail($request->task_id);
        $task->status_id = $request->status_id;
        $task->save();
        return Task::where("status_id", "=", $request->status_id)->get();
    }

    public function getTask($id)
    {
        $task = Task::with(['Users', 'System', 'SubSystem', 'Priority', 'Status', 'Applicant', 'TaskLogs.User', 'TaskType'])->findOrFail($id);
        return $task;
    }

    public function addLogEntryToTask(Request $request)
    {
        //dd($request);
        $task = Task::find($request->task_id);
        $taskLog = new TaskLog(['description' => $request->entry_description, 'user_id' => Auth::id()]);
        $task->TaskLogs()->save($taskLog);
        return Task::with('TaskLogs.User')->findOrFail($request->task_id)->TaskLogs;
    }

    public function getTransferDestinationData($kanban_board_id)
    {
        $data['systems'] = System::where('kanban_board_id', $kanban_board_id)->orderBy('name_short', 'asc')->get();
        $data['applicants'] = Applicant::where('kanban_board_id', $kanban_board_id)->orderBy('name', 'asc')->get();
        $data['priorities'] = Priority::where('kanban_board_id', $kanban_board_id)->orderBy('order_number', 'asc')->get();
        $data['statuses'] = Status::where('kanban_board_id', $kanban_board_id)->orderBy('order_number', 'asc')->get();
        $data['taskTypes'] = TaskType::where('kanban_board_id', $kanban_board_id)->orderBy('name', 'asc')->get();
        return $data;
    }
}
