<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\SchoolworkController;
use App\Http\Controllers\CommentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', function () {
    return redirect('home');
});

Route::get('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('logs-out-banned-user');

Route::resources([
    'users' => UserController::class,

    'classrooms' => ClassroomController::class,
    'subjects' => SubjectController::class,
    'teachers' => TeacherController::class,
    'students' => StudentController::class,
    'activities' => ActivityController::class,
    'schoolworks' => SchoolworkController::class,
]);

Route::get('activities/{uuid}/download', [ActivityController::class, 'download'])->name('activities.download');
Route::get('schoolworks/{uuid}/download', [SchoolworkController::class, 'download'])->name('schoolworks.download');

Route::post('/activity/{activity}/comment', [CommentController::class, 'activity_store'])->name('comments.activity_store');
Route::post('/schoolwork/{schoolwork}/comment', [CommentController::class, 'schoolwork_store'])->name('comments.schoolwork_store');

Route::delete('/comment/{id}', [CommentController::class, 'comment_destroy'])->name('comments.comment_destroy');

Route::get('/comment/{id}/edit', [CommentController::class, 'comment_edit'])->name('comments.comment_edit');
Route::put('comment/{id}', [CommentController::class, 'comment_update'])->name('comments.comment_update');

Route::get('activities/search', [ActivityController::class, 'search'])->name('activities.search');
Route::get('schoolworks/search', [SchoolworkController::class, 'search'])->name('schoolworks.search');

Route::get('markAsRead', function () {
    auth()->user()->unreadNotifications->markAsRead();
    return redirect()->back();
})->name('markAsRead');
