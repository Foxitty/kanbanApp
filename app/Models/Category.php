<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'board_id', 'position', 'color'];

    public function tasks()
    {
        return $this->hasMany(Task::class)->orderBy('position');
    }

    public function board()
    {
        return $this->belongsTo(Board::class);
    }
}
