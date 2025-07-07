<?php

use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\OrganizationalStructureController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SponsorController;
use App\Http\Controllers\UserController;
use App\Models\Sponsor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'store'])->name('login.post');

Route::middleware(['auth'])->group(function () {
    Route::get('/logout', function () {
        Auth::logout();
        return redirect()->route('login');
    })->name('logout');
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('admin', AdminController::class);
    Route::post('event/{id}/update-status-participant', [EventController::class, 'updateStatusParticipant'])->name('event.update-status-participant');
    Route::resource('event', EventController::class);
    Route::resource('sponsor', SponsorController::class);
    Route::resource('member', MemberController::class);
    Route::resource('organizational-structure', OrganizationalStructureController::class);
    Route::resource('about-us', AboutUsController::class);
    Route::resource('setting', SettingController::class);
    Route::post('blog/upload', [BlogController::class, 'upload'])->name('blog.upload');
    Route::resource('blog', BlogController::class);
    Route::resource('user', UserController::class);
});
