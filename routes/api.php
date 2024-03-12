<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MarksController;
use App\Http\Controllers\PaperController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\CombinationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\CalendarEventController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::/*middleware(['auth:sanctum'])->*/prefix('v1/application')->name('api.')->group(function () {
    Route::get('/', [ApplicationController::class, 'all'])->name('application');
    Route::get('/', [CalendarEventController::class, 'all'])->name('calendar');
    Route::get('/', [CombinationController::class, 'all'])->name('combination');
    Route::get('/', [MarksController::class, 'all'])->name('marks');
    Route::get('/', [NotificationController::class, 'all'])->name('notification');
    Route::get('/', [PaperController::class, 'all'])->name('paper');
    Route::get('/', [SchoolController::class, 'all'])->name('school');
    Route::get('/', [SubjectController::class, 'all'])->name('subject');
});
