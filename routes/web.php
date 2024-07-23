<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Main\IndexController as HomeController;
use App\Http\Controllers\Admin\IndexController as AdminIndexController;
use App\Http\Controllers\Admin\EventsController as AdminEventsController;
use App\Http\Controllers\Admin\VenuesController as AdminVenuesController;
use App\Http\Controllers\Admin\ShowController as AdminShowEntityController;
use App\Http\Controllers\Admin\DeleteController as AdminDeleteEntityController;
use App\Http\Controllers\Admin\CreateController as AdminCreateEntityController;
use App\Http\Controllers\Admin\StoreController as AdminStoreEntityController;
use App\Http\Controllers\Admin\EditController as AdminEditEntityController;
use App\Http\Controllers\Admin\UpdateController as AdminUpdateEntityController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::namespace('App\Http\Controllers\Main')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('main.index');
});

Route::prefix('admin')->as('admin.')->namespace('App\Http\Controllers\Admin')->middleware('auth')->group(function () {
    Route::get('/', AdminIndexController::class)->name('index');
    Route::get('/events', AdminEventsController::class)->name('events');
    Route::get('/events/create', [AdminCreateEntityController::class, 'createEvent'])->name('create.event');
    Route::get('/events/{event}/edit', [AdminEditEntityController::class, 'editEvent'])->name('edit.event');
    Route::get('/events/{event}', [AdminShowEntityController::class, 'showEvent'])->name('show.event');
    Route::post('/events', [AdminStoreEntityController::class, 'storeEvent'])->name('events.post');
    Route::delete('/events/{event}', [AdminDeleteEntityController::class, 'deleteEvent'])->name('delete.event');
    Route::patch('/events/{event}', [AdminUpdateEntityController::class, 'updateEvent'])->name('update.event');
    Route::get('/venues', AdminVenuesController::class)->name('venues');
    Route::get('/venues/create', [AdminCreateEntityController::class, 'createVenue'])->name('create.venue');
    Route::post('/venues', [AdminStoreEntityController::class, 'storeVenue'])->name('venues.post');
    Route::delete('/venues/{venue}', [AdminDeleteEntityController::class, 'deleteVenue'])->name('delete.venue');
    Route::get('/venues/{venue}/edit', [AdminEditEntityController::class, 'editVenue'])->name('edit.venue');
    Route::patch('/venues/{venue}', [AdminUpdateEntityController::class, 'updateVenue'])->name('update.venue');
});

Route::prefix('auth')->as('auth.')->namespace('App\Http\Controllers\Auth')->group(function() {
    Route::get('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/login', [LoginController::class, 'loginPost'])->name('login.post');
    Route::get('/register', [RegisterController::class, 'register'])->name('register');
    Route::post('/register', [RegisterController::class, 'registerPost'])->name('register.post');
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
});
