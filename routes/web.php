<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\bills;
use App\Http\Middleware\subscription;

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
    return view('welcome');
});
//route for dashboard using bills controller


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    //check if user is subscribed 
    Route::middleware([subscription::class])->group(function () {
        Route::get('/dashboard', [bills::class, 'index'])->name('dashboard');
    });
    //billing portal
    
    Route::get('/billing-portal', function (Request $request) {
        return Auth::user()->redirectToBillingPortal(route('dashboard'));
    })->name('billing-portal');
    //bill routes

    //route to mark bill as paid
    Route::post('/dashboard/paid/{id}', [bills::class, 'paid']);
    //route to reset all bills to unpaid
    Route::post('/dashboard/reset', [bills::class, 'reset']);
    //delete bill
    Route::delete('/dashboard/delete/{id}', [bills::class, 'delete']);
    //route to create new bill
    Route::post('/dashboard', [bills::class, 'create']);

});

require __DIR__.'/auth.php';
