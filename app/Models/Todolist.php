<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class Todolist extends Eloquent
{
    use HasFactory;
    protected $fillable = ['name', 'detail', 'todo_at', 'is_finish', 'is_finish_at'];
}
