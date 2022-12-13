<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schoolwork extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'activity_id',
        'student_id',
        'uuid',
        'homework',
        'sent_at',
        'score',
        'scored_at',
        'modified_at',
    ];

    /**
     * Get the activity that owns the schoolwork.
     */
    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    /**
     * Get the student that owns the schoolwork.
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comment')->whereNull('parent_id');
    }
}
