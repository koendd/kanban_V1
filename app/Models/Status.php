<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Task;
use App\Models\KanbanBoard;

class Status extends Model
{
    use HasFactory;

    // relationship functions
    public function Tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function KanbanBoard()
    {
        return $this->belongsTo(KanbanBoard::class);
    }

    // getters
    /**
     * Get the red color value.
     *
     * @return string
     */
    public function redColorValue()
    {
        return ($this->color & 0xFF0000) >> 16;
    }

    /**
     * Get the green color value.
     *
     * @return string
     */
    public function greenColorValue()
    {
        return ($this->color & 0x00FF00) >> 8;
    }

    /**
     * Get the blue color value.
     *
     * @return string
     */
    public function blueColorValue()
    {
        return $this->color & 0x0000FF;
    }
}
