<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\System;
use App\Models\Task;

class SubSystem extends Model
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
        'system_id',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['name'];

    public function System()
    {
        return $this->belongsTo(System::class);
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
