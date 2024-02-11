<?php
use App\Http\Controllers\PersonController;
use Illuminate\Support\Facades\Route;

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
    Route::middleware(["auth"])->group(function () {
        Route::get('/', function () {
            return view('home');
        });
         //Persons
    Route::get('persons/', [PersonController::class, 'index'])->name('get.persons');
    Route::get('persons/relation', [PersonController::class, 'relation'])->name('person.relation');
    Route::get('persons/ajax_get_persons_list', [PersonController::class, 'ajax_get_persons_list'])->name('get.ajax_get_persons_list');

    
    });
    Auth::routes();

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
