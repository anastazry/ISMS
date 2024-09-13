<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MandorController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('admin')->group(function () {
    Route::get('/create-newuser', [AdminController::class, 'returnRegisterNewUserPage'])->name('admin-users-registration-form');
    Route::post('/register', [AdminController::class, 'registerUser'])->name('admin.register.post');
    Route::get('/user-list', [AdminController::class, 'getAllUserList'])->name('admin.users-list');
    Route::get('/create-qr', [AdminController::class, 'createQR'])->name('admin.create-qr');
    Route::post('/assign-task', [AdminController::class, 'assignTaskToMandor'])->name('admin.assign-task');
    Route::get('/assignment-lists', [AdminController::class, 'getAssignmentList'])->name('admin.assign-list');
});
Route::get('/user/update-fruit-details/{assignment_id}', [MandorController::class, 'updateFruitDetails'])->name('mandor-update-fruit-details'); 
Route::post('/user/insert-fruit-details/', [MandorController::class, 'insertFruitDetails'])->name('mandor-insert-fruit-details'); 

require __DIR__.'/auth.php';
