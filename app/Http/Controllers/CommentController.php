<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

use App\Models\Activity;
use App\Models\Schoolwork;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;

use App\Notifications\NewComment;
use App\Models\User;
use App\Events\CommentEvent;

class CommentController extends Controller
{
    public function activity_store(/*Request*/ StoreCommentRequest $request, Activity $activity)
    {
        $comment = new Comment();
        $comment->content = $request->content;
        $comment->parent_id = $request->parent_id;
        $comment->user_id = \auth()->id();

        if ($comment->content == null) {
            return \redirect()->route('activities.show', $activity);
        } else {
            $activity->comments()->save($comment);

            /*
            $comment = DB::table('comments')
                ->latest()
                ->first();

            $notification = Notification::create([
                'content' => 'Tienes un mensaje nuevo.',
                'comment_id' => $comment->id,
            ]);
            */
            // auth()->user()->notify(new NewComment($comment));

            /*
            User::all()->except($comment->user_id)->each(function(User $user) use ($comment){
                $user->notify(new NewComment($comment));
            });
            */
            event(new CommentEvent($comment));

            return \redirect()->route('activities.show', $activity);
        }
    }

    public function schoolwork_store(/*Request*/ StoreCommentRequest $request, Schoolwork $schoolwork)
    {
        $comment = new Comment();
        $comment->content = $request->content;
        $comment->parent_id = $request->parent_id;
        $comment->user_id = \auth()->id();

        if ($comment->content == null) {
            return \redirect()->route('schoolworks.show', $schoolwork);
        } else {
            $schoolwork->comments()->save($comment);

            /*
            $comment = DB::table('comments')
                ->latest()
                ->first();

            $notification = Notification::create([
                'content' => 'Tienes un mensaje nuevo.',
                'comment_id' => $comment->id,
            ]);
            */
            // auth()->user()->notify(new NewComment($comment));

            /*
            User::all()->except($comment->user_id)->each(function(User $user) use ($comment) {
                $user->notify(new NewComment($comment));
            });
            */
            event(new CommentEvent($comment));

            return \redirect()->route('schoolworks.show', $schoolwork);
        }
    }

    public function comment_destroy($id)
    {
        $comment = Comment::find($id);
        $child_comment = Comment::where('comments.parent_id', $id)->count();
        if ($child_comment <= 0) {
            Comment::destroy($id);
        }
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function comment_edit($id)
    {
        $comment = Comment::find($id);
        $child_comment = Comment::where('comments.parent_id', $id)->count();
        if ($child_comment <= 0) {
            return view('comments.edit')->withComment($comment);
        }
        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function comment_update(/*Request*/ UpdateCommentRequest $request, $id)
    {
        $comment = Comment::findOrFail($id);
        $comment->content = $request->content;
        if ($comment->content == null) {
            return back();
        } else {
            $comment->save();
        }
        if ($comment->activity_id == null) {
            return redirect()->route('schoolworks.show', $comment->schoolwork->id);
        } else {
            return redirect()->route('activities.show', $comment->activity->id);
        }
    }
}
