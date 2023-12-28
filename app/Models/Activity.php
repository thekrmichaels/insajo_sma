<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'teacher_id',
        'status',
        'name',
        'description',
        'since',
        'deadline',
        'uuid',
        'homework',
        'url',
    ];

    /**
     * Get the teacher that owns the activity.
     */
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comment')->whereNull('parent_id');
    }
}
