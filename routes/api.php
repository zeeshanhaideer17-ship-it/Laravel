<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AssignmentController;


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

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ComplaintController;
use App\Http\Controllers\Api\FeedbackController;
use App\Http\Controllers\Api\FaqController;




Route::post('/login', [AuthController::class, 'login']);
Route::get('/users', [AuthController::class, 'index']);


Route::get('users/', [AuthController::class, 'index']);       // list all users
Route::post('users/', [AuthController::class, 'store']);      // create user
Route::get('users/{id}', [AuthController::class, 'show']);   // get single user
Route::put('users/{id}', [AuthController::class, 'update']); // update user
Route::delete('users/{id}', [AuthController::class, 'destroy']); // delete user



 Route::get('/complaints', [ComplaintController::class, 'view']);
Route::post('/complaints', [ComplaintController::class, 'store']);
Route::put('/complaints/{id}', [ComplaintController::class, 'update']);
Route::delete('/complaints/{id}', [ComplaintController::class, 'destroy']);
Route::get('/complaints/customer/{customerId}', [ComplaintController::class, 'customerComplaints']);


Route::post('/assignments', [AssignmentController::class, 'store']);
Route::put('/assignments/{id}', [AssignmentController::class, 'update']);
Route::delete('/assignments/{id}', [AssignmentController::class, 'destroy']);
Route::get('/assignments', [AssignmentController::class, 'index']);
Route::get('/assignments/{id}', [AssignmentController::class, 'show']);

Route::post('/feedback', [FeedbackController::class, 'store']);
Route::put('/feedback/{id}', [FeedbackController::class, 'update']);
Route::delete('/feedback/{id}', [FeedbackController::class, 'destroy']);
Route::get('/feedback', [FeedbackController::class, 'index']);
Route::get('/feedback/{id}', [FeedbackController::class, 'show']);
Route::post('/faqs', [FaqController::class, 'store']);      // admin
Route::put('/faqs/{id}', [FaqController::class, 'update']); // admin
Route::delete('/faqs/{id}', [FaqController::class, 'destroy']); // admin

Route::get('/faqs', [FaqController::class, 'index']);       // public
Route::get('/faqs/{id}', [FaqController::class, 'show']);


