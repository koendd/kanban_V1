<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Task;
use App\Models\KanbanBoard;

class Status extends Model
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
        'order_number',
        'preparetion',
        'active',
        'finishing',
        'color',
        'kanban_board_id'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['colorHex'];

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
     * Get the color value in hex.
     *
     * @return string
     */
    public function getColorHexAttribute() {
        return dechex($this->color);
    }

    /**
     * Get the red color value.
     *
     * @return string
     */
    public function getRedColorValueAttribute()
    {
        return ($this->color & 0xFF0000) >> 16;
    }

    /**
     * Get the green color value.
     *
     * @return string
     */
    public function getGreenColorValueAttribute()
    {
        return ($this->color & 0x00FF00) >> 8;
    }

    /**
     * Get the blue color value.
     *
     * @return string
     */
    public function getBlueColorValueAttribute()
    {
        return $this->color & 0x0000FF;
    }
}
