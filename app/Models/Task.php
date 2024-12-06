<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // Import SoftDeletes trait

class Task extends Model
{
    use HasFactory;
    use SoftDeletes; // Enable soft deletes
    protected $table = 'tasks';
    protected $primaryKey = 'id';

    protected $fillable=[
        'title',
        'description',
        'description',
        'due_date',
        'deleted_at',
        'status'
    ];
}
