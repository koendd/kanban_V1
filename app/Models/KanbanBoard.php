<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

Use App\Models\Status;
Use App\Models\Priority;
Use App\Models\TaskType;

class KanbanBoard extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description'
    ];

    // relationship functions
    public function Statuses()
    {
        return $this->hasMany(Status::class);
    }

    public function Priorities()
    {
        return $this->hasMany(Priority::class);
    }
}
