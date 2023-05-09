<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Task;
use App\Models\TaskLog;

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
        $task = Task::with(['Users', 'System', 'SubSystem', 'Priority', 'Status', 'Applicant', 'TaskLogs.User'])->findOrFail($id);
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
}
