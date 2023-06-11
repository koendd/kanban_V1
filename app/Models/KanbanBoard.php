<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

Use App\Models\Status;

class KanbanBoard extends Model
{
    use HasFactory;

    // relationship functions
    public function Statuses()
    {
        return $this->hasMany(Status::class);
    }
}
