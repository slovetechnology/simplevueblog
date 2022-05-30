<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:sanctum')->get('/authenticated', function (Request $request) {
    return true;
});

Route::post('/user/register', [RegisterController::class, 'store']);
Route::post('/user/login', [LoginController::class, 'store']);
Route::post('/logoutuser', [LoginController::class, 'logoutuser']);
Route::get('/allusers', [DashboardController::class, 'allusers']);
Route::post('/posttextonly', [DashboardController::class, 'posttextonly']);
Route::get('/allposts', [DashboardController::class, 'allposts']);
Route::post('/updateprofile', [DashboardController::class, 'updateprofile']);
Route::get('/deleteaccount', [DashboardController::class, 'deleteaccount']);
Route::post('/likepost/{id}', [DashboardController::class, 'likepost']);
Route::post('/unlikepost/{id}', [DashboardController::class, 'unlikepost']);
Route::get('/checklike/{id}', [DashboardController::class, 'checklike']);
Route::get('/likebyuser/{id}', [DashboardController::class, 'likebyuser']);
Route::get('/getloves/{id}', [DashboardController::class, 'getloves']);
Route::post('/postlove/{id}', [DashboardController::class, 'postlove']);
Route::get('/lovebyuser/{id}', [DashboardController::class, 'lovebyuser']);
Route::post('/deletelove/{id}', [DashboardController::class, 'deletelove']);
Route::post('/submitReply/{id}', [DashboardController::class, 'submitReply']);
Route::get('/getsingles/{id}', [DashboardController::class, 'getsingles']);
Route::get('/getpostcount/{id}', [DashboardController::class, 'getpostcount']);
Route::get('/getreplys/{id}', [DashboardController::class, 'getreplys']);
Route::get('/singleuser/{id}', [DashboardController::class, 'singleuser']);
Route::get('/getuserreplies/{id}', [DashboardController::class, 'getuserreplies']);
Route::get('/postsbyuser/{id}', [DashboardController::class, 'postsbyuser']);
Route::get('/userliked/{id}', [DashboardController::class, 'userliked']);
Route::get('/userloved/{id}', [DashboardController::class, 'userloved']);
Route::post('/addPostwithImage', [DashboardController::class, 'addPostwithImage']);
Route::get('/getUserPosts/{id}', [DashboardController::class, 'getUserPosts']);
Route::post('/usermail', [LoginController::class, 'usermail']);
