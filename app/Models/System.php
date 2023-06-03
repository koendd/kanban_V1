<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\SubSystem;
use App\Models\Task;

class System extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name_short',
        'name_full',
        'description',
        'kanban_board_id'
    ];

    public function SubSystems()
    {
        return $this->hasMany(SubSystem::class);
    }

    public function Tasks()
    {
        return $this->hasMany(Task::class);
    }
}
