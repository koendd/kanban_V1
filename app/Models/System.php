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

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['name'];

    public function SubSystems()
    {
        return $this->hasMany(SubSystem::class)->orderBy('name_short', 'asc');
    }

    public function Tasks()
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Get the formated name of the system
     *
     * @return string
     */
    public function getnameAttribute() {
        $name = $this->name_short;

        if($this->name_full != "") {
            $name .= " - " . $this->name_full;
        }

        return $name;
    }
}
