<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Str;

class TaskStatusChangeLog extends Model
{
    use HasFactory;

    public function Task() {
        return $this->belongsTo(Task::class);
    }

    public function User() {
        return $this->belongsTo(User::class);
    }

    public function OldStatus() {
        return $this->belongsTo(Status::class, 'old_status_id');
    }

    public function NewStatus() {
        return $this->belongsTo(Status::class, 'new_status_id');
    }

    public function getTimestampAttribute() {
        return Str::replaceFirst(' ', '<br>', Carbon::create($this->created_at)->format('j/n/o g:i:s a'));
    }
}
