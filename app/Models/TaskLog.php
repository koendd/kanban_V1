<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Str;

class TaskLog extends Model
{
    use HasFactory;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['Timestamp', 'UpdateTimestamp', 'DescriptionFormatted'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'description',
        'task_id',
        'user_id',
    ];

    public function Task()
    {
        return $this->belongsTo(Task::class);
    }

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function getTimestampAttribute() {
        return Str::replaceFirst(' ', '<br>', Carbon::create($this->created_at)->format('j/n/o g:i:s a'));
    }

    public function getUpdateTimestampAttribute() {
        return Str::replaceFirst(' ', '<br>', Carbon::create($this->updated_at)->format('j/n/o g:i:s a'));
    }

    public function getDescriptionFormattedAttribute() {
        //dd($this->description);
        return nl2br($this->description);
    }
}
