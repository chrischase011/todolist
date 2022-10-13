<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PagesController;
use Illuminate\Support\Facades\Auth;
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

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'checkAccess'], function()
{
    Route::get('/addNew', [PagesController::class, 'addNewListIndex'])->name('pages.add_new');
    Route::post('/addNewList', [PagesController::class, 'addNewList'])->name('pages.add_new_list');
    Route::post('/editList', [PagesController::class, 'editList'])->name('pages.edit_list');
    Route::post('/getListByID', [PagesController::class, 'getListById'])->name('pages.get_list');
    Route::post('/markAsDone', [PagesController::class, 'markAsDone'])->name('pages.mark_done');
    Route::post('/markAsNotDone', [PagesController::class, 'markAsNotDone'])->name('pages.mark_not_done');
    Route::post('/deleteList', [PagesController::class, 'deleteList'])->name('pages.delete_list');
    Route::get('/datesDone', [HomeController::class, 'datesDoneIndex'])->name('pages.dates_done');
    Route::get("/gallery", [PagesController::class, 'galleryIndex'])->name("pages.gallery");
});
