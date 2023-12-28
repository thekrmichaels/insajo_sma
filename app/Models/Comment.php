<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content',
        'parent_id',
        'activity_id',
        'schoolwork_id',
    ];

    /**
     * Get the activity that owns the comment.
     */
    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    /**
     * Get the schoolwork that owns the comment.
     */
    public function schoolwork()
    {
        return $this->belongsTo(Schoolwork::class);
    }

    /**
     * Get the comment that owns the comment.
     */
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    /**
     * Get the replies for the comment.
     */
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
