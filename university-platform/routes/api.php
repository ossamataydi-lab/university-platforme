<?php

use App\Http\Controllers\AchivementController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExamesController;
use App\Http\Controllers\ExerciceController;
use App\Http\Controllers\FilierContoller;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubmissionController;
use Faker\Guesser\Name;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])
    ->name('dashboardes.index');

Route::get('/contact', [ContactController::class, 'index'])->name('contact.form');
Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');


//login and register
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('register', [AuthController::class, 'register'])->name('register');
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('student.dashboard', [AuthController::class, 'authenticated'])->name('student.dashboard');
Route::get('teacher.dashboard', [AuthController::class, 'authenticated'])->name('teacher.dashboard');
Route::get('teacher.courses', [AuthController::class, 'courses'])->name('teacher.courses');

// about
Route::get('/about', function () {
    return view('about');
})->name('about');

//contact
// Route::get('/contact', function () {
//     return view('contact');
// })->name('contact.form');
Route::get('/contact', [ContactController::class, 'index'])->name('contact.form');
Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');


//filieres
Route::resource('filier', FilierContoller::class)->middleware('auth');

//coures
Route::middleware('auth')->group(function () {
    Route::resource('courses', CoursesController::class);
    Route::get('courses/{course}/download', [CoursesController::class, 'download'])->name('courses.download');
    // Route::delete('/courses/{id}/delete', [CoursesController::class, 'destroy'])->name('courses.destroy');
});

//chat
Route::middleware('auth')->group(function () {
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{id}', [MessageController::class, 'chat'])->name('messages.chat');
    Route::post('/messages/{id}', [MessageController::class, 'send'])->name('messages.send');
    Route::post('/chat/send/{id}', [MessageController::class, 'sendMessage'])->name('chat.send');
    Route::get('/chat/messages/{id}', [MessageController::class, 'receive'])->name('chat.receive');
    Route::post('/messages/{id}', [MessageController::class, 'send'])->name('messages.send');
    Route::post('/chat/send', [MessageController::class, 'sendMessage'])->name('chat.send');
    Route::get('/chat/messages/{id}', [MessageController::class, 'receive'])->name('chat.receive');
    Route::post('/chat/typing', [MessageController::class, 'typing'])->name('chat.typing');
    Route::post('/chat/mark-read/{id}', [MessageController::class, 'markAsRead'])->name('chat.mark-read');
    Route::post('/chat/online', [MessageController::class, 'goOnline'])->name('chat.online');
    Route::post('/chat/offline', [MessageController::class, 'goOffline'])->name('chat.offline');
    Route::delete('/chat/messages/{id}', [MessageController::class, 'deleteMessage'])->name('chat.delete-message');
    Route::put('/chat/messages/{id}', [MessageController::class, 'editMessage'])->name('chat.edit-message');
    Route::post('/chat/groups', [MessageController::class, 'createGroup'])->name('chat.create-group');
});

//exames
Route::get('exames', [ExamesController::class, 'index'])->name('exames.index');
Route::get('exames/create', [ExamesController::class, 'create'])->name('exames.create');
Route::post('exames/store', [ExamesController::class, 'store'])->name('exames.store');
Route::get('exames/{exame}/download', [ExamesController::class, 'download'])->name('exame.download');
Route::delete('exames/{exame}', [ExamesController::class, 'destroy'])->name('exames.destroy');

// Exercices
Route::get('exercises', [ExerciceController::class, 'index'])->name('exercises.index');
Route::get('exercises/create', [ExerciceController::class, 'create'])->name('exercises.create');
Route::post('exercises/store', [ExerciceController::class, 'store'])->name('exercises.store');
Route::get('exercises/{exercise}', [ExerciceController::class, 'show'])->name('exercises.show');
Route::get('exercises/{exercise}/download', [ExerciceController::class, 'download'])->name('exercises.download');
Route::delete('exercises/{exercise}', [ExerciceController::class, 'destroy'])->name('exercises.destroy');

// submission
Route::get('exercises/{exercise}/submissions', [SubmissionController::class, 'index'])->name('submissions.index'); // teacher
Route::get('exercises/{exercise}/submit', [SubmissionController::class, 'create'])->name('submissions.create');    // student form
Route::post('exercises/{exercise}/submit', [SubmissionController::class, 'store'])->name('submissions.store');    // student upload
Route::get('submissions/{submission}/edit', [SubmissionController::class, 'edit'])->name('submissions.edit');      // teacher correct
Route::put('submissions/{submission}', [SubmissionController::class, 'update'])->name('submissions.update');      // teacher update
Route::get('submissions/{submission}/download', [SubmissionController::class, 'download'])->name('submissions.download');

// profile
Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');

Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

//module
Route::resource('modules', ModuleController::class)->middleware('auth');

//notification
Route::middleware('auth')->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])
        ->name('notifications.index')
        ->middleware('auth');
    Route::post('/notifications/send', [NotificationController::class, 'send'])->name('notifications.send');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');



    //dashboard

    // Route::get('/dashboardes', [DashboardController::class, 'index'])->name('dashboardes.index');
    //achievement
    Route::get('achivement', [AchivementController::class, 'studentAchivement'])->name('achivement')
        ->middleware('auth');
});
