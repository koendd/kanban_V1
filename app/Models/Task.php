<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\System;
use App\Models\SubSystem;
use App\Models\Applicant;
use App\Models\Priority;
use App\Models\Status;

class Task extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'deadline',
        'system_id',
        'sub_system_id',
        'applicant_id',
        'priority_id',
        'status_id'
    ];

    // relationship functions
    public function Users()
    {
        return $this->belongsToMany(User::class);
    }

    public function Creator()
    {
        return $this->belongsTo(User::class, 'creator_id', 'id');
    }

    public function System()
    {
        return $this->belongsTo(System::class);
    }

    public function SubSystem() 
    {
        return $this->belongsTo(SubSystem::class);
    }

    public function Applicant()
    {
        return $this->belongsTo(Applicant::class);
    }

    public function Priority()
    {
        return $this->belongsTo(Priority::class);
    }

    public function Status()
    {
        return $this->belongsTo(Status::class);
    }

    public function TaskLogs()
    {
        return $this->hasMany(TaskLog::class);
    }
}
