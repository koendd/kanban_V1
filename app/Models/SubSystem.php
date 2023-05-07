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

    public function System()
    {
        return $this->belongsTo(System::class);
    }

    public function Tasks()
    {
        return $this->hasMany(Task::class);
    }
}
