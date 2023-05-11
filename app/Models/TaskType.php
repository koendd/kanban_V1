<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskType extends Model
{
    use HasFactory;

    // relationship functions
    public function Tasks()
    {
        return $this->hasMany(Task::class);
    }
}
