<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

use App\Models\User;
use App\Notifications\NewComment;
use App\Models\Comment;
use App\Models\Activity;
use App\Models\Schoolwork;
use Illuminate\Support\Facades\Auth;

class CommentListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $id = Auth::id();
        $authenticated_user = User::findOrFail($id);
        $comments = Comment::where('user_id', '=', $id)->latest()->first();
        if ($authenticated_user->hasRole(['Docente']) and $comments['activity_id'] != null) {
            $notified = User::join('students', 'users.id', '=', 'students.user_id')
                            ->join('classrooms', 'classrooms.id', '=', 'students.classroom_id')
                            ->join('teachers', 'classrooms.id', '=', 'teachers.classroom_id')
                            ->where('teachers.user_id', '=', $id)
                            ->select('users.*')
                            ->get();
        }
        if ($authenticated_user->hasRole(['Docente']) and $comments['schoolwork_id'] != null) {
            $notified = User::join('students', 'users.id', '=', 'students.user_id')
                            ->join('schoolworks', 'students.id', '=', 'schoolworks.student_id')
                            ->select('users.*')
                            ->get();
        }
        if ($authenticated_user->hasRole(['Estudiante']) and $comments['activity_id'] != null) {
            $notified = User::join('teachers', 'users.id', '=', 'teachers.user_id')
                            ->join('activities', 'teachers.id', '=', 'activities.teacher_id')
                            ->join('classrooms', 'classrooms.id', '=', 'teachers.classroom_id')
                            ->join('students', 'classrooms.id', '=', 'students.classroom_id')
                            ->where('students.user_id', '=', $id)
                            ->select('users.*')
                            ->get();
        }
        if ($authenticated_user->hasRole(['Estudiante']) != null and $comments['schoolwork_id'] != null) {
            $notified = User::join('teachers', 'users.id', '=', 'teachers.user_id')
                            ->join('activities', 'teachers.id', '=', 'activities.teacher_id')
                            ->join('schoolworks', 'activities.id', '=', 'schoolworks.activity_id')
                            ->join('classrooms', 'classrooms.id', '=', 'teachers.classroom_id')
                            ->join('students', 'classrooms.id', '=', 'students.classroom_id')
                            ->where('students.user_id', '=', $id)
                            ->select('users.*')
                            ->get();
        }
        $notified->except($event->comment->user_id)->each(function (User $user) use ($event) {
            Notification::send($user, new NewComment($event->comment));
        });
    }
}
